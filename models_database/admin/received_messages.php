<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ./index.php");
    exit();
}
include '../../includes/connect.php';

// Récupération des messages de la base de données
$stmt = $connex->prepare("SELECT * FROM messages ORDER BY id DESC");
$stmt->execute();

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Messages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./../../others_pages/style. css">
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
                            <a class="btn  border-primary border-2 me-1 fw-bold" href="./manage_donations.php">Donations</a>
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
<main>
    <div class="container mt-5">
        <h2 class="text-center">Messages Received</h2>
        <table class="table table-bordered border border-2 table-striped table-warning table-hover">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message): ?>
                    <tr>
                        <td class="fw-bold"><?= htmlspecialchars($message['email']) ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($message['subject']) ?></td>
                        <td><?= htmlspecialchars($message['message']) ?></td>
                        <td>
                            <form action="./delete_message.php" method="post">
                                <input type="hidden" name="id" value="<?= $message['id'] ?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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

</main>
</body>
</html>