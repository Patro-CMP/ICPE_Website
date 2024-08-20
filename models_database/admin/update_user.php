<?php
include './../../includes/connect.php';

// Handle update form submission
if (isset($_POST['update_user'])) {
    $id = $_POST['update_id'];
    $first_name = $_POST['update_first_name']??'';
    $last_name = $_POST['update_last_name'] ?? '';
    $username = $_POST['update_username'] ?? '';
    $email = $_POST['update_email']??'';
    $password = $_POST['update_password'] ??'';
    $role = $_POST['update_role'];
    
        // Vérifier si l'utilisateur a fourni une date
        if (empty($date)) {
            $date = NULL; // Laisser 'NULL' pour utiliser CURRENT_TIMESTAMP par défaut
        }
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $connex->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, username = :username, email = :email, password = :password, role = :role, created_at =  COALESCE(:created_at, CURRENT_TIMESTAMP) WHERE id = :id");
    $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
    $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
    $stmt->bindParam(':role', $role, PDO::PARAM_STR);
    $stmt->bindParam(':created_at', $date, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    echo "<script>alert('User updated successfully'); window.location.href = './manage_users.php';</script>";
}

?>