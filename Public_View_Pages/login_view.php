<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICPE Login Page 📲</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./../others_pages/style.css">
</head>
<body >
<!-- /// ////////////////////------HEADER------/////////////// //////////////////// -->
    
        <?php include "./../includes/header.php"; ?>
    

<!-- /// ////////////////////------MAIN------/////////////// //////////////////// -->
    <main class="main-authentifier" style="margin-top: 100px;">
        <section class="">
            <h1 class="text-dark">Connexion to Your Account</h1>
            <div class=" d-flex justify-content-center">
                <img src="./../images/Team3.jpg" width="35%" height="420px" class="rounded-circle " alt="">
                <!-- <form action="http://localhost:82/Project%20Website_ICPE.2.1.1/Programmation/Database%20ICPE/dashboard.php" method="post" > -->
                <form action="./login.php" method="post" class="fw-bold was-validated">
                    <div class="card text-light">
                        <div class="card-header">
                            <h3 class="text-center">Connexion</h3>
                        </div>
                        <div class="card-body">
                            <label for="username" class="form-label">Username or Email</label>
                            <input type="text" id="username" name="username" class="form-control" required><br>
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required><br>
                            <input type="submit" name="connecter" value="Log in" class="fw-bold" id="" style="width:6rem; height:4rem; font-size:1.2rem;">
                            <p>Forgot password?<a href="" style="font-weight:bold">Remember</a></p>
                            <p class="fw-bold text-center ">You do not have an account? <a href="./register.php"> Sign Up</a></p>
                        </div>
                    </div>
                </form>
            </div> 
        </section>
<!-- --------NEWSLETTER SIGN_UP---------------------- -->
        <section>
            <div class="container d-flex justify-content-center align-items-center text-light">
                <div class="card bg-info p-4 shadow-lg">
                    <h2 class="text-center bg-dark"  style="opacity: 0.7;">Sign Up for Our Newsletter</h2>
                    <p class="text-center bg-dark" style="opacity: 0.8;">Stay updated with the latest news and special offers directly in your inbox.</p>
                    <form action="./../models_database/message.php" method="post" class="">
                        <div class="mb-2">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                            <input type="hidden" id="subject" name="subject" value="Subscription to the Newsletter.">
                        </div>
                        <button type="submit" name="ok_send" class="btn btn-info fw-bold w-100 border-3 border-primary text-light">Subscribe</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
<!-- /// ////////////////////------FOOTER------/////////////// //////////////////// -->
    <footer>
        <?php include "./../includes/footer.php"; ?>
    </footer>
<!-- /// ////////////////////------SCRIPT JS------/////////////// //////////////////// -->
    <script src="./../others_pages/javascript.js"></script>
</body>
</html>