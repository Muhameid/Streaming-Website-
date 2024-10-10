<?php
session_start(); // Démarrer la session pour stocker les informations de connexion

try {
    $bdd = new PDO('mysql:host=localhost;dbname=streaming_website', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifier si le formulaire a été soumis
if (isset($_POST['submit'])) {
    $nom = $_POST['nom_f'];
    $duree = $_POST['duree_f'];
    $description = $_POST['description_f'];
    $lien = $_FILES['lien_f']['tmp_name'];
    $videoName = $_FILES['lien_f']['name']; 
    $id_cat = $_POST['id_cat'];

    // Traitement de l'image de couverture
    $image = $_FILES['imag_f']['tmp_name'];
    $imageName = $_FILES['imag_f']['name']; 
    $uploadDir = 'includes\Video\ '; // Chemin vers le dossier où vous souhaitez enregistrer l'image
    $imageDestPath = $uploadDir . $imageName; 

    // Vérifier si une image a été téléchargée
    if (!empty($imageName)) {
        if (move_uploaded_file($image, $imageDestPath)) {
        
        } else {
            echo "Une erreur s'est produite lors du téléchargement de l'image.";
        }
    } else {
        echo "Veuillez sélectionner une image de couverture.";
    }

    // Vérifier si la catégorie a été sélectionnée
    if ($id_cat != '') {
        $uploadDir = 'includes\Video\ ';
        $videoDestPath = $uploadDir . $videoName; // Définir le chemin complet du fichier vidéo

        // Vérifier si le fichier vidéo a été correctement téléchargé
        if (isset($_FILES['lien_f']) && $_FILES['lien_f']['error'] === UPLOAD_ERR_OK) {
            if (move_uploaded_file($lien, $videoDestPath)) {
               
                $stmt_film = $bdd->prepare("INSERT INTO films (nom_f, duree_f, description_f, lien_f, id_cat, imag_f) VALUES (?, ?, ?, ?, ?, ?)");

                
                $stmt_film->execute([$nom, $duree, $description, $videoDestPath, $id_cat, $imageDestPath]);

               
                echo "Le film a été téléchargé avec succès et ajouté à la base de données.";
            } else {
                echo "Une erreur s'est produite lors du téléchargement de la vidéo.";
            }
        } else {
            echo "Veuillez sélectionner une vidéo à télécharger.";
        }
    } else {
        echo "Veuillez sélectionner une catégorie.";
    }
}
?>


    


    <!DOCTYPE html>
<html lang="fr">
<head>
    <title>Page d'administration</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
</head>
<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="post" enctype="multipart/form-data" action="admin.php">
                    <span class="login100-form-title p-b-26">
                        Publiez un film
                    </span>
                    <span class="login100-form-title p-b-48">
                        <i class="zmdi zmdi-font"></i>
                    </span>

                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="text" name="nom_f" required>
                        <span class="focus-input100" data-placeholder="Nom du film"></span>
                    </div>

                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="time" name="duree_f" required>
                        <span class="focus-input100" data-placeholder="Durée du film"></span>
                    </div>

                    <div class="wrap-input100 validate-input">
                        <span class="btn-show-pass">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                        <input class="input100" type="text" name="description_f" required>
                        <span class="focus-input100" data-placeholder="Description du film"></span>
                    </div>

                    <div class="wrap-input100 validate-input">
                        <label for="lien_f">Sélectionnez le fichier vidéo :</label>
                        <input type="file" name="lien_f" accept="video/*" required>
                    </div>

                    <div class="wrap-input100 validate-input" >
                        <label for="image_f">Sélectionnez une image de couverture :</label>
                        <input type="file" name="image_f" accept="image/*">
                    </div>
                    <div class="wrap-input100 validate-input">
    <label for="id_cat">Choisissez la catégorie :</label>
    <select name="id_cat" id="id_cat">
        <option value="1">Action et aventure</option>
        <option value="2">Comédie</option>
        <option value="3">Drame</option>
        <option value="4">Science-fiction et fantastique</option>
        <option value="5">Thriller et suspense</option>
        <option value="6">Animation</option>
    </select>
</div>


                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn" name="submit">
                                Publication
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div id="dropDownSelect1"></div>
    




    <!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>

    <!-- Ajoute ton JavaScript personnalisé ici -->
    <script>
        // Ton code JavaScript personnalisé
    </script>
    
    <?php
   // Supprimer les commentaires
   if(isset($_GET['supp_commentaire'])) {
      $id_commentaire = $_GET['supp_commentaire'];
      $requete = $bdd->prepare("DELETE FROM regarder WHERE id_f = ?");
      $requete->execute([$id_commentaire]);
   }
?>

<section>
    <?php
    // Récupérer les films
    $requete_films = $bdd->query("SELECT * FROM films");

    while($film = $requete_films->fetch()) {
        // Afficher le titre du film
        echo "<h6>" . htmlspecialchars($film['nom_f']) . "</h6>";

        // Afficher un lien pour supprimer les commentaires du film
        echo "<a href='admin.php?supp_commentaire=" . $film['id_f'] . "'>Supprimer les commentaires</a><br><br>";
    }
    ?>
</section>





   <?php
   // Banissement
   if(isset($_GET['ban_ip'])) {
      $ip_ban = $_GET['ban_ip'];
      $requete = $bdd->prepare("UPDATE users SET lvl = 0 WHERE ip_ban = ?");
      $requete->execute([$ip_ban]);
      
   }
?>

<section>
    <?php
        $requete = $bdd->query("SELECT * FROM users");

        while($reponse = $requete->fetch()) {
            echo "<span>". $reponse['login'] ."</span>&nbsp
            <a href='admin.php?ban_ip=".$reponse['ip_ban']."'>bannir</a><br>";
        }
    ?>
</section>
<?php
   // DéBanissement
   if(isset($_GET['deban_ip'])) {
      $ip_ban = $_GET['deban_ip'];
      $requete2 = $bdd->prepare("UPDATE users SET lvl = 1 WHERE ip_ban = ?");
      $requete2->execute([$ip_ban]);
      
   }
?>

<section>
    <?php
        $requete2 = $bdd->query("SELECT * FROM users");

        while($reponse = $requete2->fetch()) {
            echo "<span>". $reponse['login'] ."</span>&nbsp
            <a href='admin.php?deban_ip=".$reponse['ip_ban']."'>Débannir</a><br>";
        }
    ?>
</section>

           

    </section>

    
</body>
</html>


