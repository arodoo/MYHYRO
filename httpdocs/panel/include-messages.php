
<?php
if(!empty($message_administrateur) && $_GET['page'] != "Envoyer-un-colis" && $_GET['page'] != "Mes-commandes" && $_GET['page'] != "Ma-liste-de-souhaits"){
?>
			<div class="dashboard__address card address-card address-card--featured" style="width: 100%; margin-bottom: 40px;" >
                                    <div class="address-card__badge product-card__badge--sale">Message administrateur</div>
                                    <div class="address-card__body">
                                        <div class="address-card__name">Message administrateur</div>
                                        <div class="address-card__row">
                                            <?php echo nl2br($message_administrateur); ?>
                                        </div>
                                    </div>
                          </div>
<?php
}
?>

<?php
if($_GET['page'] == "Envoyer-un-colis" && !empty($message_livraison) ){
?>
			<div class="dashboard__address card address-card address-card--featured" style="width: 100%; margin-bottom: 40px;" >
                                    <div class="address-card__badge product-card__badge--sale">Message administrateur</div>
                                    <div class="address-card__body">
                                        <div class="address-card__name">Message livraison</div>
                                        <div class="address-card__row">
                                            <?php echo nl2br($message_administrateur); ?>
                                        </div>
                                    </div>
                          </div>
<?php
}
?>

<?php
if($_GET['page'] == "Mes-commandes" && !empty($message_commande) ){
?>
			<div class="dashboard__address card address-card address-card--featured" style="width: 100%; margin-bottom: 40px;" >
                                    <div class="address-card__badge product-card__badge--sale">Message administrateur</div>
                                    <div class="address-card__body">
                                        <div class="address-card__name">Message commande</div>
                                        <div class="address-card__row">
                                            <?php echo nl2br($message_commande); ?>
                                        </div>
                                    </div>
                          </div>
<?php
}
?>

<?php
if($_GET['page'] == "Ma-liste-de-souhaits" && !empty($message_liste_souhait) ){
?>
			<div class="dashboard__address card address-card address-card--featured" style="width: 100%; margin-bottom: 40px;" >
                                    <div class="address-card__badge product-card__badge--sale">Message administrateur</div>
                                    <div class="address-card__body">
                                        <div class="address-card__name">Message liste de souhaits</div>
                                        <div class="address-card__row">
                                            <?php echo nl2br($message_liste_souhait); ?>
                                        </div>
                                    </div>
                          </div>
<?php
}
?>

