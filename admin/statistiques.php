
<style>
    table,
    th,
    tr,
    td {
        border: 1px solid #800020;
    }
</style>



<?php

require_once '../inc/init.php';


$resultat =executeRequete("SELECT avis.id_salle, titre, AVG(note) FROM avis INNER JOIN salle ON avis.id_salle = salle.id_salle ORDER BY note DESC LIMIT 5");
$contenu .= '<h2 style="margin-top: 3rem" >Les salles les mieux notées </h2>';
$contenu .=  '<table class="table mt-5">';
 while ($topNote = $resultat->fetch(PDO::FETCH_ASSOC)){
      // tableau associatif avec tous les champs sauf le mdp
     
     $contenu .=  '<tr>'; // 1 ligne de <table> qui correspond à 1 membre
         
         foreach ($topNote as $information){
         
             $contenu .=  '<td>' . $information . '</td>';
         }
         $contenu .=  '</tr>';
        }
         $contenu .=  '</table>';


       
$resultat =executeRequete("SELECT produit.id_salle, titre, commande.id_produit FROM commande INNER JOIN produit ON commande.id_produit = produit.id_produit INNER JOIN salle ON produit.id_salle= salle.id_salle GROUP BY commande.id_produit ");

$contenu .= '<h2 style="margin-top: 3rem" >Les salles les plus commandées </h2>';
$contenu .=  '<table class="table mt-5">';
 while ($topNote = $resultat->fetch(PDO::FETCH_ASSOC)){
      // tableau associatif avec tous les champs sauf le mdp
     
     $contenu .=  '<tr>'; // 1 ligne de <table> qui correspond à 1 membre
         
         foreach ($topNote as $information){
         
             $contenu .=  '<td>' . $information . '</td>';
         }
         $contenu .=  '</tr>';
        }
         $contenu .=  '</table>';
       






        require_once '../inc/header.php';

echo $contenu;











require_once '../inc/footer.php';


?>

  
 