
jQuery(document).ready(function(){

////////////////////////////////////////////////////POP-UP INSCRIPTION
$(document).on("click",".inscription_jspanel", function(e){
if($("#password_jspanel").length > 0){
jsPanel.activePanels.getPanel("password_jspanel").close();
}
if($("#login_jspanel").length > 0){
jsPanel.activePanels.getPanel("login_jspanel").close();
}

var urlcompte;
if($(this).attr("data-statut") != ""){
var urlcompte = "?compte="+$(this).attr("data-statut");
}
popup_panel("inscription_jspanel","/pop-up/inscription/inscription_popup.php"+urlcompte,"Inscription","300 auto","300 auto","modal","");
});
//SI LA MODALE EST OUVERTE, ON DONNE LA POSSIBILITE DE LA FERMER EN CLIQUANT SUR LA ZONE EXTERNE
$(document).on("click","#jsPanel-modal-backdrop-inscription_jspanel", function(){
jsPanel.activePanels.getPanel("inscription_jspanel").close();
});
////////////////////////////////////////////////////POP-UP INSCRIPTION

////////////////////////////////////////////////////POP-UP LOGIN
$(document).on("click",".login_jspanel", function(){
if($("#inscription_jspanel").length > 0){
jsPanel.activePanels.getPanel("inscription_jspanel").close();
}
if($("#password_jspanel").length > 0){
jsPanel.activePanels.getPanel("password_jspanel").close();
}
popup_panel("login_jspanel","/pop-up/login/login_popup.php","Identification","300 auto","300 auto","modal","");
});
//SI LA MODALE EST OUVERTE, ON DONNE LA POSSIBILITE DE LA FERMER EN CLIQUANT SUR LA ZONE EXTERNE
$(document).on("click","#jsPanel-modal-backdrop-login_jspanel", function(){
jsPanel.activePanels.getPanel("login_jspanel").close();
});
////////////////////////////////////////////////////POP-UP LOGIN

////////////////////////////////////////////////////POP-UP PASSWORD
$(document).on("click",".password_jspanel", function(){
if($("#inscription_jspanel").length > 0){
jsPanel.activePanels.getPanel("inscription_jspanel").close();
}
if($("#login_jspanel").length > 0){
jsPanel.activePanels.getPanel("login_jspanel").close();
}
popup_panel("password_jspanel","/pop-up/mot-de-passe-perdu/password_popup.php","Mot de passe perdu","300 auto","300 300","modal","");
});
//SI LA MODALE EST OUVERTE, ON DONNE LA POSSIBILITE DE LA FERMER EN CLIQUANT SUR LA ZONE EXTERNE
$(document).on("click","#jsPanel-modal-backdrop-password_jspanel", function(){
jsPanel.activePanels.getPanel("password_jspanel").close();
});
////////////////////////////////////////////////////POP-UP PASSWORD

////////////////////////////////////////////////////POP-UP PANIER
$(document).on("click",".ajouter-panier", function(){
if($("#panier_jspanel").length > 0){
jsPanel.activePanels.getPanel("panier_jspanel").close();
}
popup_panel("panier_jspanel","/pop-up/panier/panier_popup.php","Panier","300 auto","300 auto","modal",$(this).attr("data-id"));
});
//SI LA MODALE EST OUVERTE, ON DONNE LA POSSIBILITE DE LA FERMER EN CLIQUANT SUR LA ZONE EXTERNE
$(document).on("click","#jsPanel-modal-backdrop-panier_jspanel", function(){
jsPanel.activePanels.getPanel("panier_jspanel").close();
});
////////////////////////////////////////////////////POP-UP PANIER



});

////////////////////////////////////////////////////FONCTION POUR OUVRIR UNE POP-UP - JSPANEL
		function popup_panel(id_pop,url_ajax_panel,titre_panel,width_panel,minwidth_panel,paneltype,contenu_informations){
		//Si pas déjà ouvert
		if($("#"+id_pop).length < 1){
			$.jsPanel({
 				show:  "animated bounceInDown",
   				paneltype:  paneltype,
				id: id_pop,
		  		theme:       "DimGray", //https://developer.mozilla.org/en-US/docs/Web/CSS/color_value#Color_keywords
		  		contentSize: width_panel,
		  		resizable: minwidth_panel,
				position:{
    				my: 'center',
    				at: 'center',
   				of: 'window',
    				offsetX: 0,
   				offsetY: "-31%",
    				modify: true,
   				fixed: 'true',
    				autoposition: false
				},
    				onwindowresize: true,
		 	        headerTitle: titre_panel,
		    		contentAjax: {
		       		url: url_ajax_panel,
		        	method:   'POST',
		      		dataType: 'html',
				data : {contenu_informations:contenu_informations,},
		        	done:   function( data, textStatus, jqXHR, jsPanel ){
		          	this.content.append(data);
				}
		  		},
		 		callback:    function () {
		                this.content.css("padding", "15px");
		   		},

		   		// juste avant de fermer le panel, on supprime tinymce de tous les textarea
		   		onbeforeclose: function(){
				$('.jsPanel .mcediteur').each(function(index) {
		                tinyMCE.execCommand('mceRemoveEditor', false, $(this).attr('id'));
		                });
			  	},

			  	// une fois la modal fermée on réaffecte tinymce à toutes les modals encore ouvertes
			  	onclosed: function(){
				$('.jsPanel .mcediteur').each(function(index) {
		                tinyMCE.execCommand('mceAddEditor', false, $(this).attr('id'));
		                });
			  	}

			}).draggable("enable").draggable($.jsPanel.defaults.draggable);
	        }
		}
////////////////////////////////////////////////////FONCTION POUR OUVRIR UNE POP-UP - JSPANEL

////////////////////////////////////////////////////FONCTION POUR OUVRIR UNE POP-UP ALERT - JSPANEL 
let activePanel = null;

function popup_alert(texte_popup, color_popup, color_texte_popup, icon_popup) {
   
    if (activePanel && !activePanel.closed) {
        activePanel.close();
    }

    activePanel = $.jsPanel({
        template:    jsPanel.tplContentOnly,
        paneltype:   'hint',
        position:    'right-top -5 5 DOWN',
        theme:       color_popup,
        autoclose:   1000,
        border:      '0px solid',
        contentSize: '400 fit-content',
        show:        'animated slideInUp',
        content:     "<div><i class='" + icon_popup + "' style='margin:auto;'></i></div>" +
                     "<div style='margin:auto;'>" + texte_popup + "</div>" +
                     "<div style='margin:auto;'><i class='uk-icon-trash-o'></i></div>",
        callback: function(panel) {
            this.content.css({
                display: 'flex',
                color:   color_texte_popup
            });
            $('div:first-of-type', this.content).css({
                borderRadius: '50%',
                display:      'flex',
                fontSize:     '20px',
                margin:       '12px',
                width:        '60px',
                border:       '0px'
            });
            $('div', this.content).eq(1).css({
                display:    'flex',
                fontSize:   '19px',
                textAlign:  'center',
                border:     '0px',
                color:      color_texte_popup + ' !important',
                width:      'calc(100% - 126px)'
            });
            $('div', this.content).eq(2).css({
                display:       'flex',
                flexDirection: 'row-reverse',
                alignItems:    'flex-start',
                fontSize:      '18px',
                width:         '45px',
                border:        '0px',
                color:         color_texte_popup + ' !important',
                padding:       '4px'
            });
            $('div', this.content).eq(2).find('i').css({
                cursor: 'pointer'
            }).click(function() {
                panel.close();
            });
        }
    });
}
////////////////////////////////////////////////////FONCTION POUR OUVRIR UNE POP-UP ALERT - JSPANEL 



