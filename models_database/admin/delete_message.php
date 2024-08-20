<?php
include '../../includes/connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Suppression du message
    $stmt = $connex->prepare("DELETE FROM messages WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo "<script>alert('Message deleted successfully!')</script>";
    header("Location: received_messages.php");
    exit();
}
?>