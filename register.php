<!-- php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); 
try {
    $bdd = new PDO('mysql:host=localhost;dbname=streaming_website', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  
    if (isset($_POST['submit_registration'])) {
        
        $login = $_POST['login'];
        $email = $_POST['email'];
        $mdp = sha1($_POST['mdp']); 
        $type_abonnement = isset($_POST['type_abonnement']) ? $_POST['type_abonnement'] : 2; 
        $date_deb_abo = date('Y-m-d H:i:s'); // Date actuelle
        $date_fin_abo = date('Y-m-d H:i:s', strtotime("+{$type_abonnement} days"));
        $ip_ban = $_SERVER['REMOTE_ADDR'];

        $stmt = $bdd->prepare("SELECT * FROM users WHERE email = ? OR ip_ban = ?");
        $stmt->execute([$email, $ip_ban]);
        $existing_user = $stmt->fetch();

        if ($existing_user) {
            
            echo "Cet utilisateur est banni.";
        } else {
            
            $requete = $bdd->prepare("INSERT INTO users (login, email, mdp, type_abonnement_en_jours, date_deb_abo, date_fin_abo, ip_ban) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $requete->execute([$login, $email, $mdp, $type_abonnement, $date_deb_abo, $date_fin_abo, $ip_ban]);

            
            header("Location: login.php");
            exit();
        }
    }
} catch (PDOException $e) {
    
    die("Erreur de connexion : " . $e->getMessage());
}
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Inscription</title>
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

                    <div class="wrap-input100 validate-input" data-validate="Valid email is: a@b.c">
                        <input class="input100" type="text" name="login">
                        <span class="focus-input100" data-placeholder="login"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Valid email is: a@b.c">
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

                    <div class="wrap-input100 validate-input" data-validate="Valid email is: a@b.c">
                        <label for="type_abonnement">Choisissez votre type d'abonnement :</label>
                        <select name="type_abonnement" id="type_abonnement">
                            <option value="2">2 jours</option>
                            <option value="3">3 jours</option>
                            <option value="5">5 jours</option>
                        </select>
                    </div>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn" name="submit_registration">
                                Inscription
                            </button>
                        </div>
                    </div>

                    <div class="text-center p-t-115">
                        <span class="txt1">
                            Vous avez déjà un compte?
                        </span>

                        <a class="txt2" href="login.php">
                            Connectez-Vous
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

    
    <script>
       
    </script>

</body>
</html>
