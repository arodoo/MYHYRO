<?php

if(!empty($Abonnement_id) && ($_GET['page'] != "Mon-abonnement" || $_GET['page'] != "Abonnements" ) ){ 

if(!empty($Abonnement_id)){ 

///////////////////////////////SELECT
$req_selecta = $bdd->prepare("SELECT * FROM configurations_abonnements WHERE id=?");
$req_selecta->execute(array($Abonnement_id));
$ligne_selecta = $req_selecta->fetch();
$req_selecta->closeCursor();

///////////////////////////////SELECT
$req_selectaa = $bdd->prepare("SELECT * FROM membres WHERE id=?");
$req_selectaa->execute(array($id_oo));
$ligne_selectaa = $req_selectaa->fetch();
$req_selectaa->closeCursor();
$Abonnement_id = $ligne_selectaa['Abonnement_id'];
$Abonnement_date  = $ligne_selectaa['Abonnement_date'];
$Abonnement_date_expiration = $ligne_selectaa['Abonnement_date_expiration'];
$Abonnement_paye = $ligne_selectaa['Abonnement_paye'];
$Abonnement_date_paye = $ligne_selectaa['Abonnement_date_paye'];
$Abonnement_mode_paye = $ligne_selectaa['Abonnement_mode_paye'];

	if(!empty($Abonnement_date_paye) && $Abonnement_paye == "oui" ){ 
		$Abonnement_date_paye = date ('d-m-Y', $ligne_selectaa['Abonnement_date_paye']);
		$Abonnement_date_paye = ", le $Abonnement_date_paye"; 
	}else{
		$Abonnement_date_paye = "";
	}

	if($ligne_selectaa['Abonnement_date_expiration'] > time() ){
		$nbr_jour_abonnement = ($ligne_selectaa['Abonnement_date_expiration']-time());
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

	if(!empty($ligne_selectaa['Abonnement_date'])){ 
		$Abonnement_date = date ('d-m-Y', $ligne_selectaa['Abonnement_date']);
	}else{
		$Abonnement_date = "-";
	}
	if(!empty($ligne_selectaa['Abonnement_date_expiration'])){ 
		$Abonnement_date_expiration = date ('d-m-Y', $ligne_selectaa['Abonnement_date_expiration']);
	}else{
		$Abonnement_date_expiration = "-";
	}

?>
                                <div class="card-header">
                                    <h5>Votre abonnement</h5>
                                </div>
                                <div class="card-divider"></div>
                                <div class="card-body">
                                    <div class="row no-gutters">
                                        <div class="col-12 col-lg-10 col-xl-8">
                                                <b><?php echo $ligne_selecta['nom_abonnement']; ?></b> <br />
                                                Expire le, <?php echo $Abonnement_date_expiration; ?><br />
						Restant : <?php echo "$nbr_jour_abonnement"; ?> <br />
						<?php if($Abonnement_id > 1 && !empty($Abonnement_paye) ){ ?><?php if($Abonnement_paye == "oui"){ echo "Payé :  <span class='product-card__badge product-card__badge--new' ><span class='uk-icon-check' ></span> $Abonnement_paye</span>"; }else{ echo "<span class='product-card__badge product-card__badge--sale' ><span class='uk-icon-times' ></span> $Abonnement_paye</span>"; } ?> par <?php echo "$Abonnement_mode_paye $Abonnement_date_paye"; ?> <br /><?php } ?>
						<?php if($_GET['page'] != "Abonnements" ){ ?> <br /> <a href="/Abonnements" class="btn btn-info">Renouveler</a> <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-divider"></div>

<?php
}else{
?>

                                <div class="card-header">
                                    <h5>Votre abonnement</h5>
                                </div>
                                <div class="card-divider"></div>
                                <div class="card-body">
                                    <div class="row no-gutters">
                                        <div class="col-12 col-lg-10 col-xl-8">
                                                <b>Vous n'avez pas d'abonnement </b> <br /><br />
						<a href="/Abonnements" class="btn btn-info">Abonnement</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-divider"></div>

<?php
}

}
?>


