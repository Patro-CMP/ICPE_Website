<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Assuming a database connection has been established
    include './../../includes/connect.php';

    $stmt = $connex->prepare("DELETE FROM donations WHERE id = :id");
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "<script>alert('Donation deleted successfully.'); window.location.href = './manage_donations.php';</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.'); window.location.href = './manage_donations.php';</script>";
    }
}
?>
