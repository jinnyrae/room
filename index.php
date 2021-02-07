<style>
h5{
    color: #800020;
</style>

<?php

require_once 'inc/init.php';

        $contenu_categories = '';  // pour le HTML des catégories
        $contenu_produits = '';  // pour le HTML des produits
        $contenu_villes = ''; //pour le HTML des villes
        $contenu_capacites = ''; //pour le HTML des capacites
        $contenu_prix = ''; //pour le HTML le prix
        $contenu_date_arrive = ''; //pour le HTML date arive
        $contenu_date_depart = ''; //pour le HTML date depart


#1- Affichage catégories:

    $resultat= executeRequete("SELECT DISTINCT categorie FROM salle "); # Tous les catégories

    $contenu_categories .= '<div class= "list-group mb-4">';
 

    $categories = $resultat->fetchAll(PDO::FETCH_ASSOC); # Tous les catégorie qui proviennet de la BDD
    #debug($categories);
        foreach ($categories as $categorie){
    
                     $contenu_categories.= '<a href="?categorie='. $categorie['categorie'] .'"class="list-group-item">' . ucfirst($categorie['categorie']).'</a>';
                     }
                        $contenu_categories.= '</div>';


 # 2- affichage villes:
                 $resultat= executeRequete("SELECT DISTINCT ville FROM salle "); # Toutes les villes

                            $contenu_villes .= '<div class= "list-group mb-4">';

                $villes = $resultat->fetchAll(PDO::FETCH_ASSOC); # toutes les villes qui proviennet de la BDD
                #debug($villes);
                    foreach ($villes as $ville){
    
                       $contenu_villes .= '<a href="?ville='. $ville['ville'] .'"class="list-group-item">' . ucfirst($ville['ville']).'</a>';
                        }
                      $contenu_villes.= '</div>';


   # 4- Affichage capacité:

            $resultat= executeRequete("SELECT DISTINCT capacite FROM salle "); # Toutes les capacités

                $contenu_capacites .= '<div class= "list-group mb-4">';
 
                    $capacites = $resultat->fetchAll(PDO::FETCH_ASSOC); # toutes les villes qui proviennet de la BDD
                    #debug($capacites);
                      $contenu_capacites .= '<select "class="list-group-item">';
                         foreach ($capacites as $capacite){
                             
                               $contenu_capacites .= '<option>'.($capacite['capacite']) .'</option>';
                        }
                        $contenu_capacites .= '</select>';
                         $contenu_capacites.= '</div>';


    # 5- Affichage prix:

            $resultat= executeRequete("SELECT max(prix) AS max FROM produit "); # Toutes prix

                $contenu_prix .= '<div class="slidecontainer">';
 
                    $prixs = $resultat->fetch(PDO::FETCH_ASSOC); # toutes les villes qui proviennet de la BDD
                    debug($prixs);
                               $contenu_prix .= '<lable class="form-label" name="prix">' .$prixs['max'] . '€' .'</lable>';
                               $contenu_prix .= '<input type="range" id="rangeInput" class="form-range" min="0" max="'.$prixs['max'].'" step="50" id="customRange3" name="prix" oninput="amount.value=rangeInput.value">';
                               $contenu_prix .= '<output id="amount" name="amount" for="rangeInput">0</output>';
                      
                $contenu_prix.= '</div>';

     # 6- Affichage date-arrive:

 $resultat= executeRequete("SELECT DISTINCT date_arrive FROM produit "); # Toutes les dates arrive

 $contenu_date_arrive .= '<div class= "list-group mb-4">';

     $date_arrives = $resultat->fetchAll(PDO::FETCH_ASSOC); # toutes les dates arrive qui proviennet de la BDD
     #debug($date_arrives);
      
        
             $contenu_date_arrive.= '<label for="date_arrive">Date d\'arrivée: </label>';
             $contenu_date_arrive .= '<input type="date" id="date_arrive" name="date_arrive>';
         
       
           $contenu_date_arrive.= '</div>';

# 7- Affichage date-depart:

 $resultat= executeRequete("SELECT DISTINCT date_depart FROM produit "); # Toutes les dates depart

 $contenu_date_depart.= '<div class= "list-group mb-4">';

 $date_depart = $resultat->fetchAll(PDO::FETCH_ASSOC); # toutes les dates depart qui proviennet de la BDD
     #debug($date_depart);
         
             $contenu_date_depart.= '<label for="date_arrive">Date de départ: </label>';
             $contenu_date_depart.= '<input type="date" id="date_depart" name="date_depart>';
     
              $contenu_date_depart.= '</div>';




  #2- Affichage des produit
   

  if(isset($_GET['categorie']) && $_GET['categorie'] != 'all'){ 
    # si catégorie dans 'url, ou different de all
    $resultat= executeRequete("SELECT produit.* , salle.* FROM produit INNER JOIN salle ON produit.id_salle=salle.id_salle WHERE categorie = :categorie", array(':categorie' => $_GET['categorie']));
    #debug($resultat);
    
    } elseif(isset($_GET['ville']) && $_GET['ville'] != 'all'){
    
    $resultat= executeRequete("SELECT produit.* , salle.* FROM produit INNER JOIN salle ON produit.id_salle=salle.id_salle WHERE ville = :ville", array(':ville' => $_GET['ville']));
    
    }  elseif(isset($_POST['capacite']) && $_POST['capacite'] !== 'all'){
    
    $resultat= executeRequete("SELECT produit.* , salle.* FROM produit INNER JOIN salle ON produit.id_salle=salle.id_salle WHERE capacite = :capacite", array(':capacite' => $_POST['capacite']));
    }
    else{ # on selectionne tous les produits
    
    $resultat = executeRequete("SELECT * FROM produit INNER JOIN salle ON produit.id_salle = salle.id_salle WHERE etat = 'libre' AND date_arrive > now()");
    }
    

     while($produit= $resultat->fetch(PDO::FETCH_ASSOC)){
#debug($produit);
     $contenu_produits .= '<div class="col-sm-4 mb-4">';  // 3 produits par lignes
     $contenu_produits .= '<div style="height: 20rem" class="card">';

         // image cliquable :
         $contenu_produits .= '<a href="fiche_produit.php?id_produit='. $produit['id_produit'] .'">
                                 <img class="card-img-top" src="'. $produit['photo'] .'" alt="'. $produit['titre'] .'">
                               </a>';  // on envoie à fiche_produit.php l'id_produit en GET par l'URL. 

         // infos du produit :
         $contenu_produits .= '<div class="card-body">';
             $contenu_produits .= '<h4>'. ucfirst($produit['titre']) .'</h4>';
             $contenu_produits .= '<h5>'. number_format($produit['prix'], 2, ",", " ") .' €TTC</h5>'; // number_format() reformate un nombre : on lui indique la valeur, le nombre de décimales, le séparateur des décimales (une virgule), le séparateur des milliers (un espace).
 
             $contenu_produits .= '<p>'. $produit['description'] .'</p>';
       
         $contenu_produits .= '</div>';  // .card-body  
     $contenu_produits .= '</div>';  // .card
 $contenu_produits .= '</div>'; // .col-sm-4
}

  


require_once 'inc/header.php';

?>
<h5 class="mt-4">Catégorie</h5>

<div class="row">

    <div class="col-md-3">
        <?php echo  $contenu_categories; ?>

        <div><h5 class="mt-4">ville</h5></div>
        <?php echo  $contenu_villes; ?>

        <div><h5 class="mt-4">Capacité</h5></div>
        <?php echo  $contenu_capacites; ?>

        <div><h5 class="mt-4">Date</h5></div>
              <?php echo $contenu_date_arrive ?>
              <?php echo $contenu_date_depart ?>

        <div><h5 class="mt-4">Prix</h5></div>
        <?php echo  $contenu_prix; ?>
    
    </div>


    <div class="col-md-9">
        <div class="row">
            <?php echo $contenu_produits; ?>
        </div>    
    </div>

</div><!-- .row -->
 

<?php

require_once 'inc/footer.php';
?>