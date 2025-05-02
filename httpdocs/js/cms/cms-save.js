jQuery(document).ready(function(){

jQuery.noConflict();
function clickinputfile(val) {
var input = document.getElementById(val);
jQuery(input).trigger('click');
}

$ = jQuery.noConflict();

if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
  $('.selectpicker').selectpicker('mobile');
}

//BOOSTRAP TOLLTIP
$('[data-toggle="tooltip"]').tooltip();

//DATEPICKER
$( "#datepicker" ).datepicker();

	var list_appel_offre = $('#list_appel_offre');

	function form_button_appel_d_offre(obj, this_button, name_class)
	{
		obj.each(function(){
			$(this).parent().css({"background-color": "white", "color": "#636363"});
			$(this).removeClass(name_class);
			$(this).removeAttr("checked");
		});
		this_button.parent().css({"background-color": "green", "color": "white"});
		this_button.addClass(name_class);
		this_button.attr('checked', 'checked');
	}

	function split( val ) {
		return val.split(/,\s*/);
	}
	
	function extractLast(term) {
		return split(term).pop();
	}

	var postuler = $("#postuler");
	postuler.click(function(){
		var fiche = postuler.attr("data-id_fiche");
		var user = postuler.attr("data-id_presta");
		$.post("/Demande-appel-offre/popup-creation-appel-offre-ajax.php", {id_fiche: fiche, user: user}, function(data){
			var ret = $.parseJSON(data);
			if (ret.error == ""){
				swal({
					title: 'Proposer vos services',
					type: 'question',
					html:ret.msg,
					showCloseButton: true,
					showConfirmButton: false
				});
			}
			else{
				alert(ret.msg);
			}

		});

	var repondre_prive = $(".repondre_prive");
	repondre_prive.click(function(){
		var fiche = $(this).attr("data-id_fiche");
		var user = $(this).attr("data-id_presta");
		var id_message_private = $(this).attr("data-id_message");
		$.post("/Demande-appel-offre/appel-offre-message-prive.php", {id_fiche: fiche, user: user, id_message_private: id_message_private}, function(data){
			var ret = $.parseJSON(data);
			if (ret.error == ""){
				swal({
					title: 'Message privé',
					type: 'question',
					html:ret.msg,
					showCloseButton: true,
					showConfirmButton: false
				});
			}
			else{
				alert(ret.msg);
			}

		});
		// alert("User " + user + " fiche " + fiche + " id_message_private " + id_message_private);
	});


	var input_proposition = $("#autocomplete_proposition");

	if (input_proposition.length){
		input_proposition
		.on("keydown", function(event){
			if (event.keyCode === $.ui.keyCode.TAB && $(this).autocomplete("instance").menu.active) {
				event.preventDefault();
			}
		})
		.autocomplete({
			minLength: 0,
			source: function(request, response) {
				$.ajax({
					url: "Demande-appel-offre/fiche-appel-offre-liste-prestataire-ajax.php",
					dataType: "json",
					data: {
						q: request.term
					},
					success: function(data){
						response(data);
					}
				});
			},
			focus: function() {
				return false;
			},
			select: function(event, ui) {
				var terms = split(this.value);
				terms.pop();
				terms.push(ui.item.value);
				terms.push("");
				this.value = terms.join(", ");
				return false;
			}
		});
	}

	var depart_projet = $(".depart_projet");
	depart_projet.click(function(){
		form_button_appel_d_offre(depart_projet, $(this), "start_selected");
	});

	var budget = $(".budget");
	budget.click(function(){
		form_button_appel_d_offre(budget, $(this), "budget_selected");
	});

	var input_file_appel_d_offre = $("#file_uploded");
	input_file_appel_d_offre.change(function(){
		var name = input_file_appel_d_offre.val().split('\\');
		var i = 0;
		while (name[i])
			i++;
		$("#name_file").text(" " + name[i - 1]);
	});

	var dropzone = $("#dropzone_form");
	if (dropzone.length){
		dropzone.dropzone({
			dictDefaultMessage: "Put your custom message here",
			maxFilesize: 2,
			maxFiles: 7,
			acceptedFiles: "image/*, application/pdf, .txt, .csv, .doc, .ppt, .xls, .odt, .zip, .rar, .ace, .gz, .docx, .xlsx, .pptx, .psd",
			paramName: 'uploaded_file',
			uploadMultiple: true
		});

		$(".dz-message span").text("Faites glisser vos fichiers ici");
	}

	$(document).change(function(){
		if ($("#private_msg1").val() && $("#titre_message_prive1").val())
			$("#form_submit1").removeAttr('disabled');
		else
			$("#form_submit1").attr('disabled', 'disabled');
	});

	$(document).change(function(){
		if ($("#private_msg3").val())
			$("#form_submit3").removeAttr('disabled');
		else
			$("#form_submit3").attr('disabled', 'disabled');
	});

	$(document).change(function(){
		if ($("#Mon_offre").val() && $("#nb_jour").val() && $("#public_msg").val() && $("#private_msg").val())
			$("#form_submit2").removeAttr('disabled');
		else
			$("#form_submit2").attr('disabled', 'disabled');
	});

	$(document).on("click", ".seek", function() {
		var id = $(this).attr("data-id");
		if ($(this).hasClass('a_rechercher')){
			$(this).removeClass('a_rechercher uk-icon-plus');
			$(this).addClass('recherche uk-icon-minus');
			$.post('/Demande-appel-offre/fiche-appel-offre-update-recherche-ajax.php', {id: id, statut: "recherche"});
		}
		else{
			$(this).removeClass('recherche uk-icon-minus');
			$(this).addClass('a_rechercher uk-icon-plus');
			$.post('/Demande-appel-offre/fiche-appel-offre-update-recherche-ajax.php', {id: id, statut: "a_rechercher"});
		}
	});

	var form_submit_update = $("#form_submit_update");
	if (form_submit_update.length){
		$("#champ_type, #lieu_event, #titre_projet, #decription, .depart_projet, .budget").change(function(){
			if ($('#champ_type').val() && $('#lieu_event').val() && $('#titre_projet').val() && $('#decription').val() && $(".budget").hasClass("budget_selected") &&
				$(".depart_projet").hasClass("start_selected"))
				form_submit_update.removeAttr('disabled');
			else
				form_submit_update.attr('disabled', 'disabled');
			console.log($('#champ_type').val());
		});
	}

	var submit_form = $("#form_submit");

	if (submit_form.length){
		//$("#champ_type, #lieu_event, #titre_projet, #nom, #prenom, #email, #telephone, #decription, .depart_projet, .budget, #adress, #post_code, #city").change(function(){
		$(document).on("change", function(){
			if ($('#champ_type').val() && $('#lieu_event').val() && $('#titre_projet').val() && $('#nom').val() && $('#prenom').val() &&
				$('#email').val() && $('#telephone').val() && $('#decription').val() && $(".budget").hasClass("budget_selected") &&
				$(".depart_projet").hasClass("start_selected") && $("#adress").val() && $("#post_code").val() && $("#city").val())
				submit_form.removeAttr('disabled');
			else
				submit_form.attr('disabled', 'disabled');
		});
	}

	var form_modification_appel_offre = $("#form_modification_appel_offre");
	if (form_modification_appel_offre.length){
		$(document).on("change", function(){
			if ($('#champ_type2').val() && $('#lieu_event2').val() && $('#titre_projet2').val() &&
				$('#decription2').val() && $(".budget").hasClass("budget_selected") &&
				$(".depart_projet").hasClass("start_selected"))
				$("#form_submit_update").removeAttr('disabled');
			else
				$("#form_submit_update").attr('disabled', 'disabled');
		});
	}

	var toggle_list_action = $("#toggle_list_action");
	toggle_list_action.click(function(){
		$("#list_action").toggle("slow");
	});


	var type_choix_1 = $("#type_choix_1");
	var proposition_depart_projet_date = $(".proposition_depart_projet_date");
	var proposition_depart_projet_radio = $(".proposition_depart_projet_radio");
	if (type_choix_1.length){
		if (type_choix_1.val() == 1){
			proposition_depart_projet_date.hide();
			proposition_depart_projet_radio.show();
		}
		else if (type_choix_1.val() == 4){
			proposition_depart_projet_date.show();
			proposition_depart_projet_radio.hide();
		}
		else{
			proposition_depart_projet_date.show();
			proposition_depart_projet_radio.hide();
		}
		type_choix_1.change(function(){
			if (type_choix_1.val() == 1){
				proposition_depart_projet_date.hide();
				proposition_depart_projet_radio.show();
			}
			else if (type_choix_1.val() == 4){
				proposition_depart_projet_date.show();
				proposition_depart_projet_radio.hide();
			}
			else{
				proposition_depart_projet_date.hide();
				proposition_depart_projet_radio.hide();
			}
		});
	}

	var type_choix_2 = $("#type_choix_2");
	var proposition_buget_radio = $(".proposition_buget_radio");
	var proposition_buget_date = $(".proposition_buget_date");
	if (type_choix_2.length){
		if (type_choix_2.val() == 1){
			proposition_buget_radio.show();
			proposition_buget_date.hide();
		}
		else if (type_choix_2.val() == 4){
			proposition_buget_radio.hide();
			proposition_buget_date.show();
		}
		else{
			proposition_buget_radio.hide();
			proposition_buget_date.hide();
		}
		type_choix_2.change(function(){
			alert(type_choix_2.val());
			if (type_choix_2.val() == 1){
				proposition_buget_radio.show();
				proposition_buget_date.hide();
			}
			else if (type_choix_2.val() == 4){
				proposition_buget_radio.hide();
				proposition_buget_date.show();
			}
			else{
				proposition_buget_radio.hide();
				proposition_buget_date.hide();
			}
		});
	}

	$(document).on("click", "#button_file", function(){
		var file_input = $("#file_input");
		var name_file = $("#name_file");
		file_input.change(function(){
			var ret = file_input.val();
			var start = ret.lastIndexOf('\\') + 1;
			var end = ret.length - start;
			name_file.text(ret.substr(start, end));
		});
	});

	var on_off = $('.on_off');
	if (on_off.length)
		on_off.bootstrapToggle({});

	var searchTextField = $("#searchTextField");
	if (searchTextField.length){
		var start = searchTextField.val();
		searchTextField.autocomplete({
			source: function(request, response){
				$.ajax({
					url: "Demande-appel-offre/ajax-list-ville.php",
					dataType: "json",
					data: {
						q: request.term
					},
					success: function(data){
						response(data);
					}
				});
			}
		});
	}

	$(document).on("change", ".action_user", function(){
		$(".action_user option:selected").each(function(){
			
			if ($(this).val() == "Litige")
				$('#litige').trigger('click');
			else if ($(this).val() == "Modifier")
			{
				$url = $(this).data("url");
				window.location.replace($url);
			}
			else if ($(this).val() == "Signaler")
				$('#signalement').trigger('click');
			// else

		});
	});

	$(document).on("change", ".action_presta", function(){
		$(".action_presta option:selected").each(function(){
			var id = $(this).data("id");
			if ($(this).val() == 'Choisir_ce_presta')
				$('#presta'+id).trigger('click');
			else if ($(this).val() == 'message_prive_fiche')
				$('#message'+id).trigger('click');
			else if ($(this).val() == 'Afficher_coordonees')
			{
				var id_presta = $(this).data("id_presta");
				$("#coordonees_presta_"+ id_presta).toggle("slow");
			}
			// else

		});
		$(".action_presta").each(function(){
			$(this).val("action");
		});
	});

});

});