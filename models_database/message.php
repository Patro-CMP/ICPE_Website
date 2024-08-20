<?php 
include '../includes/connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['ok'])) {
    // Récupération des données du formulaire
    $email = $_POST['email']??'';
    $subject = $_POST['subject']??'';
    $message = $_POST['message']??'';

    // Insertion des données dans la base de données
    $stmt = $connex->prepare("INSERT INTO messages (email, subject, message) VALUES (:email, :subject, :message)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':subject', $subject);
    $stmt->bindParam(':message', $message);
    $stmt->execute();

    echo "<script>alert('Message sent successfully!')
            window.location.href='./../Public_View_Pages/index.php';
        </script>";
}
else if($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['ok_send'])){
    // Récupération des données du formulaire
    $email = $_POST['email']??'';
    $subject = $_POST['subject'] ??'';

    // Insertion des données dans la base de données
    $stmt = $connex->prepare("INSERT INTO messages (email, subject) VALUES (:email, :subject)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':subject', $subject);
    $stmt->execute();

    echo "<script>alert('Thanks! Sign up successfully!')
            window.location.href='./../Public_View_Pages/index.php';
        </script>";
}

?>