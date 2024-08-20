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
    <title>Add user</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./../../others_pages/style.css">
</head>
<body>
<!-- /// ////////////////////------HEADER------/////////////// //////////////////// -->
    <header>
        <?php // include "./../../includes/header.php"; ?>
    </header>

<!-- /// ////////////////////------MAIN------/////////////// //////////////////// -->    
<main class="mb-3" style="margin-top:100px;"> 

<?php

if (isset($_POST['add_user'])) {
    // Récupérer les informations du formulaire
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $sql_check = "SELECT * FROM users WHERE username = :username OR email = :email";
    $result = $connex->prepare($sql_check);
    $result->execute(['username' => $username, 'email' => $email]);
    if ($result->rowCount() > 0) {
        // Si un utilisateur avec le même nom d'utilisateur ou email existe déjà
        echo "<script>alert('Username or Email already exists. Please choose a different one.');</script>";
    }
    else {
        if ($password === $confirm_password) {
            // Les mots de passe correspondent, on peut les hacher
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $sql = "INSERT INTO users (first_name, last_name, username, email, password, role) VALUES (:first_name, :last_name, :username, :email, :password, :role)";
            $stmt = $connex->prepare($sql);
            // Lier les paramètres
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':role', $role);
            // Exécuter la requête
            $stmt->execute();
            if ($stmt) {
                    echo "<script>alert('Registration Successfull!');</script>";
            }
        }
        else {
            echo "<script>alert('Passwords do not match')</script>";
        } 
    }
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

