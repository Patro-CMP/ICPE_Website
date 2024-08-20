<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ./index.php");
    exit();
}
include '../../includes/connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Donations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./../others_pages/style.css">
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
    </style>
</head>
<body>
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
                            <a class="btn  border-primary border-2 me-1 fw-bold" href="./received_messages.php">Messages</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn alert-secondary border-primary border-2 me-1 fw-bold" href="./index.php" target="_top">Dashboard</a>
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
    <main style="margin-top: 100px;">
    <div class="container mt-5">
        <h2 class="text-center">Manage Donations</h2>

        <table class="table table-bordered table-striped mt-4">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Donor Name</th>
                    <th>Email</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetching donation records from the database
                $stmt = $connex->prepare("SELECT * FROM donations ORDER BY id DESC");
                $stmt->execute();
                $donations = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($donations as $donation) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($donation['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($donation['donor_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($donation['donor_email']) . "</td>";
                    echo "<td class='fw-bold'>" . htmlspecialchars($donation['amount']) . "</td>";
                    echo "<td>" . htmlspecialchars($donation['payment_method']) . "</td>";
                    echo "<td>
                            <button class='btn btn-danger btn-sm' type='button' data-bs-toggle='modal' data-bs-target='#deleteModal' data-id='".htmlspecialchars($donation['id'])."'>
                                &#129529; Delete
                            </button>
                          </td>";
                    echo "</tr>";      
                        //   <form method='post' action='./delete_donation.php' class='d-inline'>
                        //     <input type='hidden' name='id' value='" . $donation['id'] . "'>
                        //     <button type='submit' name='ok' class='btn btn-danger btn-sm'>Delete</button>
                        //   </form>
                }
                ?>
            </tbody>
        </table>

        <h4>Total Donations: <?php
            $stmt = $connex->prepare("SELECT SUM(amount) as total FROM donations");
            $stmt->execute();
            $total = $stmt->fetch(PDO::FETCH_ASSOC);
            echo htmlspecialchars($total['total']);
        ?> </h4>
    </div>

<!-- MODAL for Delete Confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this donation ?
      </div>
      <div class="modal-footer">
        <form method="post" action="./delete_donation.php">
            <input type="hidden" name="delete_id" id="delete_id">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger" name="confirm_delete">Delete</button>
        </form>
      </div>
    </div>
  </div>
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

</main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>
    <script>
        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var InputDeleteId = deleteModal.querySelector('#delete_id');
            InputDeleteId.value = id;
        });

        // Pour le form de donations
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
