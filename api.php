<?php
session_start();

try {
    // Connexion à la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=streaming_website', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Gérer les erreurs d'exécution de la requête
    die("Erreur de connexion : " . $e->getMessage());
}



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

// Gestion des erreurs
if (!$response) {
    die("Erreur : " . curl_error($curl));
}

// Fermeture de la session cURL
curl_close($curl);

// Décodage de la réponse JSON
$data = json_decode($response, true);

// Affichage des vidéos
if (isset($data['items'])) {
    foreach ($data['items'] as $item) {
        // Extraire les détails de la vidéo
        $video_title = $item['snippet']['title'];
        $video_description = $item['snippet']['description'];
        $video_id = $item['id']['videoId'];
        
        // Afficher la vidéo
        echo "<h4>$video_title</h4>";
        echo "<p>$video_description</p>";
        echo "<iframe width='560' height='315' src='https://www.youtube.com/embed/$video_id' frameborder='0' allowfullscreen></iframe>";
        echo "<hr>";
    }
} else {
    echo "Aucune vidéo trouvée.";
}
?>
