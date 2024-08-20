<?php
include './../../includes/connect.php';

// Handle update form submission
if (isset($_POST['update_post'])) {
    $id = $_POST['update_id'];
    $title = $_POST['update_title'];
    $comment = $_POST['update_comment'] ?? 'ICPE_post';
    $date = $_POST['update_date'] ?? null;
    $media = $_FILES['update_media'];
    
        // Vérifier si l'utilisateur a fourni une date
        if (empty($date)) {
            $date = NULL; // Laisser 'NULL' pour utiliser CURRENT_TIMESTAMP par défaut
        }
        // Gérer l'upload du fichier
        $target_dir = "../uploads/";
        $target_name = basename($media["name"]);
        $target_file = $target_dir . $target_name;
        move_uploaded_file($media["tmp_name"], $target_file);
    

    $stmt = $connex->prepare("UPDATE posts SET title = :title, comment = :comment, media = :media, created_at =  COALESCE(:created_at, CURRENT_TIMESTAMP) WHERE id = :id");
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':media', $target_file, PDO::PARAM_STR);
    $stmt->bindParam(':created_at', $date, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    echo "<script>alert('Post updated successfully'); window.location.href = './manage_blog.php';</script>";
}

?>