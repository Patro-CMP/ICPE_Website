<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donations - ICPE, Non-Profit Organization</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./../others_pages/style.css">
</head>
<body>
<!-- /// ////////////////////------HEADER------/////////////// //////////////////// -->
    <header>
        <?php include "./../includes/header.php"; ?>
    </header>

<!-- /// ////////////////////------MAIN------/////////////// //////////////////// -->
    <main style="margin-top: 100px;">
    <div class="container row justify-content-center">
        <div class="alert-info">
            <h2 class="text-center">Support Our Cause</h2>
            <p class="text-center">Make a donation via your preferred method</p>
        </div>

        <div class="flex-sm-column align-items-center col-sm-5 mt-3 border border-3 shadows-md">
        <form action="./../models_database/process_donation.php" method="post" class="needs-validation">
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
</main>
<!-- /// ////////////////////------FOOTER------/////////////// //////////////////// -->
    <footer>
        <div class="row m-3">
            <div class="col-sm-4">
                <img src="./../images/Don.png" alt="" class="inline-block w-100">
            </div>
            <div class="col-sm-4">
                <img src="./../images/donations...........4.jpeg" alt="" class="inline-block w-100">
            </div>
            <div class="col-sm-4">
                <img src="./../images/donations...........5.jpeg" alt="" class="inline-block w-100">
            </div>
        </div>
        <?php include "./../includes/footer.php"; ?>
    </footer>
<!-- /// ////////////////////------SCRIPT JS------/////////////// //////////////////// -->
    <script src="./../others_pages/javascript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>
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
                        <p><strong>MTN:</strong> +231 88 021 2204</p>
                        <p><strong>Orange:</strong>  +231 77 560 9045</p>
                    `;
                }
            });
        });
    </script>
</body>
</html>
