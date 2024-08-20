<?php include "./../includes/connect.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register to ICPE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./../others_pages/style.css">
</head>
<body>
    <!-- /// ////////////////////------HEADER------/////////////// //////////////////// -->
    <header>
        <?php include "./../includes/header.php"; ?>
    </header>

<!-- /// ////////////////////------MAIN------/////////////// //////////////////// -->
    <main style="margin-top:100px;">
    <div class="row p-2">
        <div class=" col-sm">
            <h2>Create ICPE Account</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="first_name">First Name *:</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name *:</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                </div>
                <div class="form-group">
                    <label for="username">Username *:</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="optional" required>
                </div>
                <div class="form-group">
                    <label for="email">Email *:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            <!-- Password Field -->
            <label class="form-label" for="password">Password:</label><br>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" required>
                <span class="input-group-text eye-icon"  style="cursor: pointer;">
                    <i class="fa fa-eye-slash" id="togglePassword"></i>
                </span><!-- Icône d'œil -->
            </div>

            <!-- COnfirm Password -->
            <div class="form-group">
                <label for="confirm_password">Confirm Password :</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required placeholder="Please confirm your password!">
                    <span class="input-group-text eye-icon" style="cursor: pointer;">
                        <i class="fa fa-eye-slash" id="toggleConfirmPassword"></i>
                    </span>
                </div>
            </div>
                <button type="submit" name="ok" class="btn btn-primary mt-2">Sign Up</button><br>
                <i>Already have an account? <a href="./login.php">Log in here</a></i>
                <p>By Signing up, You Agree to Our <a href="#">Terms of Service and Privacy Policy.</a></p>
            </form>
        </div>
        <div class=" col-sm-6 ">
            <div class="card mt-5 bg-info">
                <div class="card-img">
                    <img src="./../images/icpe group photo_team.jpg" style="float: right;" width="300px" height="300px" alt="">
                    <p class="card-title text-light fw-bold fs-3">
                        ICPE, Your Partner In Children Advocacies
                    </p>
                </div>
            </div>
        </div>
    </div>

<?php
if (isset($_POST['ok'])) {
    // Récupérer les informations du formulaire
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
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

            $sql = "INSERT INTO users (first_name, last_name, username, email, password) VALUES (:first_name, :last_name, :username, :email, :password)";
            $stmt = $connex->prepare($sql);
            // Lier les paramètres
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
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
        <?php include "./../includes/footer.php"; ?>
    </footer>

<!-- /// ////////////////////------SCRIPT JS------/////////////// //////////////////// -->
<script>
// // -------------------SCRIPT MANAGE Password---------------
// // Fonction pour basculer la visibilité du mot de passe
function togglePasswordVisibility(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(iconId);

        if (passwordInput.type === "password") {
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
            passwordInput.type = "text";
        } else {
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
            passwordInput.type = "password";
        }
    }

    // Événements pour basculer la visibilité de chaque champ
    document.getElementById('togglePassword').addEventListener('click', function() {
        togglePasswordVisibility('password', 'togglePassword');
    });

    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        togglePasswordVisibility('confirm_password', 'toggleConfirmPassword');
    });

    </script>
</body>
</html>