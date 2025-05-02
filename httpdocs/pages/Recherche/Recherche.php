
			<div class="row">
                                <div class="col-12">
                                    <div class="alert alert-primary alert-lg mb-3 alert-dismissible fade show">
                                        Il n'ya aucun résultats de recherche pour le moment .
                                    </div>
                                </div>
                            </div>
<?php
     
    // Connexion à la base donnée

    if ( isset($_POST['requete']) )
    $requete = htmlentities($conn->real_escape_string($_POST['requete']));


    if (!empty($requete))
    {
        $req = "SELECT * FROM site WHERE nom_site LIKE '%$requete%'"; 
        $exec = $conn->query($req);                            
// exécuter la requête
        $nb_resultats = $exec->num_rows;              // compter les résultats


    if($nb_resultats != 0) 
    {
       echo '<center>';   
       echo '
           <form action="" method="Post">
           <input type="text" name="requete" size="60px">
           <input type="submit" value="Ok">
           </form>';
      echo '</center>';
      echo '<font color="blue">Résultat de votre recherche </font><br/>
            <font size="2px">'.$nb_resultats.'</font>';


    if($nb_resultats > 1)
    {
        echo ' <font size="2px" color="red">résultats</font> ';
    }
        else
        {
            echo ' <font size="2px" color="red">résultats trouvé</font>  ';
        } 

       echo  '<font size="2px">dans notre base de données :</font><br/><br/>';



    while($donnees = mysqli_fetch_array($exec))
    {
    ?>

    <?php
          
          echo '<span>'; 
          echo '<font size="2px">'.$donnees['adresse_site'].'</font><br/>';
          echo  '<font size="2px">'.$donnees['nom_site'].'</font><br/>';
          echo '<font size="2px">'.$donnees['description_site'].'</font><br/>';
          echo '</span>';
    ?>

    <?php
    } // fin de la boucle
    ?>


    <?php
    }


    else {
        echo '<center>';   
        echo '
           <form action="" method="Post">
           <input type="text" name="requete" size="60px">
           <input type="submit" value="Ok">
           </form>';
        echo '</center>';
        echo '<h5>Pas de résultats</h3>';
        echo '<pre>Nous n avons trouver aucun résultats pour votre requête
              <font color="blue">' .$_POST['requete'].'</font></pre>';
      
     }
    }

    else
    { 


     echo '<center>';   
     echo '
           <form action="" method="Post">
           <input type="text" name="requete" size="60px">
           <input type="submit" value="Ok">
           </form>';
     echo '</center>';      

    }
?>