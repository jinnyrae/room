<?php


function debug($variable)
{
    echo '<div style="border: 1px solid orange; padding: 5px;">';
    echo '<pre>';
    echo '</pre>';
    echo '</div>';
}


function estConnecte()
{  // cette fonction indique si le membre est membre connecté
    if (isset($_SESSION['membre'])) {
        return true;
    } else {
        return false;
    }
}


function estAdmin()
{  // cette fonction indique si le membre est admin connecté
    if (estConnecte() && $_SESSION['membre']['statut'] == 1) {
        return true;
    } else {
        return false;
    }
}

// Fonction pour exécuter des requêtes préparées :
function executeRequete($requete, $marqueurs = array())
{


    foreach ($marqueurs as $indice => $valeur) {
        $marqueurs[$indice] = htmlspecialchars($valeur);
    }

    // Requêt préparée :
    global $pdo; // on va chercher la variable globale $pdo à l'extérieur de la fonction (dans init.php).
    $resultat = $pdo->prepare($requete);  // on prépare la requête contenue dans $requete
    $succes = $resultat->execute($marqueurs); // puis on exécute la requête en donnant à execute() le tableau $marqueurs qui associe les marqueurs à leur valeur. execute() retourne toujours un booléen: true si la requête a marché, false dans le cas contraire. 

    if ($succes) { // si la variable contient true
        return $resultat; // quand la requête a marché, je retourne son résultat contenu dans $resultat (objet PDOStatement)
    } else { // sinon false : la requête n'a pas marché
        die('Une erreur est survenue...');  // die() arrête le script et affiche le message.
    }
} // fin de la fonction
