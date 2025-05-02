<?php 

// -------
// ÉTAPE 1 : on vérifie si l'IP se trouve déjà dans la table.
// Pour faire ça, on n'a qu'à compter le nombre d'entrées dont le champ "ip" est l'adresse IP du visiteur.
$sql_count_visitors = "SELECT COUNT(*) AS nbre_entrees FROM membres_statistiques_actions_utilisateurs WHERE ip='". $_SERVER['REMOTE_ADDR'] ."'";
$retour_count_visitors = mysql_query($sql_count_visitors) ;
$donnees_count_visitors = mysql_fetch_row($retour_count_visitors);

if ($donnees_count_visitors[0] == 0) // L'IP ne se trouve pas dans la table, on va l'ajouter.
{
    // mysql_query("INSERT INTO membres_statistiques_actions_utilisateurs (ip, click_pop_up, like_fb, click_button_modal, click_lien_siteweb, timestamp_click_pop_up, timestamp_life_fb, timestamp_click_button_modal, timestamp_click_lien_siteweb, , derniere_connexion) VALUES('".$_SERVER['REMOTE_ADDR']."', '0', '0', '0', '0', '0', '0', '0', '0' '".time()."');") or die(mysql_error());
    mysql_query("INSERT INTO membres_statistiques_actions_utilisateurs (ip, derniere_connexion) VALUES('".$_SERVER['REMOTE_ADDR']."', '".time()."');") or die(mysql_error());
}
else // L'IP se trouve déjà dans la table, on met juste à jour le timestamp.
{
    mysql_query('UPDATE membres_statistiques_actions_utilisateurs SET derniere_connexion=' . time() . ' WHERE ip=\'' . $_SERVER['REMOTE_ADDR'] . '\'');
}

// -------
// ÉTAPE 2 : on supprime toutes les entrées dont le timestamp est plus vieux que 5 minutes.

// On stocke dans une variable le timestamp qu'il était il y a 5 minutes :
// $timestamp_5min = time() - (60 * 5); // 60 * 5 = nombre de secondes écoulées en 5 minutes
// mysql_query('DELETE FROM membres_statistiques_actions_utilisateurs WHERE derniere_connexion < ' . $timestamp_5min);

// -------
// ÉTAPE 3 : on compte le nombre d'IP stockées dans la table. C'est le nombre de visiteurs connectés.
$retour_count_visitors = mysql_query('SELECT COUNT(*) AS nbre_entrees FROM membres_statistiques_actions_utilisateurs');
$donnees_count_visitors = mysql_fetch_array($retour_count_visitors);


// Ouf ! On n'a plus qu'à afficher le nombre de connectés !
// echo '<p>Il y a actuellement ' . $donnees_count_visitors['nbre_entrees'] . ' visiteurs connectés sur le site !</p>';

$_SESSION['nbre_visiteurs_connectes'] = $donnees_count_visitors['nbre_entrees'];
?>