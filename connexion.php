<?php

require_once 'inc/init.php';


# 2- Deconnexion du membre
$message = ''; #message de deconnexion
if (isset($_GET['action']) && $_GET['action'] == 'deconnexion') {
    unset($_SESSION['membre']);
    $message = '<div class="alert alert-info">Vous êtes déconnecté.</div>';
}
# verification que membre est connecté
if (estConnecte()) {
    header('location:profil.php');
    exit;
}



# 1- Traitement de formulaire de connexion
if (!empty($_POST)) {

    #validation des chapms de formulaire
    if (empty($_POST['pseudo']) || empty($_POST['mdp'])) {
        $contenu .= '<div class="alert alert-danger">Les identifiants sont obligatoires.</div>';
    }
    if (empty($contenu)) {
        $resultat = executeRequete("SELECT * FROM membre WHERE  pseudo = :pseudo", array(':pseudo' => $_POST['pseudo']));
        if ($resultat->rowCount() == 1) {  #verification mdp
            $membre = $resultat->fetch(PDO::FETCH_ASSOC);
            if (password_verify($_POST['mdp'], $membre['mdp'])) { # connexion du membre

                $_SESSION['membre'] = $membre;
                header('location:profil.php'); #direction page profil
                exit;
            } else {

                $contenu .= '<div class="alert alert-danger">Erreur sur les identifiants</div>';
            }
        } else {
            $contenu .= '<div class="alert alert-danger">Erreur sur les identifiants</div>';
        }
    }
} # fin if(!empty($_POST)






# ---- Afichage-----
require_once 'inc/header.php';
?>

<h1>Connexion</h1>
<?php
echo $message;
echo $contenu;
?>
<form action="" method="post">

    <div>
        <div><label for="pseudo">Pseudo</label></div>
        <div><input type="text" name="pseudo" id="pseudo"></div>
    </div>
    <div>
        <div><label for="mdp">Mot de passe</label></div>
        <div><input type="password" name="mdp" id="mdp"></div>
    </div>

    <div>
        <input type="submit" value="Se connecter" class="btn btn-info mt-4">
    </div>

</form>








<?php
require_once 'inc/footer.php';
