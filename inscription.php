<?php

require_once 'inc/init.php';

if (!empty($_POST)) { # si formulaire envoyé, validation du formulaire
    if (!isset($_POST['pseudo']) || strlen($_POST['pseudo']) < 4 || strlen($_POST['pseudo']) > 20) {
        $contenu .= '<div class="alert alert-danger">Le pseudo doit contenir entre 4 et 20 caractères</div>';
    }
    if (!isset($_POST['mdp']) || strlen($_POST['mdp']) < 6 || strlen($_POST['mdp']) > 255) {
        $contenu .= '<div class="alert alert-danger">Le mot de passe doit contenir entre 6 et 255 caractères</div>';
    }
    if (!isset($_POST['nom']) || strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 20) {
        $contenu .= '<div class="alert alert-danger">Le nom doit contenir entre 2 et 20 caractères</div>';
    }
    if (!isset($_POST['prenom']) || strlen($_POST['prenom']) < 2 || strlen($_POST['prenom']) > 20) {
        $contenu .= '<div class="alert alert-danger">Lepseudo doit contenir entre 2 et 20 caractères</div>';
    }
    if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $contenu .= '<div class="alert alert-danger">Le email doit n\'est valide.</div>';
    }
    $civilite = array("m", "f");
    if (!isset($_POST['civilite']) || !in_array($_POST['civilite'], $civilite)) {
        $contenu .= '<div class=" alert alert-danger">La civilité n\'est pas valide.></div>';
    }

    if (empty($contenu)) { # pas de message d'erreur

        $resultat = executeRequete("SELECT * FROM membre WHERE pseudo= :pseudo", array(':pseudo' => $_POST['pseudo'])); # verification de pseudo dans BDD
        if ($resultat->rowCount() > 0) { # le pseudo existe deja si > 0
            $contenu .= '<div class="alert alert-danger">Le pseudo est indisponible. Veuillez en choisir un autre.</div>';
        } else { # le pseudo est libre on inscrit le me
            $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT); # hasher mdp
            executeRequete("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, statut, date_enregistrement ) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :civilite, :statut, NOW() )", array(

                ':pseudo' => $_POST['pseudo'],
                ':mdp' => $mdp,
                ':nom' => $_POST['nom'],
                ':prenom' => $_POST['prenom'],
                ':email' => $_POST['email'],
                ':civilite' => $_POST['civilite'],
                ':statut' => 0
            ));


            $contenu .= '<div class="alert alert-success">Vous êtes inscrit. Pour vous connecter <a href="connexion.php"> cliquez ici. </a></div>';
        }
    } // fin if(empty($contenu))

} //fin if (!empty($_POST))




require_once 'inc/header.php';

?>
<h1 class="mt-4">Inscription</h1>
<?php echo $contenu; ?>

<form action="" method="post">
    <div>
        <div><label for="pseudo">Pseudo</label></div>
        <div><input type="text" name="pseudo" id="pseudo" value="<?php echo $_POST['pseudo'] ?? ''; ?>"></div>
    </div>
    <div>
        <div><label for="mdp">Mot de passe</label></div>
        <div><input type="password" name="mdp" id="mdp" value="<?php echo $_POST['mdp'] ?? ''; ?>"></div>
    </div>
    <div>
        <div><label for="nom">Nom</label></div>
        <div><input type="text" name="nom" id="nom" value="<?php echo $_POST['nom'] ?? ''; ?>"></div>
    </div>
    <div>
        <div><label for="prenom">Prenom</label></div>
        <div><input type="text" name="prenom" id="prenom" value="<?php echo $_POST['prenom'] ?? ''; ?>"></div>
    </div>
    <div>
        <div><label for="email">Email</label></div>
        <div><input type="text" name="email" id="email" value="<?php echo $_POST['email'] ?? ''; ?>"></div>
    </div>

    <div>
        <div><label for="civilite">Civilité</label></div>
        <div><input type="radio" name="civilite" id="civilite" value="m" checked>Masculin</div>
        <div><input type="radio" name="civilite" id="civilite" value="f" <?php if (isset($_POST['civilite']) == 'f') echo 'checked'; ?>>Feminin</div>
    </div>


    <div>
        <input type="submit" value="S'inscrire" class="btn btn-info mt-4">
    </div>


</form>


<?php
require_once 'inc/footer.php';
?>