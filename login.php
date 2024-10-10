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
<html lang="fr">

<head>
    <title>Connexion - Streaming</title>
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

        .login-container {
            background-color: #222; /* Boîte sombre */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.6);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .login-container h2 {
            color: #fff;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: bold;
        }

        .form-floating input {
            background: #333;
            border: 1px solid #444;
            color: white;
        }

        .form-floating input::placeholder {
            color: #bbb;
        }

        .form-floating label {
            color: #999;
        }
        .Mailto{ padding-right: 55px;}

        .login-btn {
            background-color: #e50914; /* Couleur rouge typique des plateformes de streaming comme Netflix */
            border: none;
            padding: 10px;
            font-size: 18px;
            font-weight: bold;
            width: 100%;
            margin-top: 20px;
            color: white;
            transition: background-color 0.3s ease;
        }

        .login-btn:hover {
            background-color: #f40612;
        }

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
        .login-container .icon-title {
            color: #e50914;
            font-size: 50px;
            margin-bottom: 20px;
        }

        /* Style pour les petits appareils */
        @media (max-width: 576px) {
            .login-container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="login-container">
        <i class="fas fa-play-circle icon-title"></i> <!-- Icône en lien avec le streaming -->
        <h2>Connexion</h2>

        <form method="post">
            <div class="form-floating mb-3">
            <label for="email" class="Mailto">Email:        </label>
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                
            </div>

            <div class="form-floating mb-3">
            <label for="mdp">Mot de passe: </label>
                <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe" required>
                
            </div>

            <button class="login-btn" type="submit" name="submit_login">Connexion</button>

            <div class="form-footer">
                <p>Pas de compte ? <a href="register.php">Inscrivez-vous</a></p>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
