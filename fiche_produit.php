  <style>
  h4{
      color: blue;
  }
  </style>

<?php

require_once 'inc/init.php';
$reserver = '';
# 1- Controle d'existance de produits

if (isset($_GET['id_produit'])) {
    $resultat = executeRequete("SELECT produit.id_salle, id_produit, date_arrive, date_depart, prix, salle.categorie, salle.photo, salle.adresse, salle.capacite, salle.ville, salle.titre, salle.description, AVG(avis.note) AS Note, commentaire FROM produit JOIN salle ON produit.id_salle = salle.id_salle JOIN avis ON produit.id_salle= avis.id_salle WHERE id_produit = :id_produit", array(':id_produit' => $_GET['id_produit']));

    if ($resultat->rowCount() == 0) {
        header('location:index.php');
        exit;
    }

    # Affichage des produits

    $produit = $resultat->fetch(PDO::FETCH_ASSOC);
    #debug($produit);
    extract($produit);


    # Bouton reserver:
                
    $reserver .= '<a class="btn" href="?action=reserver&id_produit=' . $produit['id_produit'] . '"><button class="btn btn-primary">Reserver</button></a>';
             
        
     debug($_SESSION['membre']);
     
#insertion commande:
 
if (isset($_GET['action']) && $_GET['action'] == 'reserver' && isset($_GET['id_produit'])) {
   $resultat=  executeRequete("INSERT INTO commande (`id_produit`, `id_membre`, `date_enregistrement`) VALUES (:id_produit, :id_membre, :date_enregistrement)", array(
        ':id_membre' => $_SESSION['membre']['id_membre'],
        ':id_produit' => $produit['id_produit'],
        ':date_enregistrement' => date('Y-m-d')

    ));
     
}
debug($_SESSION['membre']['id_membre']);
debug(date('Y-m-d'));
} 
else {
    header('location:index.php');
    exit;
}





# Suggestion de produit:        
$suggestion = ''; # pour mettre dans le html les produits suggérés

$resultat = executeRequete("SELECT produit.id_salle, id_produit, salle.titre, salle.photo FROM produit LEFT JOIN salle ON produit.id_salle = salle.id_salle WHERE id_produit != $id_produit ORDER BY RAND() LIMIT 4");
#debug($id_produit );

while ($autre_produit = $resultat->fetch(PDO::FETCH_ASSOC)) {

    #debug($autre_produit);

    $suggestion .= '<div class="col-sm-3">';

    $suggestion .= '<a href="?id_produit=' . $autre_produit['id_produit'] . '">';  // on envoie en GET par l'URL l'ID du produit à la même page : on commence donc par le "?", suivi de l'indice écrit en "dur", suivi du "=" et enfin de la variable qui contient la valeur de l'ID.
    $suggestion .= '<img src="' . $autre_produit['photo'] . '" alt="' . $autre_produit['titre'] . '" class="img-fluid">';
    $suggestion .= '</a>';

    $suggestion .= '</div>';
}



require_once 'inc/header.php';

# Affichage :
?>

<div class="container">
    <div class="row justify-content-around align-items-end">

        <div class="col-3">
            <div>
                <h1 class="mt-5"><?= $titre . ' ' . round($Note, 1) . '/5'; ?></h1>
            </div>
        </div>
        <div class="btn">
        <?php echo $reserver; ?>
        </div>
        <div class="form-group">
            <input type="hidden" name="id_membre" value="<?php echo $_SESSION['membre']['id_membre'] ?? 0; ?>">
        </div>
        <div class="form-group">
            <input type="hidden" name="date_enregistrement" value="<?php echo date('Y-m-d') ?? 0; ?>">
        </div>
    </div>
    <!--Fin class row-->
    <hr>
    <div class="row mb-5 justify-content-around align-items-center">
        <div style="margin-top: 5rem" class="col-md-4">
            <img src="<?php echo $photo; ?>" alt="<?php echo $titre; ?>" class="img-fluid w-100%">
        </div>

        <div>
        <div class="col-4">
            <h4>Description</h4>

            <p style="padding-bottom:0"><?php echo $description; ?></p>

        </div>
        <div class="col-4">
            <h4>Avis</h4>

            <p style="padding-bottom:0"><?php echo $commentaire; ?></p>

        </div>
       </div>
        <div class="col-4">
            <h4>Détails</h4>
            <ul>
                <li>Catégorie : <?php echo $categorie; ?></li>
                <li>Capacité : <?php echo $capacite; ?></li>
                <li>Ville : <?php echo $ville; ?></li>
                <li>Adresse : <?php echo $adresse; ?></li>
                <li>Note : <?php echo round($Note, 1); ?></li>
            </ul>
        </div>

        <div class="mt-4">
            <label for="date_arrive">Date d'arrivée:</label>
            <input type="date" id="date_arrive" name="date_arrive" value="<?php echo $date_arrive ?? ''; ?>">
        </div>

        <div class="mt-4">
            <label for="date_depart">Date de départ:</label>
            <input type="date" id="date_depart" name="date_depart" value="<?php echo $date_depart ?? ''; ?>">
        </div>

        <h4>Prix : <?php echo number_format($prix, 2, ",", " "); ?> €TTC</h4>

        <div>
            <a href="index.php?categorie=<?php echo $categorie; ?>">Retour vers la catégorie '<?php echo $categorie; ?>'</a>
        </div>

    </div><!-- .col-md-4 -->

</div><!-- .row -->

<hr class="mt-5">

<div class="row space-between">
    <div class="col-12">
        <h3>Suggestion de produits</h3>
    </div>

    <?php echo $suggestion; ?>
</div>

<div class="row justify-content-between">
    <div><a href="avis.php?id_salle=<?php echo $id_salle; ?>">Deposer un avis et une note</a></div>
    <div><a href="index.php">Retour vers le catalogue</a></div>
</div>


<?php
require_once 'inc/footer.php';
?>