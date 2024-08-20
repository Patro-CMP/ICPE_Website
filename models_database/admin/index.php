<?php
include './../../includes/connect.php';
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] == 'visitor') {
    echo "<script>alert('Login Required: This section is accessible to authorized users only. Please ensure you are using an approved account. Contact the administrators for more information!')
                    window.location.href='./../../Public_View_Pages/login.php';
          </script>";
    exit();
}

// Fetch user data if needed
$user_id = $_SESSION['user_id'];
$stmt = $connex->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(':id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./../../others_pages/style. css">
    <style>
        .navbar-collapse .navbar-nav .nav-item .nav-link:hover{
            color:white;
            font-size:24px;
            transition: 0.2s;
        }
        .navbar-collapse .navbar-nav .nav-item a.btn:hover{
            color:white;
            transition: 0.2s;
        }
        .nav-tabs .nav-item a.btn:focus{
            color:orange;
            font-size:24px;
            border-radius: 50%;
        }
        .nav-tabs .nav-item a.btn:hover{
            font-size:24px;
            transition: 1.2s;
        }
        button[name='manage_users'] a:hover, button[name='manage_blog'] a:hover{
            font-size:24px;
            transition: 0.2s;
        }
    </style>
</head>
<body style="margin-top:80px; background: rgba(231, 170, 14, 0.2); font-family:Georgia;">

<!-- /// ////////////////////------HEADER------/////////////// //////////////////// -->
    <header class="fixed-top">
        <nav class="navbar navbar-expand-md navbar-light bg-info fw-bold">
            <div class="">
                <a class="navbar-brand" href="#">
                    <img src="./../../images/ICPE_Logo_Original2.png" alt="Logo" width="50rem" height="50rem" class="align-text-center">
                    <abbr title="INITIATIVE FOR CHILD PROTECTION AND EMPOWERMENT">ICPE</abbr>
                </a>
            </div>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon text-center"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-center" href="./../../Public_View_Pages/index.php" target="_top">Home ICPE</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="btn border-primary border-2 me-1 fw-bold" href="./manage_blog.php">Manage_blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn border-primary border-2 me-1 fw-bold" href="./manage_users.php">Manage_users</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn border-primary border-2 me-1 fw-bold" href="./received_messages.php">Messages</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn border-primary border-2 me-1 fw-bold" href="./manage_donations.php">Donations</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn alert-secondary border-primary border-2 me-1 fw-bold" href="#myTab" target="_top">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-secondary border-primary border-2 fw-bold"  id="log_out-tab"  type='button' data-bs-toggle='modal' data-bs-target='#logOutModal'>Log Out</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link text-center" href="./../../Public_view_pages/login.php">Log in</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>

<!-- /// ////////////////////------MAIN------/////////////// //////////////////// -->
    <main>
    <div class="container">
        <h1 class="alert-info rounded-top text-center">Welcome, <?php echo htmlspecialchars($user['username']); ?> to the control panel!</h1>
    </div>
    <section class="admin">
        <?php if ($user['role'] == 'admin'): ?>
            <h2 class="alert-info rounded-pill text-center">You're now logged in as an Administrator. <br> Manage your platform efficiently and securely!"</h2>
            <!-- _______________________Admin DASHBOARD____________________________________-->
            <div class="container mt-2 text-center w-100 sticky-sm-top"style="top:2rem" >
                <ul class="nav nav-tabs d-md-flex justify-content-center align-items-center p-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="btn btn-primary border-warning border-3 p-3 m-2 fw-bold" id="blog-tab" data-bs-toggle="tab" href="#blog" role="tab" aria-controls="blog" aria-selected="true">Manage blog</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="btn btn-primary border-warning border-3 p-3 m-2 fw-bold" id="users-tab" data-bs-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="false">Manage Users</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="btn btn-primary border-warning border-3 p-3 m-2 fw-bold" id="donations-tab" data-bs-toggle="tab" href="#donations" role="tab" aria-controls="donations" aria-selected="false">Donations</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="btn btn-primary border-warning border-3 p-3 m-2 fw-bold" id="messages-tab"href="./received_messages.php">Messages</a>
                    </li>
                </ul>
            </div>

<!-- MODAL for log out Confirmation -->
<div class="modal fade" id="logOutModal" tabindex="-1" aria-labelledby="logOutModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logOutModalLabel">Confirm log out</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to log out?
      </div>
      <div class="modal-footer">
        <form method="post" action="./../logout.php">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger" name="confirm_log_out">Yes, Log out</button>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- _______________________Executions of Admin DASHBOARD____________________________________-->
<article class="tab-content" id="myTabContent">
    <!-- _______________________MANAGE BLOG____________________________________-->
    <div class="tab-pane fade show active" id="blog" role="tabpanel" aria-labelledby="blog-tab">
        <div class="row mt-5 alert-info">
            <div class="col-sm-4 d-flex p-2 justify-content-center align-items-center border border-2">
                <!-- __________Afficher Modifier Supprimer Blog__________ -->
                <div class="flex-sm-column text-center">
                    <h1 class="fw-bold mt-4">Explore Blog</h1>
                    <button type="button" name="manage_blog" class="btn btn-primary p-3"><a href="./manage_blog.php" class="link text-light fw-bold">View All Posts</a></button>
                </div>
            </div>
            <!-- __________Form to add Blog__________ -->
            <div class="col-sm-6 flex-sm-column justify-content-center align-items-center m-1">
                <h1 class="text-center fw-bold">Add to Blog</h1>
                <h3 class="text-center fw-bold"><i>Post an image <cite> [format (jpeg|jpg|png|gif)]</cite> <br> Or a video <cite> [format (mp4|avi|mov|mkv)]</cite></i></h3>
                <form id="blogForm" action="./add_post.php" method="POST" enctype="multipart/form-data" class="fw-bold m-5">
                    <div class="form-group">
                        <label for="title" class="form-label">Title :</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div><br>
                    <div class="form-group">
                        <label for="comment" class="form-label">Comments :</label>
                        <textarea class="form-control" id="comment" name="comment" rows="4"></textarea>
                    </div><br>
                    <div class="form-group">
                        <label for="date" class="form-label">Date (DD-MM-YYYY):</label>
                        <input type="date" class="form-control" id="date" name="date">
                    </div><br>
                    <div class="form-group">
                        <label for="media" class="form-label">Add IMAGE or VIDEO :</label><br>
                        <input type="file" class="form-control-file" id="media" name="media" accept="image/*,video/*">
                    </div><br>
                    <button type="submit" name="ok" class="btn btn-primary form-control fw-bold">Add to blog</button>
                </form>
            </div>
        </div>
    </div>

    <!-- _______________________MANAGE USERS____________________________________-->
<div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
        <!-- _______________________ADD NEW MEMBER And EXPLORE____________________________________-->
    <div class="row alert-info">
        <div class="col-sm-3 d-flex pt-4 justify-content-center align-items-start border border-2">
                <!-- __________Afficher Modifier Supprimer User__________ -->
                <div class="flex-sm-column text-center">
                    <h1 class="fw-bold">Explore users Tab</h1>
                    <button type="button" name="manage_users" class="btn btn-primary p-3"><a href="./manage_users.php" class="link text-light fw-bold">View All Users</a></button>
                </div>
            </div>
       <div class="col-sm-5 pt-0 me-3">
        <form action="./add_user.php" method="post" class="was-validated container m-5">
            <h2>Create ICPE Account</h2>
            <!-- First Name -->
            <label class="form-label" for="first_name">First Name:</label><br>
            <input type="text" name="first_name" id="first_name" class="form-control" required><br>
            
            <!-- Last Name -->
            <label class="form-label" for="last_name">Last Name:</label><br>
            <input type="text" name="last_name" id="last_name" class="form-control" required><br>

            <!-- Username -->
            <label class="form-label" for="username">Username:</label><br>
            <input type="text" name="username" id="username" class="form-control" placeholder="optional"><br>

            <!-- Email -->
            <label class="form-label" for="email">Email:</label><br>
            <input type="email" name="email" id="email" class="form-control" required><br>

            <!-- Password -->
            <label class="form-label" for="password">Password:</label><br>
            <input type="password" name="password" id="password" class="form-control" required><br>

            <!-- COnfirm Password -->
            <div class="form-group">
                <label for="confirm_password">Confirm Password :</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required placeholder="Please confirm your password!">
            </div>

            <!-- Role -->
            <label for="role" class="form-label">Role:</label><br>
            <select name="role" id="role" class="form-select form-control" required>
                <option value="">Choose a Role---</option>
                <option value="admin">Admin</option>
                <option value="member">Member</option>
                <option value="visitor">Visitor</option>
            </select><br>

            <!-- Submit and Reset Buttons -->
            <input type="submit" value="Apply" name="add_user" class="btn btn-warning container p-3 mb-2 fw-bold">
            <input type="reset" value="Reset" class="btn btn-info container"><br>
            <i>Already have an account? <a href="./../../login.php">Log in here</a></i>
        </form>
    </div>
        <div class="col-sm-3 pt-4  border border-2">
            <div class="">
                <div class="card-img-top">
                    <img src="./../../images/icpe group photo_team.jpg" width="200px" height="200px" alt="">
                </div>
            </div>
        </div>
    </div>
</div>   
</div>

    <!-- _______________________MANAGE DONATIONS____________________________________-->
    <div class="tab-pane fade" id="donations" role="tabpanel" aria-labelledby="donations-tab">
        <div class="row mt-5 alert-info">
            <div class="col-sm-4 d-flex p-2 justify-content-center align-items-center border border-2">
                <!-- __________Afficher Tous les Dons__________ -->
                <div class="flex-sm-column text-center">
                    <h1 class="fw-bold mt-4">View All Donations</h1>
                    <button type="button" name="manage_donations" class="btn btn-primary p-3"><a href="./manage_donations.php" class="link text-light fw-bold">Click here</a></button>
                    <div class="mt-2">
                    <img src="./../../images/DONATION_ICON.png" alt="" class="inline-block w-100">
                    </div>
                </div>
            </div>
            <!-- __________Form to add Donation__________ -->
            <div class="flex-sm-column align-items-center col-sm-5 m-3 border border-3 shadows-md">
                <h2><i class="text-center">Make a donation via your preferred method</i></h2>
            <form action="./../process_donation.php" method="post" class="needs-validation">
            <div class="mb-3">
                <label for="donorName" class="form-label">Name</label>
                <input type="text" class="form-control" id="donorName" name="donor_name" required>
                <div class="invalid-feedback">
                    Please enter your name.
                </div>
            </div>

            <div class="mb-3">
                <label for="donorEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="donorEmail" name="donor_email" required>
                <div class="invalid-feedback">
                    Please enter a valid email address.
                </div>
            </div>

            <div class="mb-3">
                <label for="donationAmount" class="form-label">Donation Amount</label>
                <input type="number" class="form-control" id="donationAmount" name="donation_amount" required>
                <div class="invalid-feedback">
                    Please enter a valid donation amount.
                </div>
            </div>

            <h4>Select Payment Method</h4>
            <div class="form-check form-switch">
                <input class="form-check-input" type="radio" name="payment_method" id="creditCard" value="credit_card" required>
                <label class="form-check-label" for="creditCard">
                    Credit Card
                </label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal" required>
                <label class="form-check-label" for="paypal">
                    PayPal
                </label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="radio" name="payment_method" id="bankTransfer" value="bank_transfer" required>
                <label class="form-check-label" for="bankTransfer">
                    Bank Transfer
                </label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="radio" name="payment_method" id="mobileMoney" value="mobile_money" required>
                <label class="form-check-label" for="mobileMoney">
                    Mobile Money (Liberian Operators)
                </label>
            </div>

            <div id="paymentDetails" class="mt-4 bg-info p-3">
                <!-- Payment details will be displayed here based on selected payment method -->
            </div>

            <div class="text-center mb-3">
                <button type="submit" name="ok" class="btn btn-primary mt-3 fw-bold">Donate Now</button>
            </div>
        </form>
        </div>
    </div>
</div>
</article>

<section class="member">
<!-- _______________________Members DASHBOARD____________________________________-->
        <?php else: ?>
            <p>Welcome, <?php echo htmlspecialchars($user['username']); ?> ICPE Member! Explore your content and community options:</p>
            <p>Together for Children: Advocacy, Protection, Empowerment.</p>
            <!-- Member specific content goes here -->
        <?php endif; ?>
</section>

</main>
<script>
        document.querySelectorAll('input[name="payment_method"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                const paymentDetails = document.getElementById('paymentDetails');
                paymentDetails.innerHTML = '';

                if (this.value === 'credit_card') {
                    paymentDetails.innerHTML = `
                        <div class="mb-3">
                            <label for="cardNumber" class="form-label">Card Number</label>
                            <input type="text" class="form-control" id="cardNumber" name="card_number" required>
                            <div class="invalid-feedback">
                                Please enter a valid card number.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="expiryDate" class="form-label">Expiry Date</label>
                            <input type="text" class="form-control" id="expiryDate" name="expiry_date" placeholder="MM/YY" required>
                            <div class="invalid-feedback">
                                Please enter the expiry date.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="cvv" class="form-label">CVV</label>
                            <input type="text" class="form-control" id="cvv" name="cvv" required>
                            <div class="invalid-feedback">
                                Please enter the CVV.
                            </div>
                        </div>
                    `;
                } else if (this.value === 'paypal') {
                    paymentDetails.innerHTML = '<p class="fw-bold text-light">You will be redirected to PayPal to complete your donation.  <br>Click on the button below to continue</p>';
                } else if (this.value === 'bank_transfer') {
                    paymentDetails.innerHTML = `
                        <p class="fw-bold text-light">Please contact an admin for this process :</p>
                        <ul>
                            <li>Phone <img src="./../images/whatsapp.png" width="20px" alt="">: 
                                <a href="https://wa.me/231775609045">+231775609045</a>/
                                <a href="https://wa.me/212632026205">+212632026205</a>
                            </li>
                            <li>Email <img src="./../images/logo gmail.png" width="20px" alt="">: 
                                <a href="mailto:karnleyandrew98@gmail.com">karnleyandrew98@gmail.com</a>/
                                <a href="mailto:icpe2019@gmail.com">icpe2019@gmail.com</a>
                            </li>
                        </ul>
                        `;
                        // <p>Please transfer your donation to the following bank account:</p>
                        // <p><strong>Account Number:</strong> 123456789</p>
                        // <p><strong>Bank Name:</strong> ABC Bank</p>
                        // <p><strong>SWIFT Code:</strong> ABCXYZ</p>
                    
                } else if (this.value === 'mobile_money') {
                    paymentDetails.innerHTML = `
                        <p>Donate via Mobile Money:</p>
                        <p><strong>MTN:</strong> +231 77 560 9045</p>
                        <p><strong>Orange:</strong> +231 .. ... ....</p>
                    `;
                }
            });
        });
</script>

</body>
</html>
