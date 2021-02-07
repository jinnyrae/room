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


# 5- supprimer avis:

if (isset($_GET['id_avis'])) {

    $resultat = executeRequete("DELETE FROM avis WHERE id_avis=:id_avis", array(':id_avis' => $_GET['id_avis']));

    if ($resultat->rowCount() == 1) {
        $contenu .= '<div class="alert alert-success">Le avis a bien été supprimée.</div>';
    } else {

        $contenu .= '<div class="alert alert-danger">Le avis n\'a pas pu être supprimé.</div>';
    }
}




# Affichage des avis :
$resultat = executeRequete("SELECT avis.id_avis, avis.id_membre, avis.id_salle, commentaire, note, avis.date_enregistrement FROM avis LEFT JOIN membre ON avis.id_membre = membre.id_membre LEFT JOIN salle ON avis.id_salle= salle.id_salle");
debug($resultat); // objet PDOStatement

$contenu .= '<table class="table table-striped">';

// Les entêtes :
$contenu .= '<tr classe="mt-5">
                    <th>ID avis</th>
                    <th>ID membre</th>
                    <th>ID salle</th>
                    <th>commentaire</th>
                    <th>Note</th>
                    <th>Date enregistrement</th>
                    <th>Action</th>    
                 </tr>';

while ($avis = $resultat->fetch(PDO::FETCH_ASSOC)) {
    #debug($avis);
    $contenu .= '<tr>';

    foreach ($avis as $indice => $information) {
        if ($indice == 'note') {
            $contenu .= '<td> ' . $information  . '/5 </td>';
        } else {
            $contenu .= '<td>' . $information . '</td>';
        }
    }
    $contenu .= '<td>
        <div><a href="../avis.php?id_avis=' . $avis['id_avis'] . '">modifier </a></div>
        <div><a href="?id_avis=' . $avis['id_avis'] . '"  onclick="return confirm(\'Etes-vous certain de vouloir supprimer cet avis ?\');"> supprimer</a></div>
     </td>';
    $contenu .= '</tr>';
}

$contenu .= '</table>';





require_once '../inc/header.php';

?>
<h1 style="margin-top:5rem; margin-bottom:3rem">Gestion des avis</h1>
<?php

echo $contenu;
require_once '../inc/footer.php';


?>