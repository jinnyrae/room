<?php
    require_once 'inc/init.php';

# 1- membre connecté
if (!estConnecte()) {
    header('location:connexion.php');
    exit;
}


require_once 'inc/header.php';

# 2- profil à afficher
?>

<h1>Vos coordonnées</h1>
<ul>
    <li>Nom: <?php echo $_SESSION['membre']['nom'];  ?></li>
    <li>Prenom: <?php echo $_SESSION['membre']['prenom'];  ?></li>
    <li>Email: <?php echo $_SESSION['membre']['email'];  ?></li>

</ul>


<?php
    require_once 'inc/footer.php';
?>