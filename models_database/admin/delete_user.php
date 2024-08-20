<?php
include './../../includes/connect.php';

// Handle delete form submission
if (isset($_POST['confirm_delete'])) {
    $id = $_POST['delete_id'];

    $stmt = $connex->prepare("DELETE FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    echo "<script>alert('User deleted successfully'); window.location.href = './manage_users.php';</script>";
}
?>