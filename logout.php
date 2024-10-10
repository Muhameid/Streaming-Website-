<?php
session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté
if (isset($_SESSION['email'])) {
    
    // Détruire toutes les variables de session
    session_unset();

    // Détruire la session
    session_destroy();

    // Supprimer les cookies de connexion si existants
    if (isset($_COOKIE['email']) && isset($_COOKIE['mdp'])) {
        setcookie('email', '', time() - 3600, "/"); // Supprimer le cookie email
        setcookie('mdp', '', time() - 3600, "/");   // Supprimer le cookie mdp
    }

    // Rediriger vers la page de connexion après déconnexion
    header("Location: login.php");
    exit();
} else {
    // Si l'utilisateur n'était pas connecté, on le redirige directement vers la page de connexion
    header("Location: login.php");
    exit();
}
?>
