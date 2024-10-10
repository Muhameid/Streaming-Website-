<?php
session_start(); // Démarrer la session pour stocker les informations de connexion

try {
    $bdd = new PDO('mysql:host=localhost;dbname=streaming_website', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if (isset($_POST['submit_login'])) {
    $email = $_POST['email'];
    $mdp = sha1($_POST['mdp']); 
    $requete = $bdd->prepare("SELECT * FROM users WHERE email = ? AND mdp = ?");
    $requete->execute([$email, $mdp]);
    $users = $requete->fetch();

    if ($users) {
        if ($users['lvl'] == 0 && $users['ip_ban'] != '' ) {
            echo "Dégage, tu es banni";
        } elseif ($users['lvl'] == 2) {
            // S                                                  
            $_SESSION['email'] = $email;
            $_SESSION['id_m'] = $users['id_m'];
            // Rediriger vers la page admin.php
            header("Location: admin.php");
            exit();
        } elseif ($users['lvl'] == 1) {
           
            $_SESSION['email'] = $email;
            $_SESSION['id_m'] = $users['id_m'];
            setcookie("email", $email, time() +3600);
            setcookie("mdp", $mdp, time() +3600);
            $_SESSION['id_m'] = $users['id_m'];

            header("Location: index.php?id_m=" . $users['id_m']);
            exit();
        }
    } else {
        $message = "Mauvais identifiant ou mot de passe";
        echo $message;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Connexion</title>
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
                <form class="login100-form validate-form" method="post">
                    <span class="login100-form-title p-b-26">
                        Bienvenue
                    </span>
                    <span class="login100-form-title p-b-48">
                        <i class="zmdi zmdi-font"></i>
                    </span>

                    <div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
                        <input class="input100" type="text" name="email">
                        <span class="focus-input100" data-placeholder="Email"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <span class="btn-show-pass">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                        <input class="input100" type="password" name="mdp">
                        <span class="focus-input100" data-placeholder="Password"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn" name="submit_login">
                                Cliquez ici pour vous connecter
                            </button>
                        </div>
                    </div>

                    <div class="text-center p-t-115">
                        <span class="txt1">
                            Vous n'avez pas de compte?
                        </span>

                        <a class="txt2" href="register.php">
                            Inscrivez-vous
                        </a>
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
