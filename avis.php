<?php

require_once 'inc/init.php';

# 1- membre connecté
if (!estConnecte()) {
    header('location:connexion.php');
    exit;
}

$id_membre = $_SESSION['membre']['id_membre'];

if (isset($_GET['id_avis'])) { # afficher avis actuel
    $resultat = executeRequete("SELECT * FROM avis WHERE id_avis = :id_avis", array(':id_avis' => $_GET['id_avis']));
    $avis_actuel = $resultat->fetch(PDO::FETCH_ASSOC);
}

#2- Ajouter / modifier un avis
if (isset($_GET['id_salle']) || isset($_GET['id_avis'])) {
    if (!empty($_POST)) {
        if (!isset($_POST['note']) || !preg_match('#^[0-5]{1}$#', $_POST['note'])) {
            $contenu .= '<div class="alert alert-danger">La note n\'est pas valide.</div>';
        } elseif (empty($_POST['note'] || ['commentaire'])) {
            $contenu .= '<div class="alert alert-danger">veuillez remplire tous les champs.</div>';
        } elseif (!isset($_POST['commentaire']) || strlen($_POST['commentaire']) < 2 || strlen($_POST['commentaire']) > 225) {
            $contenu .= '<div class="alert alert-danger">Le pseudo doit contenir entre 4 et 225 caractères</div>';
        } else {  #3- Insertion d'avis
            executeRequete("REPLACE INTO avis VALUES (:id_avis, :id_membre, :id_salle, :commentaire, :note, :date_enregistrement)", array(
                ':id_avis' => $_POST['id_avis'],
                ':id_membre' => $_POST['id_membre'],
                ':id_salle' => $_POST['id_salle'],
                ':commentaire' => $_POST['commentaire'],
                ':note' => $_POST['note'],
                ':date_enregistrement' => $_POST['date_enregistrement']
            ));

            $contenu .= '<div class="alert alert-success">Merci pour votre message !</div>';
        } # fin if(!empty($_POST)){
    }
}

require_once 'inc/header.php';


?>
<h1 class="mt-4">Donnez votre avis</h1>
<?php echo $contenu; ?>

<form action="" method="POST" enctype="multipart/form-data">
    <div class="form-row">

        <div class="form-group">
            <input type="hidden" name="id_avis" value="<?php echo $avis_actuel['id_avis'] ?? 0; ?>">
        </div>
        <div class="form-group">
            <input type="hidden" name="id_membre" value="<?php echo $avis_actuel['id_membre'] ?? 0; ?>">
        </div>
        <div class="form-group">
            <input type="hidden" name="id_salle" value="<?php echo $avis_actuel['id_salle'] ?? 0 ?>">
        </div>

        <div class="form-group col-md-6 ">
            <label for="commentaire">Commentaire</label>
            <textarea name="commentaire" class="form-control" id="titre"><?php echo $avis_actuel['commentaire'] ?? ''; ?></textarea>
        </div>


        <div class="form-group col-md-6 ">
            <label for="note">Note</label>
            <input type="text" name="note" class="form-control" id="note" value="<?php echo $avis_actuel['note'] ?? ''; ?>">
        </div>

        <div class="form-group col-md-6">

            <input type="hidden" name="date_enregistrement" class="form-control" id="date_enregistrement" value="<?php echo date("Y-m-d H:i:s") ?? ''; ?>">
        </div>


        <div class="form-group col-md-12">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
    </div>
</form>


<?php

require_once 'inc/footer.php';


?>