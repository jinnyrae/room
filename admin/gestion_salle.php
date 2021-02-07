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

# 1-verification admin

if (!estAdmin()) {
    header('location:../connexion.php');
    exit;
}

# 5- insertion de salles

if (!empty($_POST)) {
    # 6- photo
    $photo_bdd = '';

    if (isset($_POST['photo_actuelle'])) {  # modifier photo
        $photo_bdd = $_POST['photo_actuelle'];
    }

    if (!empty($_FILES['photo']['name'])) {
        $nom_fichier = uniqid() . '_' . $_FILES['photo']['name'];
        $photo_bdd = 'photos/' . $nom_fichier;
        copy($_FILES['photo']['tmp_name'], '../' . $photo_bdd);
    }




    executeRequete("REPLACE INTO salle VALUES (:id_salle, :titre, :description, :photo, :pays, :ville, :adresse, :cp, :capacite, :categorie)", array(
        ':id_salle' => $_POST['id_salle'],
        ':titre' => $_POST['titre'],
        ':description' => $_POST['description'],
        ':photo' => $photo_bdd,
        ':pays' => $_POST['pays'],
        ':ville' => $_POST['ville'],
        ':adresse' => $_POST['adresse'],
        ':cp' => $_POST['cp'],
        ':capacite' => $_POST['capacite'],
        ':categorie' => $_POST['categorie']
    ));

    if ($resultat->rowCount() == 1) {
        $contenu .= '<div class="alert alert-success">Le produit a été enregistré.</div>';
    }
} # fin if(!empty($_POST)


# 8- supprimer une salle

if (isset($_GET['id_salle']) && isset($_GET['action']) && $_GET['action'] == 'supprimer_salle') {

    $resultat = executeRequete("DELETE FROM salle WHERE :id_salle = id_salle", array(
        ':id_salle' => $_GET['id_salle'],
    ));
    if ($resultat->rowCount() == 1) {
        $contenu .= '<div class="alert alert-success">La salle a été supprimée.</div>';
    } else {
        $contenu .= '<div class="alert alert-danger">La salle n\'existe pas!.</div>';
    }
}

# 7- Affichage des salle


if (isset($_GET['id_salle']) && isset($_GET['action']) && $_GET['action'] == 'modifier_salle') {

    $resultat = executeRequete("SELECT * FROM salle WHERE  :id_salle = id_salle", array(
        ':id_salle' => $_GET['id_salle'],
    ));

    $salle_actuel = $resultat->fetch(PDO::FETCH_ASSOC);
}


# 4- Affichage des salles

$resultat = executeRequete("SELECT * FROM salle");
$contenu .= '<table class="table table-striped">';
$contenu .= '<tr>

         <th>Id_salle</th>
         <th>Titre</th>
         <th>Description</th>
         <th>Photo</th>
         <th>Pays</th>
         <th>Ville</th>
         <th>Adresse</th>
         <th>Cp</th>
         <th>Capacité</th>
         <th>Catégorie</th>
         <th>Action</th>

         </tr>';


while ($salle = $resultat->fetch(PDO::FETCH_ASSOC)) {

    $contenu .= '<tr>';
    foreach ($salle as $indice => $information) {
        if ($indice == 'photo' && !empty($information)) {
            $contenu .= '<td><img src="../' . $information . '" class="w-50 img-fluid"></td>';
        } elseif ($indice == 'description') {
            $contenu .= '<td>' . substr($information, 0, 5) . '... </td>';
        } else {
            $contenu .= '<td>' . $information . '</td>';
        }
    }

    $contenu .=  '<td>';
    $contenu .= '<div><a href="?action=supprimer_salle&id_salle=' . $salle['id_salle'] . '" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette salle?\'));">Supprimer</a></div>';

    $contenu .=  '<div><a href="?action=modifier_salle&id_salle=' . $salle['id_salle'] . '">Modifier</a></div>';
    $contenu .= '</td>';
    $contenu .= '</tr>';
}

$contenu .= '</table>';





require_once '../inc/header.php';
# 2- affichage navigateur
?>
<h1 style="margin-top:5rem; margin-bottom:3rem">Gestion de salle</h1>
<?php
echo $contenu;

?>
<!-- 3- formulaire produit -->
<h2> Ajouter / modifier une salle </h2>

<form action="" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" name="id_salle" value="<?php echo $salle_actuel['id_salle'] ?? 0; ?>">
        </div>

        <div class="col-md-6 mx-auto">
            <div><label for="titre">Titre</label></div>
            <div><input type="text" name="titre" id="titre" value="<?php echo $salle_actuel['titre'] ?? ''; ?>"></div>
        </div>

        <div class="col-md-6 mx-auto">
            <div><label for="description">Description</label></div>
            <div><textarea name="description" id="description"><?php echo $salle_actuel['description'] ?? ''; ?></textarea></div>
        </div>

        <div class="col-md-6 mx-auto">
            <div><label for="photo">Photo</label></div>
            <!-- Photo -->
            <input type="file" name="photo" id="photo"><!-- input type "file"-->

            <!-- Modification de la photo -->
            <?php
            if (isset($salle_actuel['photo'])) { //pour modifier le produit
                echo '<div><img src="../' . $salle_actuel['photo'] . '" style="width: 90px;"></div>';  //  photo actuelle qui est en BDD
                echo '<input type="hidden" name="photo_actuelle" value="' . $salle_actuel['photo'] . '">'; //  photo qui provient de $salle_actuel de la BDD. 
            }
            ?>
        </div>

        <div class="col-md-6 mx-auto">
            <div><label>Capacité</label></div>
            <select name="capacite">
                <option value="10" <?php if (isset($salle_actuel['capacite']) && $salle_actuel['capacite'] == 10) echo 'selected' ?? ''; ?>>10</option>
                <option value="5" <?php if (isset($salle_actuel['capacite']) && $salle_actuel['capacite'] == 5) echo 'selected' ?? ''; ?>>5</option>
                <option value="30" <?php if (isset($salle_actuel['capacite']) && $salle_actuel['capacite'] == 30) echo 'selected' ?? ''; ?>>30</option>

            </select>
        </div>

        <div class="col-md-6 mx-auto">
            <div><label>Catégorie</label></div>
            <select name="categorie">
                <option value="Bureau" <?php if (isset($salle_actuel['categorie']) && $salle_actuel['categorie'] == 'bureau') echo 'selected' ?? ''; ?>>Bureau</option>
                <option value="Reunion" <?php if (isset($salle_actuel['categorie']) && $salle_actuel['categorie'] == 'reunion') echo 'selected' ?? ''; ?>>Reunion</option>
                <option value="Formation" <?php if (isset($salle_actuel['categorie']) && $salle_actuel['categorie'] == 'formation') echo 'selected' ?? ''; ?>>Formation</option>
            </select>
        </div>

        <div class="col-md-6 mx-auto">
            <div><label>Pays</label></div>
            <select name="pays">
                <option value="France" <?php if (isset($salle_actuel['pays']) && $salle_actuel['pays'] == 'france') echo 'selected' ?? ''; ?>>France</option>
                <option value="Italie" <?php if (isset($salle_actuel['pays']) && $salle_actuel['pays'] == 'itlie') echo 'selected' ?? ''; ?>>Italie</option>
            </select>
        </div>

        <div class="col-md-6 mx-auto">
            <div><label>Ville</label></div>
            <select name="ville">
                <option value="Paris" <?php if (isset($salle_actuel['ville']) && $salle_actuel['ville'] == 'Paris') echo 'selected' ?? ''; ?>>Paris</option>
                <option value="Lyon" <?php if (isset($salle_actuel['ville']) && $salle_actuel['ville'] == 'Lyon') echo 'selected' ?? ''; ?>>Lyon</option>
                <option value="Marseille" <?php if (isset($salle_actuel['ville']) && $salle_actuel['ville'] == 'Marseille') echo 'selected' ?? ''; ?>>Marseille</option>
            </select>
        </div>

        <div class="col-md-6 mx-auto">
            <div><label for="adresse">Adresse</label></div>
            <div><input type="text" name="adresse" id="adresse" value="<?php echo $salle_actuel['adresse'] ?? ''; ?>"></div>
        </div>


        <div class="col-md-6 mx-auto">
            <div><label for="cp">Cp</label></div>
            <div><input type="text" name="cp" id="cp" value="<?php echo $salle_actuel['cp'] ?? ''; ?>"></div>
        </div>

        <div class="col-md-6 mx-auto">
            <input type="submit" value="Enregistrer" class="btn btn-info mt-4">
        </div>
    </div>
</form>



<?php



require_once '../inc/footer.php';
?>