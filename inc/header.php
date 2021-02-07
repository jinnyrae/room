<!doctype html>
<html lang="fr">

<head>
  <title>Room</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo RACINE_SITE . 'font/fontawesome-free-5.15.2-web/css/all.min.css'; ?>">

</head>

<body>

  <!--Navbar-->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">

      <a class="navbar-brand" href="<?php echo RACINE_SITE . 'index.php'; ?>">ROOM</a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">

        <ul class="navbar-nav">
          <?php

          if (estConnecte()) {
            echo '<li><a href="' . RACINE_SITE . 'profil.php" class="nav-link">Profil</A></li>';
            echo '<li><a href="' . RACINE_SITE . 'connexion.php?action=deconnexion" class="nav-link">Deconnexion</A></li>';
            echo '<li><a href="' . RACINE_SITE . 'avis.php" class="nav-link">Avis</a></li>';
          } else {
            echo '<li><a href="' . RACINE_SITE . 'inscription.php" class="nav-link">Inscription</a></li>';
            echo '<li><a href="' . RACINE_SITE . 'connexion.php" class="nav-link">Connexion</a></li>';
          }
          if (estAdmin()) {
            echo '<li><a href="' . RACINE_SITE . 'admin/gestion_salle.php" class="nav-link">Gestion Salle</a></li>';
            echo '<li><a href="' . RACINE_SITE . 'admin/gestion_membre.php" class="nav-link">Gestion Membre</a></li>';
            echo '<li><a href="' . RACINE_SITE . 'admin/gestion_produit.php" class="nav-link">Gestion Produit</a></li>';
            echo '<li><a href="' . RACINE_SITE . 'admin/gestion_commande.php" class="nav-link">Gestion Commande</a></li>';
            echo '<li><a href="' . RACINE_SITE . 'admin/gestion_avis.php" class="nav-link">Gestion Avis</a></li>';
            echo '<li><a href="' . RACINE_SITE . 'admin/statistiques.php" class="nav-link">Statistiques</a></li>';
          }
          ?>
        </ul>
      </div>
    </div>
    <!--fin container-->
  </nav>


  <main class="container" style="min-height: 80vh">