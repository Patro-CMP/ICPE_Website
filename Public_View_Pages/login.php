<?php
session_start(); 
    include './../includes/connect.php';
    include './login_view.php';
    
    if (isset($_POST['connecter'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (!empty($username) or !empty($password)) {
            $sql = "SELECT * FROM users WHERE username = '$username' or email = '$username' ";
            $result = $connex->query($sql);
            // Fetch the user data
            if ($user = $result->fetch()) {

                // Verify the password
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['last_name'] = $user['last_name'];
                    $_SESSION['role'] = $user['role'];
                    setcookie("username",$username,time()+3600*24*365);
                    setcookie("password",$password,time()+3600*24*365);
                    echo "<script>window.location.href='./../models_database/admin/index.php';</script>";
                }else {
                    echo "<script>alert('Incorrect password.')</script>";
                }
            }else {
                echo "<script>alert('User not found or Incorrect Email/Username.')</script>";
            } 
        } else {
            echo "<script>alert('Please fill out the email or Username and password!')</script>";
        }
    }  
?>
