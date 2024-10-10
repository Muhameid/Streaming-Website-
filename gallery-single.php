<?php
require "includes/header.php"; // Appel du header
?>

<main id="main" data-aos="fade" data-aos-delay="1500">
    <!-- ======= End Page Header ======= -->

    <!-- Gallery Single Section -->
    <section id="gallery-single" class="gallery-single">
        <div class="container-fluid">
            <div class="row gy-4 justify-content-center">
            <?php

$stmt = $bdd->query("SELECT id_f, nom_f, description_f, lien_f, imag_f FROM films");

while ($row = $stmt->fetch()) {
    $id_m = isset($_SESSION['id_m']) ? $_SESSION['id_m'] : '';

    
    $commentaire_url = "commentaire.php?id_f=" . htmlspecialchars($row['id_f']);
    if (!empty($id_m)) {
        $commentaire_url .= "&id_m=$id_m"; // Ajout de l'id_m à l'URL
    }
   
    $image_src = !empty($row['imag_f']) ? $row['imag_f'] : "assets/img/arajin.jpeg";

    
    echo '<div class="col-xl-3 col-lg-4 col-md-6">';
    echo '<div class="gallery-item h-100">';
    echo '<img src="' . htmlspecialchars($image_src) . '" class="img-fluid" alt="">';
    echo '<div class="gallery-links d-flex align-items-center justify-content-center">';
    echo '<a href="' . htmlspecialchars($row['lien_f']) . '" title="Appuyer pour regarder le film" class="glightbox preview-link"><i class="bi bi-arrows-angle-expand"></i></a>';
   
    echo "<p><strong>Titre du film :</strong> " . htmlspecialchars($row['nom_f']) . "</p>";
    
    echo "<p><strong>Description :</strong> " . htmlspecialchars($row['description_f']) . "</p>";
    echo '<a href="' . $commentaire_url . '" class="details-link" title=" Commenter ce film ou le Mettre en favori"><i class="bi bi-arrows-angle-expand"></i></a>';
    
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
?>

            </div>
        </div>
    </section>

    <!-- Section pour les suggestions YouTube -->
    <section id="youtube-suggestions" class="gallery-single">
        <div class="container-fluid">
            <div class="row gy-4 justify-content-center">
                <?php
                // ID de la chaîne YouTube
                $channel_id = "UC_i8X3p8oZNaik8X513Zn1Q";

                // Clé de l'API YouTube
                $api_key = "AIzaSyAztI_z2CF5R8h0xkj0sLgIpU3aWp-0jNU";

                // URL de l'API YouTube
                $api_url = 'https://www.googleapis.com/youtube/v3/search?key=' . $api_key . '&part=snippet&maxResults=5&type=video&channelId=' . $channel_id;

                // Initialisation de cURL
                $curl = curl_init();

                // Configuration de cURL
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $api_url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                ));

                // Exécution de la requête cURL et récupération de la réponse
                $response = curl_exec($curl);

            
                if (!$response) {
                    die("Erreur : " . curl_error($curl));
                }

                
                curl_close($curl);

                
                $data = json_decode($response, true);

                // Affichage des vidéos YouTube suggérées
                if (isset($data['items'])) {
                    
                    shuffle($data['items']);
                
                    foreach ($data['items'] as $item) {
                    
                        $video_title = $item['snippet']['title'];
                        $video_description = $item['snippet']['description'];
                        $video_id = $item['id']['videoId'];
                
                       
                        echo '<div class="col-xl-3 col-lg-4 col-md-6">';
                        echo '<div class="gallery-item h-100">';
                        echo "<h6>$video_title</h6>";
                        echo "<p>$video_description</p>";
                        echo "<iframe width='320' height='240' src='https://www.youtube.com/embed/$video_id' frameborder='0' allowfullscreen></iframe>";
                        echo '</div>';
                        echo '</div>';
                    }
                }
                // ...
                ?>
            </div>
        </div>
    </section>
    <!-- End Section pour les suggestions YouTube -->
</main>

<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="container">
        <div class="copyright">
            &copy; Copyright
            <strong>
                <span>PhotoFolio</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form:
            https://bootstrapmade.com/photofolio-bootstrap-photography-website-template/ -->
            Designed by
            <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </div>
</footer>
<!-- End Footer -->

<a href="#" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>

<div id="preloader">
    <div class="line"></div>
</div>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

</body>

</html>
