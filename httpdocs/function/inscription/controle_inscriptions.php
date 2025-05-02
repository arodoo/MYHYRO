<?php
/*
////INCLUDES CONFIGURATIONS CMS CODI ONE
require_once('../../Configurations_bdd.php');
require_once('../../Configurations.php');
require_once('../../Configurations_modules.php');

////INCLUDE FUNCTION HAUT CMS CODI ONE
include('../../function/INCLUDE-FUNCTION-HAUT-CMS-CODI-ONE.php');
*/

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

/////////////////CFG NOMBRE DE CARACTERES
$maxpost = "30";
$minpost = "6";
/////////////////CFG NOMBRE DE CARACTERES
///////////////////////////////////////////////////////////////////////////////////////////////////////////POST ET ANTI INJECTIONS
$pseudo_creation = $_POST['pseudo_creation'];
$Mail = strtolower($_POST['Mail']);
$Nom = $_POST['Nom'];
$Prenom = $_POST['Prenom'];

$Numero = $_POST['Numero'];
$Type_extension = $_POST['Type_extension'];
$type_voie = $_POST['type_voie'];
$Adresse = $_POST['Adresse'];
$Code_postal = $_POST['Code_postal'];
$Ville = $_POST['Ville'];

$Telephone = $_POST['Telephone'];
$Telephone_portable = $_POST['Telephone_portable'];

$FH = $_POST['FH'];
$faxpost = $_POST['faxpost'];

$cbaonepost = $_POST['cbaonepost'];
$Pays = $_POST['Pays'];
$Birthday = (new Datetime($_POST['Birthday']))->getTimestamp();
$cbb = $_POST['cbb'];
$password_actuel = $_POST['password_actuel'];
$password = $_POST['password'];
$passwordclient2 = $_POST['passwordclient2'];

$type_de_compte = $_POST['type_de_compte'];

$passct = "$password";

$civilites = $_POST['civilites'];
$prenom_autres = $_POST['prenom_autres'];
$ville_naissance = $_POST['ville_naissance'];
$pays_naissance = $_POST['pays_naissance'];
$datenaissance = $_POST['datenaissance'];

$Adresse_de_facturation_differente = $_POST['Adresse_de_facturation_differente'];

$societe = $_POST['societe'];
$mail_facturation = $_POST['mail_facturation'];
$nom_facturation = $_POST['nom_facturation'];
$prenom_facturation = $_POST['prenom_facturation'];
$adresse_facturation = $_POST['adresse_facturation'];
$ville_facturation = $_POST['ville_facturation'];
$code_postal_facturation = $_POST['code_postal_facturation'];

$Nom_societe = $_POST['Nom_societe'];
$Numero_identification = $_POST['Numero_identification'];

$CSP = $_POST['CSP'];
$Votre_quartier = $_POST['Votre_quartier'];
$Decrivez_un_peut_plus_chez_vous = $_POST['Decrivez_un_peut_plus_chez_vous'];
$Complement_d_adresse = $_POST['Complement_d_adresse'];

$Code_securite = $ligne_select['Code_securite'];

///////////////////////////////////////////////////////////////////////////////////////////////////////////POST ET ANTI INJECTIONS
///////////////////////////////////////////////////////// VERIF EN MODE POP UP ET STANDARD

///////////////////////SI FACTURATION AUTRES
if($Adresse_de_facturation_differente == "oui"){

///////////////////////DATE DE NAISSANCE
if ($modif == "oui" && (empty($societe) || empty($mail_facturation) || empty($nom_facturation) || empty($prenom_facturation) || empty($adresse_facturation) || empty($ville_facturation) || empty($code_postal_facturation)) )
{
    $err = "1";
    $erreur_password = "<span>Remplissez tous les champs <b>de l'adresse de facturation</b> !</span>";
    $errppass = "1";
    $result = array(
        "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_password </div>",
        "retour_validation" => "",
        "retour_lien" => ""
    );
    $result2 = array(
        "Texte_rapport" => "$erreur_password",
        "retour_validation" => "",
        "retour_lien" => ""
    );

}

}

//////////////////////////////////////SI LES CONDITIONS GENERALES EXISTES
if (!empty($lien_conditions_generales) && $modif != "oui")
{
    ////////////////////////////////////SECTION CHARTE
    if ($cbaonepost != 1 || $cbaonepost != 1 && $modif != "oui")
    {
        $err = "1";
        $erreur_cgu = "<span>Acceptez les <b>conditions générales</b> !</span>";
        $errcharte = "1";
        //$coloorprcharte = "color: red;";
        $result = array(
            "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_cgu </div>",
            "retour_validation" => "",
            "retour_lien" => ""
        );
        $result2 = array(
            "Texte_rapport" => "$erreur_cgu",
            "retour_validation" => "",
            "retour_lien" => ""
        );
    }
    else
    {
        $checkedok = "checked='checked'";
    }
    ////////////////////////////////////SECTION CHARTE
    
}

////////////////////////////////////PASSWORD
if ($modif == "oui" && $_POST['password'] != $_POST['passwordclient2'] && !empty($_POST['passwordclient2']) && !empty($_POST['password']))
{
    $err = "1";
    $erreur_password = "<span>Les <b>mots de passe</b> ne correspondent pas !</span>";
    $errppass = "1";
    //$coloorppasse = "border: 2px solid red;";
    $result = array(
        "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_password </div>",
        "retour_validation" => "",
        "retour_lien" => ""
    );
    $result2 = array(
        "Texte_rapport" => "$erreur_password",
        "retour_validation" => "",
        "retour_lien" => ""
    );

}
elseif (strlen($password) < 8 && $modif != "oui" || !empty($password) && strlen($password) < 8 && $modif == "oui")
{
    $erreur_password = "<span>Le mot de passe doit être constitué de <b>8 caractères minimum</b> !</span>";
    $erreur_password2 = "<span>Mot de passe à <b>8 caractères minimum</b> !</span>";
    $err = "1";
    $errppass = "1";
    //$coloorppasse = "border: 2px solid red;";
    $result = array(
        "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_password </div>",
        "retour_validation" => "",
        "retour_lien" => ""
    );
    $result2 = array(
        "Texte_rapport" => "$erreur_password2",
        "retour_validation" => "",
        "retour_lien" => ""
    );

}
elseif ((!preg_match("#[a-z]#", $password) || !preg_match("#[0-9]#", $password)) && $modif != "oui" || !empty($password) && (!preg_match("#[a-z]#", $password) || !preg_match("#[0-9]#", $password)) && $modif == "oui")
{
    $erreur_password = "<span>Le mot de passe doit être constitué de <b>lettres et de chiffres</b> !</span>";
    $err = "1";
    $errppass = "1";
    //$coloorppasse = "border: 2px solid red;";
    $result = array(
        "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_password </div>",
        "retour_validation" => "",
        "retour_lien" => ""
    );
    $result2 = array(
        "Texte_rapport" => "$erreur_password",
        "retour_validation" => "",
        "retour_lien" => ""
    );

}
elseif (ctype_upper($password) == true && $modif != "oui" || !empty($password) && ctype_upper($password) == true && $modif == "oui")
{
    $erreur_password = "<span>Le mot de passe doit être constitué d'<b>une minuscule au minimum</b> !</span>";
    $err = "1";
    $errppass = "1";
    //$coloorppasse = "border: 2px solid red;";
    $result = array(
        "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_password </div>",
        "retour_validation" => "",
        "retour_lien" => ""
    );
    $result2 = array(
        "Texte_rapport" => "$erreur_password",
        "retour_validation" => "",
        "retour_lien" => ""
    );

}
elseif (ctype_upper($password) && $modif != "oui" || !empty($password) && ctype_upper($password) && $modif == "oui")
{
    $erreur_password = "<span>Le mot de passe doit être constitué d'<b>une majuscule au minimum</b> !</span>";
    $err = "1";
    $errppass = "1";
    //$coloorppasse = "border: 2px solid red;";
    $result = array(
        "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_password </div>",
        "retour_validation" => "",
        "retour_lien" => ""
    );
    $result2 = array(
        "Texte_rapport" => "$erreur_password",
        "retour_validation" => "",
        "retour_lien" => ""
    );

}
elseif (empty($_POST['password']) && $modif != "oui")
{
    $err = "1";
    $erreur_password = "<span>Vous devez indiquer <b>un mot de passe</b> !</span>";
    $errppass = "1";
    //$coloorppasse = "border: 2px solid red;";
    $result = array(
        "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_password </div>",
        "retour_validation" => "",
        "retour_lien" => ""
    );
    $result2 = array(
        "Texte_rapport" => "$erreur_password",
        "retour_validation" => "",
        "retour_lien" => ""
    );

}
elseif ($modif == "oui" && empty($_POST['passwordclient2']) && !empty($_POST['password']))
{
    $erreur_password = "<span>Vous devez <b>confirmer le mot de passe</b> !</span>";
    $err = "1";
    $errppass = "1";
    //$coloorppasse = "border: 2px solid red;";
    $result = array(
        "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_password </div>",
        "retour_validation" => "",
        "retour_lien" => ""
    );
    $result2 = array(
        "Texte_rapport" => "$erreur_password",
        "retour_validation" => "",
        "retour_lien" => ""
    );

}

////////////////////////////////////SOCIETE
if($modif == "oui" && empty($_POST['Nom_societe']) && $statut_compte_oo == 2 ){
    $erreur_societe = "<span>Vous devez <b>indiquer un nom de société</b> !</span>";
    $err = "1";
    $errsociete = "1";
    //$coloorppasse = "border: 2px solid red;";
    $result = array(
        "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_societe </div>",
        "retour_validation" => "",
        "retour_lien" => ""
    );
    $result2 = array(
        "Texte_rapport" => "$erreur_societe",
        "retour_validation" => "",
        "retour_lien" => ""
    );
}

if($modif == "oui" && empty($_POST['Numero_identification'])  && $statut_compte_oo == 2 ){
    $erreur_siret = "<span>Vous devez <b>indiquer un siret</b> !</span>";
    $err = "1";
    $errsiret = "1";
    //$coloorppasse = "border: 2px solid red;";
    $result = array(
        "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_siret </div>",
        "retour_validation" => "",
        "retour_lien" => ""
    );
    $result2 = array(
        "Texte_rapport" => "$erreur_siret",
        "retour_validation" => "",
        "retour_lien" => ""
    );

}
////////////////////////////////////SOCIETE

////////////////////////////////////PASSWORD
////////////////////////////////////PASSWORD ACTUEL - CONTRÔLE
if ($modif == "oui")
{
    $pass = hash("sha256", $password_actuel);
    ///////////////////////////////SELECT
    $req_select = $bdd->prepare("SELECT * FROM membres 
	WHERE mail=? 
	and pass=?");
    $req_select->execute(array(
        $mail_oo,
        $pass
    ));
    $ligne_select = $req_select->fetch();
    $req_select->closeCursor();
    $id_controle_passe = $ligne_select['id'];
}

/*if (empty($password_actuel) && $modif == "oui")
{
    $erreur_password = "<span>Vous devez <b>indiquer le mot de passe actuel</b> !</span>";
    $err = "1";
    $errppass = "1";
    //$coloorppasse = "border: 2px solid red;";
    $result = array(
        "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_password </div>",
        "retour_validation" => "",
        "retour_lien" => ""
    );
    $result2 = array(
        "Texte_rapport" => "$erreur_password",
        "retour_validation" => "",
        "retour_lien" => ""
    );

}
elseif (empty($id_controle_passe) && !empty($password_actuel) && $modif == "oui")
{
    $erreur_password = "<span>Le mot de passe actuel <b>n'est pas correct</b> !</span>";
    $err = "1";
    $errppass = "1";
    //$coloorppasse = "border: 2px solid red;";
    $result = array(
        "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_password </div>",
        "retour_validation" => "",
        "retour_lien" => ""
    );
    $result2 = array(
        "Texte_rapport" => "$erreur_password",
        "retour_validation" => "",
        "retour_lien" => ""
    );

}*/
////////////////////////////////////PASSWORD ACTUEL - CONTRÔLE
////////////////////////////////////MAIL
///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM membres 
	WHERE mail=?");
$req_select->execute(array(
    htmlspecialchars($Mail)
));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$mailidpost = $ligne_select['mail'];

///////////////////////////////SELECT
$req_select = $bdd->prepare("SELECT * FROM membres 
	WHERE pseudo=?");
$req_select->execute(array(
    htmlspecialchars($user)
));
$ligne_select = $req_select->fetch();
$req_select->closeCursor();
$maildeja = $ligne_select['mail'];

if (!empty($Mail) && preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4}$/", $Mail))
{
    $array = explode('@', $Mail);
    $ap = $array[1];
    $domain = checkdnsrr($ap);
}

if ($Mail == "")
{
    $erreur_mail = "<span>Indiquer une <b>adresse mail</b>.</span >";
    $err = "1";
    $errmail = "1";
    //$coloorm = "border: 2px solid red;";
    $result = array(
        "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_mail </div>",
        "retour_validation" => "",
        "retour_lien" => ""
    );
    $result2 = array(
        "Texte_rapport" => "$erreur_mail",
        "retour_validation" => "",
        "retour_lien" => ""
    );

}
elseif ($mailidpost == $Mail && $modif != "oui" || $modif == "oui" && !empty($Mail) && $maildeja != $Mail && !empty($mailidpost))
{
    $erreur_mail = "<span><b>Adresse mail</b> déjà utilisée.</span >";
    $err = "1";
    $errmail = "1";
    //$coloorm = "border: 2px solid red;";
    $result = array(
        "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_mail </div>",
        "retour_validation" => "",
        "retour_lien" => ""
    );
    $result2 = array(
        "Texte_rapport" => "$erreur_mail",
        "retour_validation" => "",
        "retour_lien" => ""
    );

}
elseif (!preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4}$/", $Mail))
{
    $erreur_mail = "<span><b>Adresse mail</b> non conforme.</span >";
    $err = "1";
    $errmail = "1";
    //$coloorm = "border: 2px solid red;";
    $result = array(
        "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_mail </div>",
        "retour_validation" => "",
        "retour_lien" => ""
    );
    $result2 = array(
        "Texte_rapport" => "$erreur_mail",
        "retour_validation" => "",
        "retour_lien" => ""
    );

}
elseif ($domain == false)
{
    $erreur_mail = "<span><b>Adresse mail</b> (Le domaine n'existe pas)</span >";
    $err = "1";
    $errmail = "1";
    //$coloorm = "border: 2px solid red;";
    $result = array(
        "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_mail </div>",
        "retour_validation" => "",
        "retour_lien" => ""
    );
    $result2 = array(
        "Texte_rapport" => "$erreur_mail",
        "retour_validation" => "",
        "retour_lien" => ""
    );

}
////////////////////////////////////MAIL


// ////////////////////////////////////PRENOM
 if (empty($Prenom))
 {
     $erreur_prenom = "<span >Indiquez un <b>prénom</b></span >";
     $err = "1";
     $errprenom = "1";
     unset($_POST['Prenom']);
     unset($Prenom);
     //$coloorpr = "border: 2px solid red;";
     $result = array(
         "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_prenom </div>",
         "retour_validation" => "",
         "retour_lien" => ""
     );
     $result2 = array(
         "Texte_rapport" => "$erreur_prenom",
         "retour_validation" => "",
         "retour_lien" => ""
     );

 }
 elseif (!preg_match("/^[a-zA-Z-çñÄÂÀÁäâàáËÊÈÉéèëêÏÎÌÍïîìíÖÔÒÓöôòóÜÛÙÚüûùúµ ]+$/", $Prenom))
 {
     $erreur_prenom = "<span ><b>Prénom</b> non conforme (caractères alphanumériques uniquement).</span >";
     $err = "1";
     $errprenom = "1";
     unset($_POST['Prenom']);
     unset($Prenom);
     //$coloorpr = "border: 2px solid red;";
     $result = array(
         "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_prenom </div>",
         "retour_validation" => "",
         "retour_lien" => ""
     );
     $result2 = array(
         "Texte_rapport" => "$erreur_prenom",
         "retour_validation" => "",
         "retour_lien" => ""
     );

 }
// ////////////////////////////////////PRENOM

// ////////////////////////////////////NOM
 if ($Nom == "")
 {
     $erreur_nom = "<span>Indiquez un <b>nom</b>.</span >";
     $err = "1";
     $errname = "1";
     unset($Nom);
     unset($_POST['Nom']);
     //$coloorn = "border: 2px solid red;";
     $result = array(
         "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_nom </div>",
         "retour_validation" => "",
         "retour_lien" => ""
     );
     $result2 = array(
         "Texte_rapport" => "$erreur_nom",
         "retour_validation" => "",
         "retour_lien" => ""
     );

 }
 elseif (!preg_match("/^[a-zA-Z-çñÄÂÀÁäâàáËÊÈÉéèëêÏÎÌÍïîìíÖÔÒÓöôòóÜÛÙÚüûùúµ ]+$/", $Nom))
 {
     $erreur_nom = "<span ><b>Nom</b> non conforme (caractères alphanumériques uniquement).</span >";
     $err = "1";
     $errname = "1";
     unset($Nom);
     unset($_POST['Nom']);
     //$coloorn = "border: 2px solid red;";
     $result = array(
         "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_nom </div>",
         "retour_validation" => "",
         "retour_lien" => ""
     );
     $result2 = array(
         "Texte_rapport" => "$erreur_nom",
         "retour_validation" => "",
         "retour_lien" => ""
     );

 }
////////////////////////////////////NOM

if($modif == "oui"){

     ////////////////////////////////////CODE POSTAL
     if (empty($Code_postal) && $Pays != "Gabon" )
     {
         $err = "1";
         $errcodepostale = "1";
         $erreur_code_postal = "<span>Vous devez indiquer un <b>code postal</b> !</span>";
         unset($_POST['Code_postal']);
         unset($Code_postal);
         //$coloorpccc = "border: 2px solid red;";
         $result = array(
             "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_code_postal </div>",
             "retour_validation" => "",
             "retour_lien" => ""
         );
         $result2 = array(
             "Texte_rapport" => "$erreur_code_postal",
             "retour_validation" => "",
             "retour_lien" => ""
         );

     }
     ////////////////////////////////////CODE POSTAL

     ////////////////////////////////////ADRESSE
     if (empty($Adresse))
     {
         $err = "1";
         $erradresse = "1";
         $erreur_adresse = "<span>Vous devez indiquer une <b>adresse</b> !</span>";
         unset($_POST['Adresse']);
         unset($Adresse);
         //$coloorpaaa = "border: 2px solid red;";
         $result = array(
             "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_adresse </div>",
             "retour_validation" => "",
             "retour_lien" => ""
         );
         $result2 = array(
             "Texte_rapport" => "$erreur_adresse",
             "retour_validation" => "",
             "retour_lien" => ""
         );
	}
     ////////////////////////////////////ADRESSE

     ////////////////////////////////////DATE DE NAISSANCE
     if (empty($datenaissance))
     {
         $err = "1";
         $errdatenaissance = "1";
         $erreur_datenaissance = "<span>Vous devez indiquer une <b>date de naissance</b> !</span>";
         unset($_POST['datenaissance']);
         unset($datenaissance);
         //$coloorpaaa = "border: 2px solid red;";
         $result = array(
             "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_datenaissance </div>",
             "retour_validation" => "",
             "retour_lien" => ""
         );
         $result2 = array(
             "Texte_rapport" => "$erreur_datenaissance",
             "retour_validation" => "",
             "retour_lien" => ""
         );
	}
     ////////////////////////////////////DATE DE NAISSANCE

     ////////////////////////////////////DATE DE NAISSANCE
     if (empty($Votre_quartier) && $Pays == "Gabon" )
     {
         $err = "1";
         $errVotre_quartier = "1";
         $erreur_Votre_quartier = "<span>Vous devez indiquer un <b>quartier</b> !</span>";
         unset($_POST['Votre_quartier']);
         unset($Votre_quartier);
         //$coloorpaaa = "border: 2px solid red;";
         $result = array(
             "Texte_rapport" => "<div class='rapport_red' ><span class='uk-icon-warning' ></span> $erreur_Votre_quartier </div>",
             "retour_validation" => "",
             "retour_lien" => ""
         );
         $result2 = array(
             "Texte_rapport" => "$erreur_Votre_quartier",
             "retour_validation" => "",
             "retour_lien" => ""
         );
	}
     ////////////////////////////////////DATE DE NAISSANCE

}

?>
