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

if (
  isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
  isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 2 ||
  isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3
) {

?>

  <div style='clear: both;'></div>

  <?php
  $nom_fichier = "Configuration_reference_produit";
  $nom_fichier_datatable = "Configuration_reference_produit" . date('d-m-Y', time()) . "-$nomsiteweb";
  ?>
  <script>
    $(document).ready(function() {
      $('#Tableau_a').DataTable({
        responsive: true,
        stateSave: true,
        dom: 'Bftipr',
        "order": [],
        buttons: [{
            extend: 'print',
            text: "Imprimer",
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            filename: "<?php echo "$nom_fichier_datatable"; ?>",
            title: "<?php echo "$nom_fichier"; ?>",
            exportOptions: {
              columns: ':visible'
            }
          }, {
            extend: 'csv',
            filename: "<?php echo "$nom_fichier_datatable"; ?>",
            exportOptions: {
              columns: ':visible'
            }
          }, {
            extend: 'colvis',
            text: "Colonnes visibles",
          }
        ],
        columnDefs: [{
          visible: false
        }],
        "columnDefs": [{
          "orderable": false,
          "targets": 3,
        }, ],
        "language": {
          "sProcessing": "Traitement en cours...",
          "sSearch": "Rechercher&nbsp;:",
          "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
          "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
          "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
          "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
          "sInfoPostFix": "",
          "sLoadingRecords": "Chargement en cours...",
          "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
          "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
          "oPaginate": {
            "sFirst": "Premier",
            "sPrevious": "Pr&eacute;c&eacute;dent",
            "sNext": "Suivant",
            "sLast": "Dernier"
          },
          "oAria": {
            "sSortAscending": ": activer pour trier la colonne par ordre croissant",
            "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
          }
        }
      });
      L
      ///////////////CHAMPS DE RECHERCHE SUR COLONNE
      $('#Tableau_a tfoot .search_table').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" class="form-control" placeholder="' + title + '" style="width:100%; font-weight: normal;"/>');
      });
      var table = $('#Tableau_a').DataTable();
      table.columns().every(function() {
        var that = this;
        $('input', this.footer()).on('keyup change', function() {
          if (that.search() !== this.value) {
            that.search(this.value)
              .draw();
          }
        });
      });

    });
  </script>

  <table id='Tableau_a' class="display nowrap" style="text-align: center; width: 100%; margin-top: 15px;" cellpadding="2" cellspacing="2">

    <thead>
      <tr>
        <th style="text-align: center;">REFERENCE</th>
        <th scope="col" style="text-align: center;">NOM DU PRODUIT</th>
        <th style="text-align: center;">PRIX</th>
        <th style="text-align: center;">CATEGORIE</th>
        <th style="text-align: center; width: 90px;">VOIR</th>
        <th style="text-align: center; width: 90px;">MODIFIER</th>
        <th style="text-align: center; width: 90px;">SUPPRIMER</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th style="text-align: center;">REFERENCE</th>
        <th scope="col" style="text-align: center;">NOM DU PRODUIT</th>
        <th style="text-align: center;">PRIX</th>
        <th style="text-align: center;">CATEGORIE</th>
        <th style="text-align: center; width: 90px;">VOIR</th>
        <th style="text-align: center; width: 90px;">MODIFIER</th>
        <th style="text-align: center; width: 90px;">SUPPRIMER</th>
      </tr>
    </tfoot>
    <tbody>

    <?php
    $req_boucle = $bdd->prepare("SELECT c.*, p.* FROM configurations_references_produits p
LEFT JOIN categories c ON p.id_categorie = c.id
ORDER BY p.id DESC");
    $req_boucle->execute();
    while ($ligne_boucle = $req_boucle->fetch()) {
      $iddd = $ligne_boucle['id'];
      $photo = $ligne_boucle['photo'];
      $prix = $ligne_boucle['prix'];
      $id_categorie = $ligne_boucle['id_categorie'];
      $nomproduit = $ligne_boucle['nom_produit'];
      $refproduithyro = $ligne_boucle['ref_produit_hyro'];
      $description = $ligne_boucle['description'];
      $url = $ligne_boucle['url'];
      $title = $ligne_boucle['title'];
      $meta_description = $ligne_boucle['meta_description'];
      $ActiverActiver = $ligne_boucle['Activer'];
      $meta_keyword = $ligne_boucle['meta_keyword'];
      $lien = $ligne_boucle['lien_chez_un_marchand'];
      $date = $ligne_boucle['date_ajout'];
      $nom_categorie = $ligne_boucle['nom_categorie']; // Nom de la catégorie



      ///////////////////////////////SELECT
      $req_select = $bdd->prepare("SELECT * FROM configurations_references_produits WHERE id=?");
      $req_select->execute(array($nomproduit));
      $ligne_select = $req_select->fetch();
      $req_select->closeCursor();
      $idd = $ligne_select['nomproduit'];

      echo "<tr><td style='text-align: center;'>$refproduithyro</td>";
      echo "<td style='text-align: center;'>$nomproduit</td>";
      echo "<td style='text-align: center;'>$prix  F CFA</td>";
      echo "<td style='text-align: center;'>$nom_categorie</td>"; // Affichez le nom de la catégorie
      echo "<td style='text-align: center;'><a href='?page=Configuration_reference_produit&amp;action=Modifier&amp;idaction=" . $iddd . "' title='Modifier' data-id='" . $data . "' ><span class='uk-icon-eye' ></span></a></td>";
      echo "<td style='text-align: center;'><a href='?page=Configuration_reference_produit&amp;action=Modifier&amp;idaction=" . $iddd . "' title='Modifier' data-id='" . $data . "' ><span class='uk-icon-file-text' ></span></a></td>";
      echo "<td style='text-align: center; width: 90px;'><a id='btnSupprModal' data-id='" . $iddd . "' href='#' ><span class='uk-icon-times' ></span></a></td>";
      echo "</tr>";
    }
    $req_boucle->closeCursor();

    echo '</tbody></table><br /><br />';
  } else {
    header('location: /index.html');
  }

  ob_end_flush();
    ?>