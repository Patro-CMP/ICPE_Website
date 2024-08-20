<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ./../../Public_View_Pages/login.php");
    exit();
}
include './../../includes/connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./../../others_pages/style.css">
</head>
<body>
<!-- /// ////////////////////------HEADER------/////////////// //////////////////// -->
    <header>
        <?php include "./../../includes/header.php"; ?>
    </header>

<!-- /// ////////////////////------MAIN------/////////////// //////////////////// -->    
<main class="mb-3" style="margin-top:100px;"> 

<?php
if (isset($_POST["ok"])) {
    // Récupération des valeurs du formulaire ou utilisation de valeurs par défaut
    $title = $_POST['title'] ?? ''; // Récupère le titre ou utilise une chaîne vide si non défini
    $comment = $_POST['comment'] ?? 'ICPE_post'; // Récupère le commentaire ou utilise 'ICPE_post' si non défini
    $date = $_POST['date'] ?? NULL; // Récupère la date ou utilise NULL si non défini
    $author_id = $_SESSION['user_id']; // Récupère l'ID de la session
    
    // Vérifier si l'utilisateur a fourni une date
    if (empty($date)) {
        $date = NULL; // Laisser 'NULL' pour utiliser CURRENT_TIMESTAMP par défaut
    }

    // Taille maximale autorisée pour les fichiers (en octets)
    $maxFileSize = 100 * 1024 * 1024; // 100 Mo

    if (isset($_FILES['media']) && $_FILES['media']['error'] == 0) {
        $media = $_FILES['media']; // Récupère les informations du fichier ou null si non défini
        if ($media['size'] > $maxFileSize) {
            echo "<script>alert('Error: The file is too large. The maximum size allowed is ". ($maxFileSize / (1024 * 1024)) ." MB.');
                    window.location.href='./manage_blog.php';</script>";
            exit; // Important pour arrêter l'exécution après une erreur
        }

        // Gérer l'upload du fichier
        // Dossier où les fichiers seront uploadés
        $target_dir = "../uploads/";

        // Récupérer le nom de fichier et définir le chemin cible
        $target_name = basename($media["name"]);
        $target_file = $target_dir . $target_name;

        // Uploadé comme fichier temporaire
        $define_tmp = $media["tmp_name"];
        if (!move_uploaded_file($define_tmp, $target_file)) {
            echo "<script>alert('Error: Failed to upload file.');
                    window.location.href='./manage_blog.php';</script>";
            exit; // Important pour arrêter l'exécution après une erreur
        }
    } else {
        $target_file = NULL; // Pas de fichier uploadé
    }

    // Préparer et exécuter la requête d'insertion
    $sql = "INSERT INTO posts (title, comment, media, created_at, author_id) 
            VALUES (:title, :comment, :media, COALESCE(:created_at, CURRENT_TIMESTAMP), :author_id)";
    $stmt = $connex->prepare($sql);
    $stmt->execute([
        'title' => $title,
        'comment' => $comment,
        'media' => $target_file,
        'created_at' => $date,
        'author_id' => $author_id
    ]);

    echo "<script>alert('New post created successfully!');
            window.location.href='./manage_blog.php';</script>";
} else {
    echo "<script>alert('Error Of Execution! Fill the infos of the post');
            window.location.href='./manage_blog.php';</script>";
}


?>
</main>

<!-- /// ////////////////////------FOOTER------/////////////// //////////////////// -->
    <footer>
        <?php include "./../../includes/footer.php"; ?>
    </footer>
<!-- /// ////////////////////------SCRIPT JS------/////////////// //////////////////// -->
    <script src="./../../others_pages/javascript.js"></script>
</body>
</html>

