<?php 
try{
require_once('../../../Configurations_bdd.php');
require_once('../../../Configurations.php');
require_once('../../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
$dir_fonction= "../../../";
require_once('../../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');

if(isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 4 ){

$idaction = $_POST['idaction'];

$req_select = $bdd->prepare("SELECT * FROM categories WHERE id = ?");
$req_select->execute(array($idaction));
$categorie = $req_select->fetch();
$req_select->closeCursor();

?>

<div class="modal fade" id="modalSuppr" tabindex="-1" role="dialog" aria-labelledby="modalSupprLabel">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalSupprLabel">Confirmation de suppression</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center">
          <span class="fas fa-exclamation-triangle text-warning fs-3 me-3"></span>
          <p class="mb-0">Êtes-vous sûr(e) de vouloir supprimer <strong><?php echo $categorie['nom_categorie']; ?></strong> ?</p>
        </div>
      </div>
      <div class="modal-footer">
        <button id="btnNon" type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Non</button>
        <button id="btnSuppr" data-id="<?= $idaction ?>" type="button" class="btn btn-danger btn-sm">Oui</button>
      </div>
    </div>
  </div>
</div>

<?php }
}catch(Exception $e){
  echo $e->getMessage();
} ?>