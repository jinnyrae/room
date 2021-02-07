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

# 1- verification de status
if (!estAdmin()) {
    header('location:connexion.php');
    exit;
}

# suppression commande:
if (isset($_GET['id_commande']) && isset($_GET['action']) && $_GET['action'] == 'supprimer') {
    $resultat = executeRequete("DELETE FROM commande WHERE id_commande = :id_commande", array(':id_commande' => $_GET['id_commande']));

    if ($resultat->rowCount() == 1) {  // si le DELETE retourne 1 ligne c'est que le produit a bien été supprimé

        $contenu .= '<div class="alert alert-success">Le produit a été supprimé.</div>';
    }
}


# Affichage des commandes :
$resultat = executeRequete("SELECT commande.id_commande, commande.id_membre, commande.id_produit, prix, date_enregistrement FROM commande LEFT JOIN produit ON commande.id_produit = produit.id_produit");

$contenu .= '<table class="table table-striped">';

// Les entêtes :
$contenu .= '<tr classe="mt-5">
                    <th>ID commande</th>
                    <th>ID membre</th>
                    <th>ID produit</th>
                    <th>Prix</th>
                    <th>Date enregistrement</th>
                    <th>Action</th>    
                 </tr>';

while ($commande = $resultat->fetch(PDO::FETCH_ASSOC)) {
    $contenu .= '<tr>';

    foreach ($commande as $indice => $information) {
        if ($indice == 'prix') {
            $contenu .= '<td> ' . $information . ' € </td>';
        } else {
            $contenu .= '<td>' . $information . '</td>';
        }
    }

    $contenu .= '<td>
     <a href="?action=supprimer&id_commande=' . $commande['id_commande'] . '"onclick="return confirm(\'Etes-vous certain de vouloir supprimer cette commande ?\');"> Supprimer</a>
        </td>';
    $contenu .= '</tr>';
}

$contenu .= '</table>';




require_once '../inc/header.php';

?>
<h1 style="margin-top:5rem; margin-bottom:3rem">Gestion des commandes</h1>
<?php

echo $contenu;
require_once '../inc/footer.php';


?>