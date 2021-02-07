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

#4- supression produit

if (isset($_GET['id_produit']) && isset($_GET['action']) && ($_GET['action']) == "supprimer_produit") {

    $resultat = executeRequete("DELETE FROM produit WHERE id_produit = :id_produit", array(':id_produit' => $_GET['id_produit']));

    if ($resultat->rowCount() == 1) {
        $contenu .= '<div class="alert alert-success">Le produit a été suprimé</div>';
    }
}


# 6_ Modification produit

if (isset($_GET['id_produit'])) {
    $resultat = executeRequete("SELECT * FROM produit WHERE id_produit = :id_produit", array(':id_produit' => $_GET['id_produit']));
    $produit_actuel = $resultat->fetch(PDO::FETCH_ASSOC);
}




# 5- Insertion produit
#debug($_POST);

if (!empty($_POST)) {
    $resultat = executeRequete("REPLACE INTO produit VALUES (:id_produit,:id_salle, :date_arrive, :date_depart, :prix, :etat) ", array(
        ':id_produit' => $_POST['id_produit'],
        ':id_salle' => $_POST['id_salle'],
        ':date_arrive' => $_POST['date_arrive'],
        ':date_depart' => $_POST['date_depart'],
        ':prix' => $_POST['prix'],
        ':etat' => 'libre'
    ));
    if ($resultat->rowCount() == 1) {
        $contenu .= '<div class="alert alert-success">Le produit a été ajouté</div>';
    }
}




# 3- preparer l'affichage

$resultat = executeRequete("SELECT produit.id_produit, date_arrive, date_depart, photo, prix, etat FROM produit left join salle ON salle.id_salle = produit.id_salle");
#debug($resultat);

$contenu .= '<table class="table mt-5 table-striped">';

$contenu .= '<tr>
                        <th>Id_produit</th>
                        <th>Date d\'arrivé</th>
                        <th>Date départ</th>
                        <th>Id_salle</th>
                        <th>Prix</th>
                        <th>Etat</th>
                        <th>Action</th>
                    </tr>';

while ($produit = $resultat->fetch(PDO::FETCH_ASSOC)) {
    $contenu .= '<tr>';
    #debug($produit);
    foreach ($produit as $indice => $information) {

        if ($indice == 'photo' && !empty($information)) {
            $contenu .= '<td style="width: 80px"><img src="../' . $information . '" class="w-100" ></td>';
        } elseif ($indice == 'prix') {
            $contenu .= '<td> ' . $information . ' € </td>';
        } else {
            $contenu .= '<td>' . $information . '</td>';
        }
    }

    $contenu .=  '<td>';
    $contenu .= '<div><a href="?action=supprimer_produit&id_produit=' . $produit['id_produit'] . '" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette salle?\'));">Supprimer</a></div>';

    $contenu .=  '<div><a href="?action=modifier_produit&id_produit=' . $produit['id_produit'] . '">Modifier</a></div>';
    $contenu .= '</td>';
    $contenu .= '</tr>';
}

$contenu .= '</table>';



require_once '../inc/header.php';

?>
<h1 style="margin-top:5rem; margin-bottom:3rem">Gestion de produits</h1>
<?php

echo $contenu;

?>
<!--2- Formulaire produit-->

<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_produit" value="<?php echo $produit_actuel['id_produit'] ?? 0; ?>">


    <div class="mt-4">
        <label for="date_arrive">Date d'arrivée:</label>
        <input type="date" id="date_arrive" name="date_arrive" value="<?php echo $produit_actuel['date_arrive'] ?? ''; ?>">
    </div>

    <div class="mt-4">
        <label for="date_depart">Date de départ:</label>
        <input type="date" id="date_depart" name="date_depart" value="<?php echo $produit_actuel['date_depart'] ?? ''; ?>">
    </div>



    <div class="col-md-4">
        <div><label>Salle</label></div>

        <select name="id_salle">
            <!--boucle while avec fetch , balise option-->
            <?php
            $resultat = executeRequete("SELECT * FROM salle");
            while ($salle_choisie = $resultat->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value= "' . $salle_choisie['id_salle'] . '">';
                if (isset($produit_actuel['id_salle']) && $produit_actuel['id_salle'] == $salle_choisie['id_salle']) {
                    echo 'selected';
                }
                echo $salle_choisie['id_salle'] . '-' . $salle_choisie['titre'] . '-' . $salle_choisie['adresse'] . ',' . $salle_choisie['cp'] . ',' . $salle_choisie['ville'] . '-' . $salle_choisie['capacite'] . 'personnes' . '</option>';
            } ?>
        </select>

    </div>
    </div>


    <div class="mt-4 col-md-4">
        <div><label for="prix">Prix</label></div>
        <div><input type="text" name="prix" id="prix" value="<?php echo $produit_actuel['prix'] ?? ''; ?>"></div>
    </div>
    </div>
    <div class="mt-4 col-md-4">
        <input type="submit" value="Enregistrer" class="btn btn-info mt-4">
    </div>


</form>

<?php
require_once '../inc/footer.php';
?>