<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $donationAmount = $_POST['donation_amount'];
    $donorName = $_POST['donor_name'];
    $donorEmail = $_POST['donor_email'];
    $paymentMethod = $_POST['payment_method'];

    // Assuming a database connection has been established
    include './../includes/connect.php';

    // Insert donation into the database
    $stmt = $connex->prepare("INSERT INTO donations (amount, donor_name, donor_email, payment_method) VALUES (:amount, :donor_name, :donor_email, :payment_method)");
    $stmt->bindParam(':amount', $donationAmount);
    $stmt->bindParam(':donor_name', $donorName);
    $stmt->bindParam(':donor_email', $donorEmail);
    $stmt->bindParam(':payment_method', $paymentMethod);

    if ($stmt->execute()) {
        echo "<script>alert('Thank you for your donation!'); window.location.href = './../Public_View_Pages/donations.php';</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.'); window.location.href = './../Public_View_Pages/donations.php';</script>";
    }
}
?>
