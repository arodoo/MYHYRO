<?php
ob_start();
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../../";
require_once('../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

$lasturl = $_SERVER['HTTP_REFERER'];

/*****************************************************\
 * Adresse e-mail => direction@codi-one.fr             *
 * La conception est assujettie à une autorisation     *
 * spéciale de codi-one.com. Si vous ne disposez pas de*
 * cette autorisation, vous êtes dans l'illégalité.    *
 * L'auteur de la conception est et restera            *
 * codi-one.fr                                         *
 * Codage, script & images (all contenu) sont réalisés * 
 * par codi-one.fr                                     *
 * La conception est à usage unique et privé.          *
 * La tierce personne qui utilise le script se porte   *
 * garante de disposer des autorisations nécessaires   *
 *                                                     *
 * Copyright ... Tous droits réservés auteur (Fabien B)*
  \*****************************************************/

// Check if user is logged in
if (isset($user)) {
    // Get parameters from POST
    $pays = isset($_POST['pays']) ? htmlspecialchars($_POST['pays']) : '';
    $poids = isset($_POST['poids']) ? floatval($_POST['poids']) : 0;
    $valeur = isset($_POST['valeur']) ? floatval($_POST['valeur']) : 0;
    $mode_expedition = isset($_POST['mode_expedition']) ? htmlspecialchars($_POST['mode_expedition']) : '';

    // Initialize result array
    $result = array();

    try {
        // Calculate shipping costs based on weight, destination and shipping method
        $frais_expedition = 0;
        $frais_douane = 0;
        $tva_import = 0;
        $message_info = '';

        // Validate inputs
        if (empty($pays)) {
            throw new Exception("Pays de destination non spécifié");
        }

        if ($poids <= 0) {
            throw new Exception("Poids non valide");
        }

        // Get country information from database
        $sql_pays = $bdd->prepare("SELECT * FROM pays_liste WHERE code = ? OR nom = ? LIMIT 1");
        $sql_pays->execute(array($pays, $pays));
        $pays_info = $sql_pays->fetch(PDO::FETCH_ASSOC);

        if (!$pays_info) {
            throw new Exception("Pays non trouvé dans la base de données");
        }

        $zone_geo = $pays_info['zone_geo'];
        $is_eu = $pays_info['is_eu'] == 1;

        // Get shipping rates based on zone, weight and method
        $sql_tarifs = $bdd->prepare("SELECT * FROM expedition_tarifs 
                                    WHERE zone_geo = ? 
                                    AND poids_min <= ? 
                                    AND poids_max >= ?
                                    AND mode = ?
                                    LIMIT 1");

        $sql_tarifs->execute(array($zone_geo, $poids, $poids, $mode_expedition));
        $tarif = $sql_tarifs->fetch(PDO::FETCH_ASSOC);

        if (!$tarif) {
            // Try to find a default rate
            $sql_tarifs = $bdd->prepare("SELECT * FROM expedition_tarifs 
                                        WHERE zone_geo = ? 
                                        AND poids_min <= ? 
                                        AND mode = 'standard'
                                        ORDER BY poids_max ASC
                                        LIMIT 1");

            $sql_tarifs->execute(array($zone_geo, $poids));
            $tarif = $sql_tarifs->fetch(PDO::FETCH_ASSOC);

            if (!$tarif) {
                $message_info = "Aucun tarif trouvé pour cette destination et ce poids";
                // Set a default value
                $frais_expedition = $poids * 15; // 15€ per kg as fallback
            } else {
                $frais_expedition = $tarif['tarif'];
                $message_info = "Tarif standard appliqué";
            }
        } else {
            $frais_expedition = $tarif['tarif'];
        }

        // Calculate customs fees for non-EU countries
        if (!$is_eu && $valeur > 0) {
            // Get customs rate from database or use default
            $sql_douane = $bdd->prepare("SELECT * FROM douane_tarifs WHERE pays = ? LIMIT 1");
            $sql_douane->execute(array($pays));
            $douane_info = $sql_douane->fetch(PDO::FETCH_ASSOC);

            if ($douane_info) {
                $taux_douane = $douane_info['taux_douane'];
                $taux_tva = $douane_info['taux_tva'];
            } else {
                // Default rates
                $taux_douane = 4.5; // 4.5%
                $taux_tva = 20;  // 20%
            }

            // Calculate customs fees
            $frais_douane = $valeur * ($taux_douane / 100);

            // Calculate import VAT (on value + customs fees)
            $tva_import = ($valeur + $frais_douane) * ($taux_tva / 100);

            $message_info = "Frais de douane et TVA à l'import calculés pour pays hors UE";
        } elseif ($is_eu) {
            $message_info = "Pays membre de l'UE - Pas de frais de douane";
        }

        // Round values to 2 decimals
        $frais_expedition = round($frais_expedition, 2);
        $frais_douane = round($frais_douane, 2);
        $tva_import = round($tva_import, 2);
        $total = round($frais_expedition + $frais_douane + $tva_import, 2);

        // Prepare result
        $result = array(
            "retour_validation" => "ok",
            "frais_expedition" => $frais_expedition,
            "frais_douane" => $frais_douane,
            "tva_import" => $tva_import,
            "total_frais" => $total,
            "pays" => $pays_info['nom'],
            "is_eu" => $is_eu,
            "zone_geo" => $zone_geo,
            "message" => $message_info
        );

    } catch (Exception $e) {
        $result = array(
            "retour_validation" => "non",
            "message" => "Erreur lors du calcul des frais: " . $e->getMessage()
        );
    }

    // Return JSON response
    echo json_encode($result);
} else {
    // Redirect if not logged in
    header('location: /index.html');
}

ob_end_flush();
?>