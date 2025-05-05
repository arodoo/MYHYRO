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
\*****************************************************/

if (
  isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 1 ||
  isset($_SESSION['7A5d8M9i4N9']) && isset($_SESSION['4M8e7M5b1R2e8s']) && isset($user) && $admin_oo == 3
) {
  ?>

  <script>
    $(document).ready(function () {
      // Function to load newsletter list
      function listeNewsletter() {
        $.post({
          url: '/administration/Modules/Newsletters/configurations-liste-ajax.php',
          type: 'POST',
          dataType: "html",
          success: function (res) {
            $("#liste-newsletter").html(res);
            // Initialize DataTable if it exists
            initializeNewsletterTable();
          }
        });
      }

      // Initialize DataTable with proper formatting
      function initializeNewsletterTable() {
        if ($.fn.DataTable.isDataTable('.sa-datatables-init')) {
          $('.sa-datatables-init').DataTable().destroy();
          $('.sa-datatables-init').empty();
        }

        // Short timeout to ensure DOM is ready after AJAX content update
        setTimeout(function () {
          // Define clean template structure for consistent layout
          const template =
            '<"sa-datatables"' +
            '<"sa-datatables__table"t>' +
            '<"sa-datatables__footer"' +
            '<"sa-datatables__pagination"p>' +
            '<"sa-datatables__controls"' +
            '<"sa-datatables__legend"i>' +
            '<"sa-datatables__divider">' +
            '<"sa-datatables__page-size"l>' +
            '>' +
            '>' +
            '>';

          // Initialize with clean options
          $('.sa-datatables-init').each(function () {
            const table = $(this).DataTable({
              dom: template,
              paging: true,
              ordering: true,
              info: true,
              language: {
                search: "",
                searchPlaceholder: "Rechercher...",
                lengthMenu: "Afficher _MENU_ éléments",
                info: "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                infoEmpty: "Affichage de l'élément 0 à 0 sur 0 élément",
                infoFiltered: "(filtré de _MAX_ éléments au total)",
                paginate: {
                  first: "Premier",
                  previous: "Précédent",
                  next: "Suivant",
                  last: "Dernier"
                }
              },
              // Apply proper styles to pagination for consistency
              drawCallback: function () {
                $(this).api().table().container().find('.pagination').addClass('pagination-sm');
              }
            });

            // Connect search input using data attribute
            const searchSelector = $(this).data('sa-search-input');
            if (searchSelector) {
              $(searchSelector).off('input').on('input', function () {
                table.search(this.value).draw();
              });

              // Prevent form submission on enter in search field
              $(searchSelector).off('keypress.prevent-form-submit').on('keypress.prevent-form-submit', function (e) {
                return e.which !== 13;
              });
            }
          });
        }, 10);
      }

      // Modal trigger handler
      $(document).on('click', '.btnSupprModal', function () {
        var id = $(this).data('id');
        $.post({
          url: '/administration/Modules/Newsletters/modal-supprimer-ajax.php',
          type: 'POST',
          data: { idaction: id },
          dataType: "html",
          success: function (res) {
            $("#modal-container").html(res);
            $("#modalSuppr").modal('show');
          }
        });
      });

      // Delete confirmation handler
      $(document).on("click", "#btnSuppr", function () {
        var id = $(this).data('id');
        $.post({
          url: '/administration/Modules/Newsletters/configurations-action-supprimer.php',
          type: 'POST',
          data: { idaction: id },
          dataType: "json",
          success: function (res) {
            if (res.retour_validation == "ok") {
              popup_alert(res.Texte_rapport, "green filledlight", "#009900", "uk-icon-check");
            } else {
              popup_alert(res.Texte_rapport, "#CC0000 filledlight", "#CC0000", "uk-icon-times");
            }
            listeNewsletter();
            $("#modalSuppr").modal('hide');
          }
        });
      });

      // Initialize the newsletter list
      listeNewsletter();
    });
  </script>

  <div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
      <div class="container">
        <div class="py-5">
          <div class="row g-4 align-items-center">
            <div class="col">
              <nav class="mb-2" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-sa-simple">
                  <li class="breadcrumb-item"><a href="index-admin.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Inscrits à la newsletter</li>
                </ol>
              </nav>
              <h1 class="h3 m-0">Inscrits à la newsletter</h1>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="p-4">
            <input type="text" placeholder="Rechercher des abonnés..." class="form-control form-control--search mx-auto"
              id="table-search" />
          </div>
          <div class="sa-divider"></div>

          <!-- Newsletter list will be loaded here via AJAX -->
          <div id="liste-newsletter"></div>
        </div>

        <!-- Modal container -->
        <div id="modal-container"></div>
      </div>
    </div>
  </div>

  <?php
} else {
  header('location: /index.html');
}
?>