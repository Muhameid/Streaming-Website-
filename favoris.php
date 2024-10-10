<?php
session_start();

require "includes/header.php"; 


if (isset($_SESSION['id_m'])) {
    try {
        
        $bdd = new PDO('mysql:host=localhost;dbname=streaming_website', 'root', '');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        
        $id_m = $_SESSION['id_m'];

        
        $stmt = $bdd->prepare("SELECT films.id_f, films.nom_f, films.description_f, films.lien_f FROM films INNER JOIN regarder ON films.id_f = regarder.id_f WHERE regarder.id_m = ? AND regarder.favori = 'Oui'");
        $stmt->execute([$id_m]);
        $films_favoris = $stmt->fetchAll();

        if ($films_favoris) {
            echo "<h3>Mes Films Favoris</h3>";
            foreach ($films_favoris as $film) {
                echo "<h3>" . htmlspecialchars($film['nom_f']) . "</h3>";
                echo "<p><strong>Description :</strong> " . htmlspecialchars($film['description_f']) . "</p>";
                echo "<video width='320' height='240' controls>";
                echo "<source src='" . htmlspecialchars($film['lien_f']) . "' type='video/mp4'>";
                echo "Votre navigateur ne supporte pas la lecture de vidéos.";
                echo "</video>";
            }
        } else {
            echo "<p>Aucun film favori trouvé.</p>";
        }
    } catch (PDOException $e) {
        
        echo "Erreur : " . $e->getMessage();
    }
} else {
    
    header("Location: login.php");
    exit();
}

require "includes/footer.php"; 
?>
