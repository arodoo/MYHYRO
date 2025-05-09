<?php


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
 * \*****************************************************/

if (isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
    isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ||
    isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3) {

$idaction = $_GET['idaction'];
$action = $_GET['action'];

?>

<script>
$(document).ready(function (){

  //AJAX SOUMISSION DU FORMULAIRE - MODIFIER - AJOUTER
  $(document).on("click", "#modifier", function (){
        $.post({
          url : '/administration/Modules/Abonnes/Abonnes-action-modifier-ajax.php',
          type : 'POST',
          <?php if($_GET['action'] == "Modifier" ){ ?> 
          data: new FormData($("#formulaire-modifier")[0]),
          <?php }else{ ?> 
          data: new FormData($("#formulaire-ajouter")[0]),
          <?php } ?> 
          processData: false,
          contentType: false,
          dataType: "json",
          success: function (res) {
            if(res.retour_validation == "ok"){
              popup_alert(res.Texte_rapport,"green filledlight","#009900","uk-icon-check");
		location.reload();
            }else{
              popup_alert(res.Texte_rapport,"#CC0000 filledlight","#CC0000","uk-icon-times");
            }
          },
          error: function (xhtml, error, code) {
            console.log(xhtml.responseText);
          }
        });
        listeCompteMembre();
  });


  //FUNCTION AJAX - LISTE NEWSLETTER
  function listeCompteMembre(){
    $.post({
      url : '/administration/Modules/Abonnes/Abonnes-action-liste-ajax.php',
      type : 'POST',
      dataType: "html",
      success: function (res) {
        $("#liste-compte-membre").html(res);
      }
    });
  }
  listeCompteMembre();

});
</script>

<?php

$action = $_GET['action'];
$idaction = $_GET['idaction'];
?>

<ol class="breadcrumb">
  <li><a href="<?php echo $http; ?><?php echo $nomsiteweb; ?>">Accueil</a></li>
  <li><a href="<?php echo $mode_back_lien_interne; ?>">Administration</a></li>
  <?php if(empty($_GET['action'])){ ?> <li class="active">Gestion des abonnés</li> <?php }else{ ?> <li><a href="?page=Abonnes">Gestion des abonnés</a></li> <?php } ?>
  <?php if($_GET['action'] == "modifier" ){ ?> <li class="active">Modifications</li> <?php } ?>
  <?php if($_GET['action'] == "addm" ){ ?> <li class="active">Ajouter</li> <?php } ?>
  <?php if($_GET['action'] == "Graphique" ){ ?> <li class="active">Graphique</li> <?php } ?>
</ol>

<?php
echo "<div id='bloctitre' style='text-align: left;'><h1>Gestion des abonnés</h1></div><br />
<div style='clear: both;'></div>";

////////////////////Boutton administration
echo "<a href='".$mode_back_lien_interne."'><button type='button' class='btn btn-default' style='margin-right: 5px;' ><span class='uk-icon-cogs'></span> Administration</button></a>";
if(isset($_GET['action'])){
echo "<a href='?page=Abonnes'><button type='button' class='btn btn-success' style='margin-right: 5px;' ><span class='uk-icon-history'></span> Liste des abonnés</button></a>";
}
echo "<div style='clear: both;'></div><br />";
////////////////////Boutton administration
?>

<div style='padding: 5px; text-align: center;'>

<?php

////////////////////////////////////////////////////////////////////////////////////////////FORMULAIRE AJOUTER - MODIFIER
if($action == "Ajouter" || $action == "Modifier"){

if($action == "Modifier"){
  $req_select = $bdd->prepare("SELECT * FROM membres WHERE id=?");
  $req_select->execute(array($idaction));
  $ligne_select = $req_select->fetch();
  $req_select->closeCursor();
  $idd2dddf = $ligne_select['id']; 
  $loginm = $ligne_select['pseudo'];
  $emailm = $ligne_select['mail'];
  $nomm = $ligne_select['nom'];
  $prenomm = $ligne_select['prenom'];
  $adminm = $ligne_select['admin'];
  $statut_compte = $ligne_select['statut_compte'];
  $adressem = $ligne_select['adresse'];
  $cpm = $ligne_select['cp'];
  $villem = $ligne_select['ville'];
  $telephonepost = $ligne_select['Telephone'];
  $telephoneposportable = $ligne_select['Telephone_portable'];
  $ActiverActiver = $ligne_select['Activer'];
  $photo = $ligne_select['photo'];

	if($ligne_select['Abonnement_date_expiration'] > time() ){
		$nbr_jour_abonnement = ($ligne_select['Abonnement_date_expiration']-time());
		if($nbr_jour_abonnement > 86400){
			$nbr_jour_abonnement = ($nbr_jour_abonnement/86400);
		}
		$nbr_jour_abonnement = round($nbr_jour_abonnement);
		if($nbr_jour_abonnement > 1){
			$nbr_jour_abonnement = "$nbr_jour_abonnement Jours";
		}else{
			$nbr_jour_abonnement = "1 Jour";
		}
	}else{
		$nbr_jour_abonnement = "0 Jours";
	}

?>

<form id='formulaire-modifier' method='post' action='#'>
  <input name="idaction" class="form-control" type="hidden" value="<?php echo "$idaction"; ?>" style='width: 100%;'/>
  <input name="action" class="form-control" type="hidden" value="<?php echo "Modifier-action"; ?>" style='width: 100%;'/>

  <div style='text-align: center; margin-right: auto; margin-left: auto;'>
  <div style='text-align: left;'>
    <h2>Modifier l'abonnement du membre</h2><br /><br />
  </div>

<?php
}elseif($action == "Ajouter"){ ?>
<form id='formulaire-ajouter' method='post' action='#'>
  <input name="idaction" class="form-control" type="hidden" value="<?php echo "$idaction"; ?>" style='width: 100%;'/>
  <input name="action" class="form-control" type="hidden" value="Ajouter-action" style='width: 100%;'/>

  <div style='text-align: center; margin-right: auto; margin-left: auto;'>
  <div style='text-align: left;'>
    <h2>Ajouter un membre</h2><br /><br />
  </div>
<?php } ?>

<div class="well well-sm" style="width: 100%; text-align: left;">
<h3>Abonnement</h3>
<table style='text-align: center; width: 100%;' cellpadding='2' cellspacing='2' >

  <tr>
  <td style='text-align: left; width: 150px;'>Abonnement actuel</td>
  <td style='text-align: left;'>
  <select name="Abonnement_id" id="Abonnement_id" class="form-control" style='width: 100%;' required>
<option value="" >Pas d'abonnement</option>
<?php
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM configurations_abonnements ORDER by id");
$req_boucle->execute();
while($ligne_boucle = $req_boucle->fetch()){
?>
    <option <?php if($ligne_boucle['id'] == $ligne_select['Abonnement_id'] ){ echo "selected"; } ?> value="<?php echo $ligne_boucle['id']; ?>" > <?php echo $ligne_boucle['nom_abonnement']; ?></option>
<?php 
}
$req_boucle->closeCursor();
?>
  </select>
  </td></tr>

  <tr><td>&nbsp;</td></tr>
    <tr><td style='text-align: left; min-width: 120px;'>Abonnement demandé</td>
    <td style='text-align: left;'>
    <?php
    $req_boucle = $bdd->prepare("SELECT * FROM configurations_abonnements Where id=?");
    $req_boucle->execute(array($ligne_select['Abonnement_demande']));
    $ligne_boucle = $req_boucle->fetch();
    $req_boucle->closeCursor();

    echo $ligne_boucle['nom_abonnement']; ?>
    <input type="hidden" name="abo_demande" value="<?= $ligne_boucle['id'] ?>">
    </td></tr>
  <tr><td>&nbsp;</td></tr>

  <tr><td>&nbsp;</td></tr>
    <tr><td style='text-align: left; min-width: 120px;'>Date demande</td>
    <td style='text-align: left;'>
    <?php
    echo date('d-m-Y',$ligne_select['Abonnement_dernier_demande_date']); ?>
    </td></tr>
  <tr><td>&nbsp;</td></tr>

  <tr><td>&nbsp;</td></tr>
    <tr><td style='text-align: left; min-width: 120px;'>Fiche</td>
    <td style='text-align: left;'>
	<a href="?page=Membres&amp;action=Modifier&amp;idaction=<?php echo $ligne_select['id']; ?>" target="blank_" class="btn btn-danger"> Fiche client </a>
    </td></tr>
  <tr><td>&nbsp;</td></tr>

  <tr><td>&nbsp;</td></tr>
    <tr><td style='text-align: left; min-width: 120px;'>N°Client</td>
    <td style='text-align: left;'>
    <?php echo $ligne_select['numero_client']; ?>
    </td></tr>
  <tr><td>&nbsp;</td></tr>

    <tr><td style='text-align: left; min-width: 120px;'>Nom</td>
    <td style='text-align: left;'>
    <?php echo $ligne_select['nom']; ?>
    </td></tr>
  <tr><td>&nbsp;</td></tr>

    <tr><td style='text-align: left; min-width: 120px;'>Prénom</td>
    <td style='text-align: left;'>
    <?php echo $ligne_select['prenom']; ?>
    </td></tr>
  <tr><td>&nbsp;</td></tr>

  <tr><td colspan="2" ><hr style="color: #000000;" /></td></tr>
  <tr><td style="font-weight: bold; text-align: left;" >Dates</td></tr>
  <tr><td>&nbsp;</td></tr>

    <tr><td style='text-align: left; min-width: 120px;'>Date commande</td>
    <td style='text-align: left;'>
    <?php echo date('m-d-Y', $ligne_select['Abonnement_date']); ?>
    </td></tr>
  <tr><td>&nbsp;</td></tr>

    <tr><td style='text-align: left; min-width: 120px;'>Expire le, </td>
    <td style='text-align: left;'>
    <?php if(!empty($ligne_select['Abonnement_date_expiration'])){ echo date('m-d-Y', $ligne_select['Abonnement_date_expiration']); }else{ echo "-"; } ?>
    </td></tr>
  <tr><td>&nbsp;</td></tr>

    <tr><td style='text-align: left; min-width: 120px;'>Date paiement</td>
    <td style='text-align: left;'>
    <?php if(!empty($ligne_select['Abonnement_date_paye'])){ echo date('d-m-Y', $ligne_select['Abonnement_date_paye']); }else{ echo "-"; } ?>
    </td></tr>
  <tr><td>&nbsp;</td></tr>

    <tr><td style='text-align: left; min-width: 120px;'>Jours restant</td>
    <td style='text-align: left;'>
    <?php echo $nbr_jour_abonnement; ?>
    </td></tr>
  <tr><td>&nbsp;</td></tr>

  <tr><td colspan="2" ><hr style="color: #000000;" /></td></tr>
  <tr><td style="font-weight: bold; text-align: left;" >Expiration</td></tr>
  <tr><td>&nbsp;</td></tr>

    <tr><td style='text-align: left; min-width: 120px;'>Modifier l'expiration</td>
    <td style='text-align: left;'>
    <input name="date_new_expiration" class="form-control" type="date" id="date_new_expiration" value="" style='width: 100%; min-width: 200px;' required />
    </td></tr>

  <tr><td colspan="2" ><hr style="color: #000000;" /></td></tr>
  <tr><td style="font-weight: bold; text-align: left;" >Paiement</td></tr>
  <tr><td>&nbsp;</td></tr>

<?php
if(!empty($ligne_select['Abonnement_last_facture_numero'])){
?>
  <tr>
  <td style='text-align: left; width: 150px;'>Dernière facture</td>
  <td style='text-align: left;'>
	<a href="/facture/<?php echo $ligne_select['Abonnement_last_facture_numero']; ?>/<?php echo $nomsiteweb; ?>" target="blank_" class="btn btn-danger" > Facture abonnement </a>
  </td></tr>
  <tr><td>&nbsp;</td></tr>
<?php
}
?>

  <tr>
  <td style='text-align: left; width: 150px;'>Payé</td>
  <td style='text-align: left;'>
  <select name="Abonnement_paye" id="Abonnement_paye" class="form-control" style='width: 100%;' required>
    <option <?php if($ligne_select['Abonnement_paye'] == "non" ){ echo "selected"; } ?> value="non"> <?php echo "Non"; ?></option>
    <option <?php if($ligne_select['Abonnement_paye'] == "oui" ){ echo "selected"; } ?> value="oui"> <?php echo "Oui"; ?></option>
  </select>
  </td></tr>
  <tr><td>&nbsp;</td></tr>

  <tr>
  <td style='text-align: left; width: 150px;'>Mode de paiement </td>
  <td style='text-align: left;'>
  <select name="Abonnement_mode_paye" id="Abonnement_mode_paye" class="form-control" style='width: 100%;' required>
<option value="" > Sélection </option>
<?php
///////////////////////////////SELECT BOUCLE
$req_boucle = $bdd->prepare("SELECT * FROM configurations_modes_paiement ORDER by id");
$req_boucle->execute();
while($ligne_boucle = $req_boucle->fetch()){
?>
    <option <?php if($ligne_select['Abonnement_paye_demande'] == $ligne_boucle['nom_mode'] ){ echo "selected"; } ?> value="<?php echo $ligne_boucle['nom_mode']; ?>" > <?php echo $ligne_boucle['nom_mode']; ?></option>
<?php 
}
$req_boucle->closeCursor();
?>
  </select>
  </td></tr>
  <tr><td>&nbsp;</td></tr>

    <tr><td tyle='text-align: left; min-width: 120px; font-weight: bold;'>Modifier date paiement</td>
   <td style='text-align: left;'>
    <input name="Abonnement_date_paye" class="form-control" type="date" id=" Abonnement_date_paye" value="" style='width: 100%; min-width: 200px;' required />
    </td></tr>
  <tr><td>&nbsp;</td></tr>

    <tr><td colspan="2" style='text-align: left; min-width: 120px;'><input name="generer_facture" class="form-control" type="checkbox" id="generer_facture" value="oui"' required style="height: 15px; width: 15px; display: inline-block;"  /> Générer une facture pour l'abonnement (La facture aura la date du jour) </td></tr>
  <tr><td>&nbsp;</td></tr>

  <tr><td colspan="2" style='text-align: left; min-width: 120px;'>Activer l'abonnement demandé <br><br>
  OUI <input type="radio" name="activer_abo" value="oui" class="">
  NON <input type="radio" name="activer_abo" value="non" class="" checked><br>
</tr>
  <tr><td>&nbsp;</td></tr>

  </table>
<div style="border-top: 1px solid #dddddd; padding: 2rem;">
  <h4 style="color: #ff9900; font-weight: bold;">SUIVI DE LA COMMANDE</h4>



    <table style='text-align: center; width: 100%;' cellpadding="2" cellspacing="2">

    <tr>
       <!--  <td style='text-align: left;' ><label for="regulariser">Total à régulariser</label> <input class="form-control" type="text" name="regulariser" id="regulariser" style="width: 50%;"></td> -->
       <!--  <td style='text-align: left;' ><label for="regulariser">Montant à rembourser</label> <input class="form-control" type="text" name="regulariser" id="regulariser" style="width: 50%;"> </td> -->
        <td style='text-align: left;' ><label for="statut_2">Suivi achat</label>   <select id="statut_2" name="statut_2" class="form-control" style="width:50%">
        <option value=""></option>
        <?php
                $req_boucle = $bdd->prepare("SELECT * FROM configurations_suivi_achat where type=2");
                $req_boucle->execute();
                while($ligne_boucle = $req_boucle->fetch()){
            ?>
                    <option value="<?=$ligne_boucle['id']?>" <?php if($ligne_select['Abonnement_statut_demande'] == $ligne_boucle['id']){?> selected <?php }?>><?=$ligne_boucle['nom_suivi']?></option>
                    <?php
            }
            $req_boucle->closeCursor();
            ?>
                </select>
            </td>
    </tr>
    <tr>
        <!-- <td style='text-align: left;' ><label for="regulariser">Restant à payer</label> <input class="form-control" type="text" name="regulariser" id="regulariser" style="width: 50%;"></td> -->
        <!-- <td style='text-align: left;' ><label for="regulariser">Restant à rembourser</label> <input class="form-control" type="text" name="regulariser" id="regulariser" style="width: 50%;"> </td> -->

    </tr>
    <tr><hr></tr>
</table>

<div>
<label for="message">Messages prédéfinis</label> <select id="message" name="message" class="form-control" style="width:50%">
        <?php
                $req_boucle = $bdd->prepare("SELECT * FROM configurations_messages_predefini where type=2");
                $req_boucle->execute();
                while($ligne_boucle = $req_boucle->fetch()){
            ?>
                    <option value="<?=$ligne_boucle['id']?>" <?php if($ligne_select['Abonnement_message_demande'] == $ligne_boucle['id']){?> selected <?php }?>><?=$ligne_boucle['message']?></option>
                    <?php
            }
            $req_boucle->closeCursor();
            ?>
                </select>
    </div>
</div>
<br>
<div style="border-top: 1px solid #dddddd; padding: 2rem;">
            <h4 style="color: #ff9900; font-weight: bold;">SUIVI DES ENCAISSEMENTS ET DES REMBOURSEMENTS</h4>

            <div style="display: flex;">

                <div style="width: 70%">
                    <h5 style="font-weight: bold">Encaissement</h5>
                    <div style="display: flex;">

                        <div>
                            <div style="display: flex; align-items: center; justify-content: flex-end; margin-bottom: 1rem;">
                                <label for="montant_a_payer" style="margin-right: 1rem; font-weight: normal;">Montant à payer</label>
                                <input class="form-control" type="text" name="montant_a_payer" id="montant_a_payer" style="width: 10rem; margin-right: 1rem;" value=" <?= number_format($prix_total, 0, '.', ' ') ?> " disabled>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: flex-end;">
                                <label for="montant_paye_client" style="margin-right: 1rem; font-weight: normal;">Montant payé par le client :</label>
                                <input class="form-control" type="text" name="montant_paye_client" id="montant_paye_client" value="<?= $commande['montant_paye_client'] ? $commande['montant_paye_client'] : 0 ?>" style="width: 10rem; margin-right: 1rem;" disabled>
                            </div>
                        </div>

                        <div style="margin-left: 10rem">
                            <div style='display: flex; align-items: center; justify-content: flex-end; margin-bottom: 1rem;'>
                                <label for="total_a_regulariser" style="margin-right: 1rem; font-weight: normal;">Total à régulariser</label>
                                <input class="form-control" disabled type="text" name="total_a_regulariser" value="<?= !empty($commande['prix_total_reel']) ? $commande['prix_total_reel']-$commande['montant_paye_client'] : $commande['prix_total']-$commande['montant_paye_client'] ?>" id="total_a_regulariser" style="width: 10rem; margin-right: 1rem;">
                            </div>

                            <div style='display: flex; align-items: center; justify-content: flex-end;'>
                                <label for="restant_payer" style="margin-right: 1rem; font-weight: normal;">Restant à payer</label>
                                <input class="form-control" type="text" name="restant_payer" id="restant_payer" value="<?= $commande['restant_payer'] ?>" style="width: 10rem; margin-right: 1rem;">
                            </div>
                        </div>
                    </div>
                    <div style="display: flex; margin-top: 3rem;">
                        <div>
                            <div style='display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;'>
                                <label for="montant_recu" style="font-weight: normal; margin-right: 1rem;">Montant reçu</label>
                                <input class="form-control" type="text" name="montant_recu" id="montant_recu" style="width: 10rem; margin-right: 1rem;">
                            </div>

                            <div style="display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;">
                                <label for="moyen_d_encaissement" style="font-weight: normal; margin-right: 1rem;">Moyen d'encaissement : </label>
                                <select name="moyen_d_encaissement" id="moyen_d_encaissement" style="width: 10rem; margin-right: 1rem;" class="form-control">
                                    <option value="Espèces">Espèces</option>
                                    <option value="Chèque">Chèque</option>
                                    <option value="Airtel money">Airtel money</option>
                                    <option value="Flooz">Flooz</option>
                                    <option value="MobiCash">MobiCash</option>
                                    <option value="PayPal">PayPal</option>
                                    <option value="CB">CB</option>
                                </select>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;">
                                <label for="type_d_encaissement" style="font-weight: normal; margin-right: 1rem;">Type d'encaissement : </label>
                                <select name="type_d_encaissement" id="type_d_encaissement" style="width: 10rem; margin-right: 1rem;" class="form-control">
                                <option value="Comptant" >Comptant</option>
                                    <option value="60 %">60 %</option>

                                    <option value="2 fois" >2 fois</option>
                                    <option value="3 fois" >3 fois</option>
                                </select>
                            </div>
                        </div>
                        <div style="margin-left: 5rem">
                            <div style='display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;'>
                                <label for="date_de_reception" style="font-weight: normal; margin-right: 1rem;">Date de réception</label>
                                <input class="form-control" type="date" name="date_de_reception" id="date_de_reception" style="width: 14rem; margin-right: 1rem;">
                            </div>

                            <div style="display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;">
                                <label for="statut_paiement" style="font-weight: normal; margin-right: 1rem;">Statut de paiement : </label>
                                <select name="statut_paiement" id="statut_paiement" style="width: 14rem; margin-right: 1rem;" class="form-control">
                                    <option value="Paiement en attente" <?= $commande['statut_paiement'] == "Paiement en attente" ? 'selected' : '' ?>>Paiement en attente</option>
                                    <option value="Commande totalement payée" <?= $commande['statut_paiement'] == "Commande totalement payée" ? 'selected' : '' ?>>Commande totalement payée</option>
                                    <option value="Commande partiellement payée" <?= $commande['statut_paiement'] == "Commande partiellement payée" ? 'selected' : '' ?>>Commande partiellement payée</option>
                                    <option value="Défaut de paiement" <?= $commande['statut_paiement'] == "Défaut de paiement" ? 'selected' : '' ?>>Défaut de paiement</option>
                                </select>
                            </div>

                            <div style='display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;'>
                                <label for="echeance_du" style="font-weight: normal; margin-right: 1rem;">A échéance du : </label>
                                <input class="form-control" type="date" name="echeance_du" id="echeance_du" style="width: 14rem; margin-right: 1rem;" >
                            </div>
                        </div>

                        <div style="margin-left: 5rem">
                        <?php if(!empty($commande['id_paiement_pf'])){
                            ?>
                            <h5 style="font-weight: bold">Echéancier</h5>
                            <div style='display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;'>
                                <label for="echeancier1" style="font-weight: normal; margin-right: 1rem;">1er <?= $commande['dette_montant_pf'] ?> </label>
                                <select id='dette_payee_pf' name='dette_payee_pf' class='form-control' style='width:50%'>
                                    <option value='Payé' <?php if ($commande['dette_payee_pf'] == 'Payé') { echo 'selected'; } ?>>Payé</option>
                                    <option value='Non payé' <?php if ($commande['dette_payee_pf'] == 'Non payé') {echo 'selected';} ?>>Non payé</option>
                                </select>
                                <!--input class="form-control" type="text" name="echeancier1" id="echeancier1" style="width: 10rem; margin-right: 1rem;" disabled-->
                            </div>
                            <div style='display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;'>
                                <label for="echeancier2" style="font-weight: normal; margin-right: 1rem;">2e <?= $commande['dette_montant_pf2'] ?> </label>
                                <select id='dette_payee_pf2' name='dette_payee_pf2' class='form-control' style='width:50%'>
                                    <option value='Payé' <?php if ($commande['dette_payee_pf2'] == 'Payé') {echo 'selected';} ?>>Payé</option>
                                    <option value='Non payé' <?php if ($commande['dette_payee_pf2'] == 'Non payé') {echo 'selected';} ?>>Non payé</option>
                                </select>
                                <!--input class="form-control" type="text" name="echeancier2" id="echeancier2" style="width: 10rem; margin-right: 1rem;" disabled-->
                            </div>
                            <?php if(!empty($commande['dette_montant_pf3'])){ ?>
                            <div style='display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;'>
                                <label for="echeancier3" style="font-weight: normal; margin-right: 1rem;">3e <?= $commande['dette_montant_pf3'] ?> </label>
                                <select id='dette_payee_pf3' name='dette_payee_pf3' class='form-control' style='width:50%'>
                                    <option value='Payé' <?php if ($commande['dette_payee_pf3'] == 'Payé') {echo 'selected';} ?>>Payé</option>
                                    <option value='Non payé' <?php if ($commande['dette_payee_pf3'] == 'Non payé') {echo 'selected';} ?>>Non payé</option>
                                </select>
                                <!--input class="form-control" type="text" name="echeancier3" id="echeancier3" style="width: 10rem; margin-right: 1rem;" disabled-->
                            </div>
                            <?php
                            }
                        } ?>

                        </div>
                    </div>
                    <div style='display: flex; align-items: center; margin-top: 5rem;'>
                        <label for="motif_encaissement" style="font-weight: normal; margin-right: 1rem;">Motif : </label>
                        <input class="form-control" type="text" name="motif_encaissement" id="motif_encaissement"  value="<?= $commande['motif_encaissement'] ?>" style="width: 20rem; margin-right: 1rem;" >
                    </div>

                    <div style="margin-top: 3rem">
                        <p style="font-weight: bold">Transactions</p>
                        <?php
                    ///////////////////////////////SELECT BOUCLE

                    $req_boucle = $bdd->prepare("SELECT * FROM membres_transactions_commande WHERE id_commande=? AND type=? ORDER BY id DESC");
                    $req_boucle->execute(array($_POST['idaction'], "Paiement"));
                    while ($ligne_boucle = $req_boucle->fetch()) {
                        ?>
                        <p>- Paiement <?= $ligne_boucle['moyen'] ?> <?= $ligne_boucle['mode_encaissement'] ?> de <?= $ligne_boucle['montant'] ?> f cfa réalisé le <?= $ligne_boucle['date'] ?>
                        <?php if (!empty($ligne_boucle['motif'])) { ?>
                            : <?= $ligne_boucle['motif'] ?>
                        <?php } ?>
                        <?= $ligne_boucle['echeance_du'] ? ", <label style='color: red;'><b> prochaine échéance le " . $ligne_boucle['echeance_du'] . "</b></label>" : '' ?>
                        </p>
                        <?php } ?>
                    </div>
                    <div style="display:flex;margin-top:1rem">
            <div>
                <!--button id="paiement_save" class="btn btn-success" style="width: 100px; text-align:center">Enregistrer</button-->
            </div>
        </div>
                </div>
                <div style="border-left: 1px solid #dfdfdf; padding-left: 2rem; padding-right: 1rem; display: flex; flex-direction: column; align-items: center;">

                    <h5 style="font-weight: bold">Remboursement</h5>
                    <?php if($alert == "oui"){ ?>
                    <div class="alert alert-danger"><i class="uk-icon-warning"></i> Attention! des articles ont été annulés, veuillez procéder au remboursement si besoin</div>
                    <?php } ?>
                    <div>
                        <div style="display: flex; align-items: center; justify-content: flex-end; margin-bottom: 1rem;">
                            <label for="montant_rembourser" style="margin-right: 1rem; font-weight: normal; ">Montant à rembourser</label>
                            <input class="form-control" type="text" name="montant_rembourser" id="montant_rembourser" value="<?= $commande['montant_rembourser'] ?>" style="width: 14rem; margin-right: 1rem;">
                        </div>

                        <div style="display: flex; align-items: center; justify-content: flex-end; margin-bottom: 1rem;">
                            <label for="restant_rembourser" style="margin-right: 1rem; font-weight: normal;">Restant à rembourser</label>
                            <input class="form-control" type="text" name="restant_rembourser" id="restant_rembourser" value="<?= $commande['restant_rembourser'] ?>" style="width: 14rem; margin-right: 1rem;">
                        </div>

                        <div style="display: flex; align-items: center; justify-content: flex-end; margin-bottom: 1rem;">
                            <label for="total_rembourse" style="margin-right: 1rem; font-weight: normal;">Total remboursé</label>
                            <input class="form-control" type="text" name="total_rembourse" id="total_rembourse" value="<?= $commande['total_rembourse'] ?>" style="width: 14rem; margin-right: 1rem;" disabled>
                        </div>
                    </div>

                    <div style="margin-top: 3rem">
                        <div style="display: flex; align-items: center; justify-content: flex-end; margin-bottom: 1rem;">
                            <label for="regulariser" style="margin-right: 1rem; font-weight: normal;">Montant remboursé</label>
                            <input class="form-control" type="text" name="regulariser" id="regulariser" style="width: 14rem; margin-right: 1rem;">
                        </div>
                        <div style="display: flex; align-items: center; justify-content: flex-end; margin-bottom: 1rem;">
                            <label for="date_rem" style="margin-right: 1rem; font-weight: normal;">Date de remboursement</label>
                            <input class="form-control" type="date" name="date_rem" id="date_rem" style="width: 14rem; margin-right: 1rem;">
                        </div>
                        <div style="display: flex; align-items: center; justify-content: flex-end; margin-bottom: 1rem;">
                            <label for="moyen_de_remboursement" style="font-weight: normal; margin-right: 1rem;">Moyen de remboursement </label>
                            <select name="moyen_de_remboursement" id="moyen_de_remboursement" style="width: 14rem; margin-right: 1rem;" class="form-control">
                            <option value="Espèces">Espèces</option>
                                    <option value="Chèque">Chèque</option>
                                    <option value="Airtel money">Airtel money</option>
                                    <option value="Flooz">Flooz</option>
                                    <option value="MobiCash">MobiCash</option>
                                    <option value="PayPal">PayPal</option>
                                    <option value="CB">CB</option>
                            </select>
                        </div>
                        <div style='display: flex; align-items: center; justify-content: flex-end; margin-top: 5rem;'>
                            <label for="motif_remboursement" style="font-weight: normal; margin-right: 1rem;">Motif : </label>
                            <input class="form-control" type="text" name="motif_remboursement" id="motif_remboursement"  value="<?= $commande['motif_remboursement'] ?>" style="width: 20rem; margin-right: 1rem;" >
                        </div>

                    </div>


                    <div style="margin-top: 3rem">
                        <p style="font-weight: bold">Transactions</p>
                        <?php
                    ///////////////////////////////SELECT BOUCLE

                    $req_boucle = $bdd->prepare("SELECT * FROM membres_transactions_commande WHERE id_commande=? AND type=? ORDER BY id DESC");
                    $req_boucle->execute(array($_POST['idaction'], "Remboursement"));
                    while ($ligne_boucle = $req_boucle->fetch()) {
                        ?>
                        <p>- Remboursement <?= $ligne_boucle['moyen'] ?> de <?= $ligne_boucle['montant'] ?> f cfa réalisé le <?= $ligne_boucle['date'] ?>
                        <?php if (!empty($commande['motif_remboursement'])) { ?>
                            : <?= $commande['motif_remboursement'] ?>
                        <?php } ?>
                        </p>
                        <?php } ?>
                    </div>
                    <div style="display:flex;margin-top:1rem">
            <div>
                <!--button id="remboursement_save" class="btn btn-success" style="width: 100px; text-align:center">Enregistrer</button-->
            </div>
        </div>
                </div>
            </div>

            <!--table style='text-align: center; width: 100%;' cellpadding='2' cellspacing='2'>

                <input id="idWish" style="display:none" disabled value="<?= $commande['id']; ?>"/>
                <input id="idMembre" style="display:none" disabled value="<?= $commande['user_id']; ?>"/>

                <tr>

                    <td style='text-align: left; font-weight:bold'>
                        <?php
                        if (!empty($commande['id_paiement_pf'])) {
                            if ($commande['id_paiement_pf'] == '2' || $commande['id_paiement_pf'] == '1' || $commande['id_paiement_pf'] == '4' || $commande['id_paiement_pf'] == '3') {

                                echo $commande['dette_montant_pf'] ?> <select id='dette_payee_pf' name='dette_payee_pf'
                                                                              class='form-control' style='width:50%'>
                                    <option value='Payé' <?php if ($commande['dette_payee_pf'] == 'Payé') {echo 'selected';} ?>>Payé
                                    </option>
                                    <option value='Non payé' <?php if ($commande['dette_payee_pf'] == 'Non payé') {echo 'selected';} ?>>Non payé
                                    </option>
                                </select>
                                <br>
                                <?php echo $commande['dette_montant_pf2'] ?>
                                <select id='dette_payee_pf2' name='dette_payee_pf2' class='form-control' style='width:50%'>
                                    <option value='Payé' <?php if ($commande['dette_payee_pf2'] == 'Payé') {echo 'selected';} ?>>Payé</option>
                                    <option value='Non payé' <?php if ($commande['dette_payee_pf2'] == 'Non payé') {echo 'selected';} ?>>Non payé</option>
                                </select>
                                <br>
                                <?php

                            } elseif ($commande['id_paiement_pf'] == '6' || $commande['id_paiement_pf'] == '5') {

                                echo $commande['dette_montant_pf'] ?>

                                <br>
                                <?php echo $commande['dette_montant_pf2'] ?>
                                <select id='dette_payee_pf2' name='dette_payee_pf2' class='form-control' style='width:50%'>
                                    <option value='Payé' <?php if ($commande['dette_payee_pf2'] == 'Payé') {echo 'selected';} ?>>Payé</option>
                                    <option value='Non payé' <?php if ($commande['dette_payee_pf2'] == 'Non payé') {echo 'selected';} ?>>Non payé</option>
                                </select>
                                <br>
                                <?php echo $commande['dette_montant_pf3'] ?>
                                <select id='dette_payee_pf3' name='dette_payee_pf3' class='form-control' style='width:50%'>
                                    <option value='Payé' <?php if ($commande['dette_payee_pf3'] == 'Payé') {echo 'selected';} ?>>Payé</option>
                                    <option value='Non payé' <?php if ($commande['dette_payee_pf3'] == 'Non payé') {echo 'selected';} ?>>Non payé</option>
                                </select>
                                <br>
                                <?php
                            }

                        }
                        ?>
                    </td>

                </tr>
            </table-->


        </div>
        <div style="border-top: 1px solid #dddddd; padding: 2rem;">
            <h4 style="color: #ff9900; font-weight: bold;">NOTES</h4>
            <div style="display: flex; flex-direction: column">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes" ><?=$commande['notes']?></textarea>
            </div>
        </div>

  </div>

  <br />
  <button id='modifier' type='button' class='btn btn-success' onclick="return false;" style='width: 150px;' >ENREGISTRER</button>

</form>

<?php
}
if(!isset($action)){
?>

<div id='liste-compte-membre' style='clear: both;'></div>

<?php
} 
echo "</div>";
} else {
    header('location: /index.html');
}
?>