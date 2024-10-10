<?php
// Activer les rapports d'erreurs (pour le développement uniquement)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); 

try {
    // Connexion à la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=streaming_website', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérification si le formulaire d'inscription a été soumis
    if (isset($_POST['submit_registration'])) {
        
        // Récupération et validation des données du formulaire
        $login = trim($_POST['login']);
        $email = trim($_POST['email']);
        $mdp = sha1($_POST['mdp']); // Utilisation de sha1 pour le hashage du mot de passe
        $type_abonnement = isset($_POST['type_abonnement']) ? $_POST['type_abonnement'] : 2; 
        $date_deb_abo = date('Y-m-d H:i:s'); // Date actuelle
        $date_fin_abo = date('Y-m-d H:i:s', strtotime("+{$type_abonnement} days"));
        $ip_ban = $_SERVER['REMOTE_ADDR'];

        // Vérification si tous les champs obligatoires sont remplis
        if (empty($login) || empty($email) || empty($mdp)) {
            echo "Veuillez remplir tous les champs obligatoires.";
        } else {
            // Vérifier si l'utilisateur existe déjà via l'email ou l'IP
            $stmt = $bdd->prepare("SELECT * FROM users WHERE email = ? OR ip_ban = ?");
            $stmt->execute([$email, $ip_ban]);
            $existing_user = $stmt->fetch();

            if ($existing_user) {
                // Vérifier si l'utilisateur est banni ou s'il a déjà un compte
                if ($existing_user['ip_ban'] === $ip_ban) {
                    echo "Cet utilisateur est banni.";
                } else if($existing_user['email'] === $email){
                    echo "Cet email est déjà utilisé.";
                }
              else {
                // Insertion du nouvel utilisateur dans la base de données
                $requete = $bdd->prepare("INSERT INTO users (login, email, mdp, type_abonnement_en_jours, date_deb_abo, date_fin_abo, ip_ban) 
                                          VALUES (?, ?, ?, ?, ?, ?, ?)");
                $requete->execute([$login, $email, $mdp, $type_abonnement, $date_deb_abo, $date_fin_abo, $ip_ban]);

                // Rediriger vers la page de connexion après l'inscription
                header("Location: login.php");
                exit();
            }
        }
        }
    }
} catch (PDOException $e) {
    // Gestion des erreurs de connexion à la base de données
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Inscription - Streaming</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #141414; /* Fond sombre, typique des sites de streaming */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .signup-container {
            background-color: #222; /* Boîte sombre */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.6);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .signup-container h2 {
            color: #fff;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: bold;
        }

        .form-floating input, .form-floating select {
            background: #333;
            border: 1px solid #444;
            color: white;
        }

        .form-floating input::placeholder, .form-floating select::placeholder {
            color: #bbb;
        }

        .form-floating label {
            color: #999;
        }

        .signup-btn {
            background-color: #e50914; /* Couleur rouge vif */
            border: none;
            padding: 10px;
            font-size: 18px;
            font-weight: bold;
            width: 100%;
            margin-top: 20px;
            color: white;
            transition: background-color 0.3s ease;
        }

        .signup-btn:hover {
            background-color: #f40612;
        }
        .mailto2{ padding-right: 55px;}

        .form-footer {
            margin-top: 20px;
        }

        .form-footer a {
            color: #e50914;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        /* Icône dans le titre */
        .signup-container .icon-title {
            color: #e50914;
            font-size: 50px;
            margin-bottom: 20px;
        }

        /* Style pour les petits appareils */
        @media (max-width: 576px) {
            .signup-container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="signup-container">
        <i class="fas fa-user-plus icon-title"></i> <!-- Icône en lien avec l'inscription -->
        <h2>Inscription</h2>

        <form method="post">
            <div class="form-floating mb-3">
            <label for="login" class="mailto2">Login</label>
                <input type="text" class="form-control" id="login" name="login" placeholder="Login" required>
                
            </div>

            <div class="form-floating mb-3">
            <label for="email" class="mailto2">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
              
            </div>

            <div class="form-floating mb-3">
            <label for="mdp" >Mot de passe</label>
                <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe" required>
               
            </div>
            <br> <br>

            <div class="form-floating mb-3">
                <select class="form-control" id="type_abonnement" name="type_abonnement" required>
                    <option value="" disabled selected>Choisissez votre abonnement</option>
                    <option value="2">2 jours</option>
                    <option value="3">3 jours</option>
                    <option value="5">5 jours</option>
                </select>
                <label for="type_abonnement">Abonnement</label>
            </div>

            <button class="signup-btn" type="submit" name="submit_registration">S'inscrire</button>

            <div class="form-footer">
                <p>Déjà un compte ? <a href="login.php">Connectez-vous</a></p>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
