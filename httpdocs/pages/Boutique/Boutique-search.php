<?php
ob_start();
session_start();

// INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../Configurations_bdd.php');
require_once('../../Configurations.php');
require_once('../../Configurations_modules.php');

// INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction = "../../";
require_once('../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

$lasturl = $_SERVER['HTTP_REFERER'];

$response = ["status" => "error", "message" => "No search term provided"];

if ( !empty($_POST["search"])) {
    $searchValue = htmlspecialchars($_POST["search"]);
    // No se utiliza la sesión, así que no almacenamos nada aquí
    try {
        // Usamos LIKE para coincidencias parciales
        $query = "SELECT * FROM configurations_references_produits WHERE nom_produit LIKE ?";
        $stmt = $bdd->prepare($query);
        $stmt->execute(["%" . $searchValue . "%"]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($results)) {
            // Preparar los datos para enviar al formulario dinámico
            // Asumimos que Boutique.php espera ciertos campos, ajusta según sea necesario
            $response = [
                "status" => "success",
                "message" => "Productos encontrados",
                "results" => $results, 
                "redirect" => "/Boutique" 
            ];
        } else {
            $response = [
                "status" => "no_results",
                "message" => "Aucun produit trouvé"
            ];
        }
    } catch (PDOException $e) {
        $response = [
            "status" => "error",
            "message" => "Error en la consulta: " . $e->getMessage()
        ];
    }
} else {
    $response["message"] = "No se envió ningún término de búsqueda.";
}

echo json_encode($response);
exit;
?>
