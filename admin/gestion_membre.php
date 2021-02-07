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



#verification admin

if (!estAdmin()) {
    header('location:../connexion.php');
    exit;
}
debug($_SESSION);

# suppression du membre

if (isset($_GET['action']) && $_GET['action'] == "supprimer_membre" && isset($_GET['id_membre'])) {


    if ($_GET['id_membre'] != $_SESSION['membre']['id_membre']) { // si l'ID de l'URL (membre que l'on veut supprimer) est différent de l'ID  (membre qui est connecté), on peut supprimer  
        $resultat = executeRequete("DELETE FROM membre WHERE id_membre=:id_membre", array(':id_membre' => $_GET['id_membre']));

        if ($resultat->rowCount() == 1) {
            $contenu .= '<div class="alert alert-success">Le membre a bien été supprimé.</div>';
        } else {
            // sinon si le DELETE retourne 0 ligne, c'est que l'id_membre n'est pas en BDD:
            $contenu .= '<div class="alert alert-danger">Le membre n\'a pas pu être supprimé.</div>';
        }
    } else {
        $contenu .= '<div class="alert alert-danger">Vous ne pouvez pas supprimer votre propre profil ! </div>';
    }
}

# Modification membre
if (isset($_GET['action']) && $_GET['action'] == "modifier_statut" && isset($_GET['id_membre']) && isset($_GET['statut']))

    // on ne peut pas modifier son propre profil :
    if ($_GET['id_membre'] != $_SESSION['membre']['id_membre']) {

        $statut = ($_GET['statut'] == 0) ? 1 : 0;    // si statut = 0 alors il devient 1 sinon devient 0

        if (isset($_GET['id_membre'])) {

            $resultat = executeRequete("SELECT * FROM membre WHERE  id_membre = :id_membre", array(':id_membre' => $_GET['id_membre']));

            $membre_actuel = $resultat->fetch(PDO::FETCH_ASSOC);

            if ($resultat->rowCount() == 1) {
                $contenu .= '<div class="alert alert-success">Le membre a bien été modifié.</div>';
            } else {
                $contenu .= '<div class="alert alert-danger">Le membre n\'a pas pu être modifié.</div>';
            }
                } else {
                      $contenu .= '<div class="alert alert-danger">Vous ne pouvez pas modifier votre propre profil ! </div>';
              }
          }
    

# Insertion membre
if (!empty($_POST)) {

    debug($_POST);

    if ($_GET['id_membre'] != $_SESSION['membre']['id_membre']) {

        $resultat = executeRequete("REPLACE INTO membre(id_membre, mdp, email, pseudo, nom, prenom, civilite, statut, date_enregistrement) VALUES (:id_membre, :mdp, :email, :pseudo, :nom, :prenom, :civilite, :statut, NOW())", array(
            ':id_membre' => $_POST['id_membre'],
            ':mdp' => $_POST['mdp'],
            ':email' => $_POST['email'],
            ':pseudo' => $_POST['pseudo'],
            ':nom' => $_POST['nom'],
            ':prenom' => $_POST['prenom'],
            ':civilite' => $_POST['civilite'],
            ':statut' => $_POST['statut'],


        ));


        if ($resultat->rowCount() == 1) {
            $contenu .= '<div class="alert alert-success">Le membre a été ajouté.</div>';
        }
    } else {
        $contenu .= '<div class="alert alert-danger">Vous ne pouvez pas modifier votre propre profil ! </div>';
    }
} // fin de if (!empty($_POST))


#preparation de l'affichage

$resultat = executeRequete("SELECT id_membre, pseudo, nom, prenom, email, civilite, statut, date_enregistrement FROM membre ");

$contenu .= '<table class="table table-striped">';
$contenu .= '<tr>
             
           <th>id_membre</th>
           <th>Pseudo</th>
           <th>Nom</th>
           <th>Prenom</th>
           <th>email</th>
           <th>Civilité</th>
           <th>Statut</th>
           <th> date d\'enregistrement </th>
           <th>Action</th>
 
            </tr>';

# Affichage des lignes

while ($membre = $resultat->fetch(PDO::FETCH_ASSOC)) {

    $contenu .= '<tr>';
    foreach ($membre as $indice => $information) {
        $contenu .= '<td>' . $information . '</td>';
    }

    $contenu .=  '<td>
                      <div><a href="?action=supprimer_membre&id_membre=' . $membre['id_membre'] . '" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer ce membre?\'));">Supprimer</i></a></div>

					 <div><a href="?action=modifier_statut&id_membre=' . $membre['id_membre'] . '&statut=' . $membre['statut'] . '">Modifier</a></div>
			   </td>';
    $contenu .= '</tr>';
}

$contenu .= '</table>';




require_once '../inc/header.php';

?>
<h1 style="margin-top:5rem; margin-bottom:3rem">Gestion des membres</h1>
<?php
echo $contenu;
echo '<h1 class="mt-4">Ajouter/ Modifier membres</h1>';

?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="row">

        <div class="col-md-12">
            <input type="hidden" name="id_membre" value="<?php echo $membre_actuel['id_membre'] ?? 0;  ?>">
        </div>


        <div class="col-md-6 mx-auto">
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" class="form-control" id="pseudo" value="<?php echo $membre_actuel['pseudo'] ?? ''; ?>">
        </div>
        <div class="col-md-6 mx-auto">
            <label for="email">Email</label>
            <input type="text" name="email" class="form-control" id="email" value="<?php echo  $membre_actuel['email'] ?? ''; ?>">
        </div>
        <div class="">
            <input type="hidden" name="mdp" value="<?php echo $membre_actuel['mdp'] ?? 0; ?>">
        </div>
        <div class="col-md-6 mx-auto">
            <label for="nom">Nom</label>
            <input type="text" name="nom" class="form-control" id="nom" value="<?php echo  $membre_actuel['nom'] ?? ''; ?>">
        </div>
        <div class="col-md-6 mx-auto">
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" class="form-control" id="prenom" value="<?php echo  $membre_actuel['prenom'] ?? ''; ?>">
        </div>

        <div class="col-md-6 mx-auto">
            <label for="civilite">Civilité</label>

            <div><input type="radio" name="civilite" value="m" checked> Masculin</div>
            <div><input type="radio" name="civilite" value="f" <?php if (isset($membre_actuel['civilite']) &&  $membre_actuel['civilite'] == 'f') echo 'checked'; ?>> Féminin</div>

        </div>
        <div class="col-md-6 mx-auto">
            <label for="statut">Statut</label>
            <select id="statut" name="statut" class="form-control">
                <option selected></option>
                <option value="1" <?php if (isset($membre_actuel['statut']) &&  $membre_actuel['statut'] == '1') echo 'selected';  ?>>Admin </option>
                <option value="0" <?php if (isset($membre_actuel['statut']) &&  $membre_actuel['statut'] == '0') echo 'selected'; ?>>Membre</option>
            </select>
        </div>
        <div>

            <input type="submit" value="Enregistrer" class="btn btn-info mt-4">
        </div>
    </div>
</form>





<?php
require_once '../inc/footer.php';
?>