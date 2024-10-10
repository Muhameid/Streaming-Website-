<?php
session_start();


if (isset($_SESSION['email'])) { 
    try {
        
        $bdd = new PDO('mysql:host=localhost;dbname=streaming_website', 'root', '');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        
        $email = $_SESSION['email'];
        $requete = $bdd->prepare("SELECT * FROM users WHERE email = ?");
        $requete->execute([$email]);
        $utilisateur = $requete->fetch();
      } catch (PDOException $e) {
      
        echo "Erreur : " . $e->getMessage();
    }
} else {
  
    header("Location: login.php");
    exit();
}

    
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Streamify</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/Logo_design1-removebg-preview.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Cardo:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
      rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.0.0/mdb.min.css" rel="stylesheet" />

  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="assets/css/mycss.css" rel="stylesheet">
  


  <!-- =======================================================
  * Template Name: PhotoFolio
  * Template URL: https://bootstrapmade.com/photofolio-bootstrap-photography-website-template/
  * Updated: Mar 17 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div id="maclasse" class="container-fluid d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center  me-auto me-lg-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
         <img src="assets/img/Logo_design1-removebg-preview.png" alt="">
        
        <h1>Streamify</h1>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="index.php" class="active">Acceuil</a></li>
          
          <li class="dropdown"><a href="#"><span>Catégories</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              
            <li><a href="gallery-single.php?id_m=<?php echo $utilisateur['id_m']; ?>">Action et aventure</a></li>
          <li><a href="gallery.php?id_m=<?php echo $utilisateur['id_m']; ?>">Comédie</a></li>
          <li><a href="gallery.php?id_m=<?php echo $utilisateur['id_m']; ?>">Drame</a></li>
          <li><a href="gallery.php?id_m=<?php echo $utilisateur['id_m']; ?>">Science-fiction et fantastique</a></li>
          <li><a href="gallery.php?id_m=<?php echo $utilisateur['id_m']; ?>">Thriller et suspense</a></li>
          <li><a href="gallery.php?id_m=<?php echo $utilisateur['id_m']; ?>">Animation</a></li>
               <!-- <li class="dropdown"><a href="#"><span>Sous-menu</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                <ul>
                  <li><a href="#">Sous-menu 1</a></li>
                  <li><a href="#">Sous-menu 2</a></li>
                  <li><a href="#">Sous-menu 3</a></li>
                </ul>
              </li> -->
            </ul>
          </li>
          <li><a href="about.php">A Propos</a></li>
          <li><a href="services.php">Services</a></li>
          <li><a href="contact.php">Contact</a></li>
          <li><a href="favoris.php?id_m=<?php echo $utilisateur['id_m']; ?>">Accéder à vos films favoris</a></li>
          <li class="chercher"> <form class="d-flex" role="search">
            <input
                class="form-control me-2"
                type="search"
                placeholder="Trouver des films, séries, ......."
                aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Rechercher</button>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">

               <!-- <button class="btn btn-primary me-md-2" type="button">Subscribe</button>-->

            </div>
        </form>
      </li>
      <li><a href="logout.php">Déconnexion</a></li>
        </ul>
      </nav><!-- .navbar -->

    

    </div>
  </header><!-- End Header -->
  <!-- ======= Hero Section ======= -->
<section id="hero" class="hero d-flex flex-column justify-content-center align-items-center" data-aos="fade" data-aos-delay="1500">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
          <?php
// Récupérer la date de fin d'abonnement depuis la base de données ou une autre source
$date_abo_fin = strtotime($utilisateur['date_fin_abo']);

// Calculer le temps restant entre la date de fin d'abonnement et le moment actuel en secondes
$time_left = $date_abo_fin - time();

// Convertir le temps restant en jours, heures, minutes et secondes
$days = floor($time_left / (60 * 60 * 24));
$time_left %= (60 * 60 * 24);

$hours = floor($time_left / (60 * 60));
$time_left %= (60 * 60);

$min = floor($time_left / 60);
$time_left %= 60;

$sec = $time_left;

// Afficher le temps restant

?>

        <?php 
            echo "Bienvenue, " . $utilisateur['login'] . " !<br>";
            echo "Votre type d'abonnement est pour " . $utilisateur['type_abonnement_en_jours'] . " jours.<br>";
            echo "Votre abonnement a débuté le " . $utilisateur['date_deb_abo'] . " et se termine dans " . $days . " jours, " . $hours . " heures, " . $min . " minutes et " . $sec . " secondes.";

            ?>
        
          <p>Bienvenue sur Streamify, votre destination de streaming préférée !
             Explorez un large choix de films, séries et documentaires. 
             Profitez d'une expérience de streaming fluide et de qualité, où que vous soyez.
              Inscrivez-vous maintenant et plongez dans l'univers captivant de Streamify !.</p>
          <a href="index.php" class="btn-get-started">Actualiser la page pour savoir le temps restant de votre abonnement</a>
        </div>
      </div>
    </div>
  </section><!-- End Hero Section -->
