<?php
session_start(); // Démarrer la session pour stocker les informations de connexion

try {
    $bdd = new PDO('mysql:host=localhost;dbname=streaming_website', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if (isset($_POST['submit'])) {
    // Récupérer les autres champs du formulaire
    $commentaire = $_POST['commentaire'];
    $note = $_POST['note'];

    // Vérifier si le champ 'favori' est présent dans $_POST
    if (isset($_POST['favori'])) {
        $favori = $_POST['favori'];

        $id_film = $_GET['id_f']; 
        $id_m = $_SESSION['id_m']; 

       
        $stmt_commentaire = $bdd->prepare("INSERT INTO regarder (commentaire, note, favori, id_f, id_m) VALUES (?, ?, ?, ?, ?)");
        $stmt_commentaire->execute([$commentaire, $note, $favori, $id_film, $id_m]);

       
        echo "Le commentaire a été posté avec succès.";
    } else {

        echo "Le champ 'favori' n'est pas défini dans le formulaire.";
    }
}


?>
<?php
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=streaming_website', 'root', '');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

    $id_film = $_GET['id_f'];


    $stmt_commentaires = $bdd->prepare("SELECT commentaire, note FROM regarder WHERE id_f = ?");
    $stmt_commentaires->execute([$id_film]);
    $commentaires = $stmt_commentaires->fetchAll();

   
    if ($commentaires) {
        echo "<h2>Commentaires de ce  film :</h2>";
        foreach ($commentaires as $commentaire) {
            echo "<p>Commentaire : " . $commentaire['commentaire'] . "</p>";
            echo "<p>Note : " . $commentaire['note'] . "</p>";
            
            echo "<hr>";
        }
    } else {
        echo "<p>Aucun commentaire trouvé pour ce film.</p>";
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Page de commentaire </title>
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
                <form class="login100-form validate-form" method="post" enctype="multipart/form-data" action="">
                    <span class="login100-form-title p-b-26">
                        Publiez un commentaire
                    </span>
                    <span class="login100-form-title p-b-48">
                        <i class="zmdi zmdi-font"></i>
                    </span>

                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="text" name="commentaire">
                        <span class="focus-input100" data-placeholder="Commentaire"></span>
                    </div>

                    <div class="wrap-input100 validate-input">
                        <label for="note">Note :</label>
                        <select class="input100" name="note" required>
                            <option value="Médiocre">Médiocre</option>
                            <option value="Mauvais">Mauvais</option>
                            <option value="Pas mal">Pas mal</option>
                            <option value="Bien">Bien</option>
                            <option value="Excellent">Excellent</option>
                        </select>
                    </div>
                    <div class="wrap-input100 validate-input">
    <label for="favori">Favori :</label>
    <select class="input100" name="favori">
        <option value="Oui">Oui</option>
        <option value="Non">Non</option>
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
</body>
</html>
