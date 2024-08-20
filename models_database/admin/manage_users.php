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
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
                            <a class="btn border-primary border-2 me-1 fw-bold" href="./received_messages.php">Messages</a>
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

<!-- /// ////////////////////------MANAGING ADMIN------/////////////// //////////////////// -->  
<h1 class="text-center">List of Administrators</h1>
    <?php
        $sql = "SELECT * FROM users";
        $result = $connex->query($sql);

        if ($result->rowCount() > 0) {
            $adminFound = false; // Variable pour suivre les admins
    
            // Affichage des résultats dans un tableau HTML
            echo "<div class='table-responsive'>";
            echo "<table id='adminTable' class='table table-bordered table-striped border border-3 border-info table-info w-100' style='width: 100%;'>";
            echo "<thead class='table-dark'>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>First_Name</th>";
            echo "<th>Last_Name</th>";
            echo "<th>Username</th>";
            echo "<th>Email</th>";
            echo "<th>Role</th>";
            echo "<th>Created_at</th>";
            echo "<th style='display: none;'>Password</th>";
            echo "<th>🔒Action</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
    
            // Affichage des lignes de résultats
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if ($row['role'] === 'admin') {
                    $adminFound = true; // Un visiteur a été trouvé
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";

                    echo "<td class='fw-bold'>" . htmlspecialchars($row['role']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                    echo "<td style='display: none;'>" . htmlspecialchars($row['password']) . "</td>";
                    echo "<td>
                            <button class='btn btn-success m-1' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasRight' data-id='".htmlspecialchars($row['id'])."' aria-controls='offcanvasRight'>
                                &#128221; Update
                            </button>&nbsp;
                            <button class='btn btn-danger m-1' type='button' data-bs-toggle='modal' data-bs-target='#deleteModal' data-id='".htmlspecialchars($row['id'])."'>
                                &#129529; Delete
                            </button>
                        </td>";
                    echo "</tr>";
                }
            }

            // Si aucun admin n'a été trouvé
            if (!$adminFound) {
                echo "<tr><td colspan='8' class='text-center'>No visitors found.</td></tr>";
            }
            echo "</tbody>";
            echo "<caption style='caption-side:bottom; text-align:center;'><button class='p-3 alert-warning' onclick='printTableA()'>🖨Print</button></caption>";
            echo "</table>";
            echo "</div>";
        } else {
            echo "<tr><td colspan='8'>User not found.</td></tr>";
        }
    ?>
<!-- /// ////////////////////------MANAGING MEMBERS------/////////////// //////////////////// -->  
<h1 class="text-center">List of Members</h1>
    <?php
        $sql = "SELECT * FROM users";
        $result = $connex->query($sql);

        if ($result->rowCount() > 0) {
            $memberFound = false; // Variable pour suivre les members
    
            // Affichage des résultats dans un tableau HTML
            echo "<div class='table-responsive'>";
            echo "<table id='memberTable' class='table table-bordered table-striped border border-3 border-info table-info w-100' style='width: 100%;'>";
            echo "<thead class='table-dark'>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>First_Name</th>";
            echo "<th>Last_Name</th>";
            echo "<th>Username</th>";
            echo "<th>Email</th>";
            echo "<th>Role</th>";
            echo "<th>Created_at</th>";
            echo "<th style='display: none;'>Password</th>";
            echo "<th>🔒Action</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
    
            // Affichage des lignes de résultats
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if ($row['role'] === 'member') {
                    $memberFound = true; // Un member a été trouvé
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";

                    echo "<td class='fw-bold'>" . htmlspecialchars($row['role']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                    echo "<td style='display: none;'>" . htmlspecialchars($row['password']) . "</td>";
                    echo "<td>
                            <button class='btn btn-success m-1' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasRight' data-id='".htmlspecialchars($row['id'])."' aria-controls='offcanvasRight'>
                                &#128221; Update
                            </button>&nbsp;
                            <button class='btn btn-danger m-1' type='button' data-bs-toggle='modal' data-bs-target='#deleteModal' data-id='".htmlspecialchars($row['id'])."'>
                                &#129529; Delete
                            </button>
                        </td>";
                    echo "</tr>";
                }
            }

            // Si aucun member n'a été trouvé
            if (!$memberFound) {
                echo "<tr><td colspan='8' class='text-center'>No visitors found.</td></tr>";
            }
            echo "</tbody>";
            echo "<caption style='caption-side:bottom; text-align:center;'><button class='p-3 alert-warning' onclick='printTableM()'>🖨Print</button></caption>";
            echo "</table>";
            echo "</div>";
        } else {
            echo "<tr><td colspan='8'>User not found.</td></tr>";
        }
    ?>
<!-- /// ////////////////////------MANAGING Visitors------/////////////// //////////////////// -->  
    <h1 class="text-center">List of Visitors</h1>
    <?php
        $sql = "SELECT * FROM users";
        $result = $connex->query($sql);

        if ($result->rowCount() > 0) {
            $visitorFound = false; // Variable pour suivre les visiteurs
    
            // Affichage des résultats dans un tableau HTML
            echo "<div class='table-responsive'>";
            echo "<table id='visitorTable' class='table table-bordered table-striped border border-3 border-info table-info w-100' style='width: 100%;'>";
            echo "<thead class='table-dark'>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>First_Name</th>";
            echo "<th>Last_Name</th>";
            echo "<th>Username</th>";
            echo "<th>Email</th>";
            echo "<th>Role</th>";
            echo "<th>Created_at</th>";
            echo "<th style='display: none;'>Password</th>";
            echo "<th>🔒Action</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
    
            // Affichage des lignes de résultats
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if ($row['role'] === 'visitor') {
                    $visitorFound = true; // Un visiteur a été trouvé
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";

                    echo "<td class='fw-bold'>" . htmlspecialchars($row['role']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                    echo "<td style='display: none;'>" . htmlspecialchars($row['password']) . "</td>";
                    echo "<td>
                            <button class='btn btn-success m-1' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasRight' data-id='".htmlspecialchars($row['id'])."' aria-controls='offcanvasRight'>
                                &#128221; Update
                            </button>&nbsp;
                            <button class='btn btn-danger m-1' type='button' data-bs-toggle='modal' data-bs-target='#deleteModal' data-id='".htmlspecialchars($row['id'])."'>
                                &#129529; Delete
                            </button>
                        </td>";
                    echo "</tr>";
                }
            }

            // Si aucun visiteur n'a été trouvé
            if (!$visitorFound) {
                echo "<tr><td colspan='8' class='text-center'>No visitors found.</td></tr>";
            }
            echo "</tbody>";
            echo "<caption style='caption-side:bottom; text-align:center;'><button class='p-3 alert-warning' onclick='printTableV()'>🖨Print</button></caption>";
            echo "</table>";
            echo "</div>";
        } else {
            echo "<tr><td colspan='8'>User not found.</td></tr>";
        }
    ?>

<!-- OFFCANVAS RIGHT for Users -->
<div class="offcanvas offcanvas-end bg-info" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h2 class="offcanvas-title" id="offcanvasRightLabel">Update User</h2>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <form method="post" action="./update_user.php" enctype="multipart/form-data" class="was-validated">
        <input type="hidden" name="update_id" id="update_id">
        <form action="" method="post" class="was-validated container m-5">
            <!-- First Name -->
            <label class="form-label" for="first_name">First Name:</label><br>
            <input type="text" name="update_first_name" id="update_first_name" class="form-control" required><br>
            
            <!-- Last Name -->
            <label class="form-label" for="last_name">Last Name:</label><br>
            <input type="text" name="update_last_name" id="update_last_name" class="form-control" required><br>

            <!-- Username -->
            <label class="form-label" for="username">Username:</label><br>
            <input type="text" name="update_username" id="update_username" class="form-control" placeholder="optional"><br>

            <!-- Email -->
            <label class="form-label" for="email">Email:</label><br>
            <input type="email" name="update_email" id="update_email" class="form-control" required><br>


            <!-- Password Field -->
            <label class="form-label" for="password">Password:</label><br>
            <div class="input-group">
                <input type="password" name="update_password" id="update_password" class="form-control" required>
                <span class="input-group-text eye-icon"  style="cursor: pointer;">
                    <i class="fa fa-eye-slash" id="toggleUpdatePassword"></i>
                </span> <!-- Icône d'œil -->
            </div>
            <div class="invalidated text-danger">Please Change the password in this field!</div><br>

            <!-- Role -->
            <label for="role" class="form-label">Role:</label><br>
            <select name="update_role" id="update_role" class="form-select form-control">
                <option value="admin">Admin</option>
                <option value="member">Member</option>
                <option value="visitor">Visitor</option>
            </select><br>
            <div class="invalidated text-danger">Before saving the changes, make sure you fill the right password!</div>
        <button type="submit" class="btn btn-primary fw-bold" name="update_user">Save changes</button>
    </form>
  </div>
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
        Are you sure you want to delete this user?
      </div>
      <div class="modal-footer">
        <form method="post" action="./delete_user.php">
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

<!-- ____Add new member____________ -->
<section  class="alert-info p-5">
<div class="row p-2">
    <h2><i>Fill out new user information</i></h2>
    <div class="container col-sm p-5 pt-0">
        <form action="./add_user.php" method="post" class="was-validated container m-5">
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
    <div class="col-sm-6">
        <div class="card mt-5 alert-info">
            <div class="card-img">
                <img src="./../../images/icpe group photo_team.jpg" width="300px" height="300px" alt="">
            </div>
        </div>
    </div>
</div>
</section>

<script>
   // /// <!-- _____JAVASCRIPT to handle the dynamic data in modals and offcanvas__________________ -->
   
    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var InputDeleteId = deleteModal.querySelector('#delete_id');
        InputDeleteId.value = id;
    });

    var offcanvasRight = document.getElementById('offcanvasRight');
    offcanvasRight.addEventListener('show.bs.offcanvas', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var updateId = offcanvasRight.querySelector('#update_id');
        updateId.value = id;

        // Fetch post details using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'fetch_user.php?id=' + id, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                var post = JSON.parse(xhr.responseText);
                document.getElementById('update_first_name').value = post.first_name;
                document.getElementById('update_last_name').value = post.last_name;
                document.getElementById('update_username').value = post.username;
                document.getElementById('update_email').value = post.email;
                document.getElementById('update_password').value = post.password;
                document.getElementById('update_role').value = post.role;
            } else {
                console.log('Failed to fetch post details.');
            }
        };
        xhr.send('id=' + id);
    });

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

    document.getElementById('toggleUpdatePassword').addEventListener('click', function() {
        togglePasswordVisibility('update_password', 'toggleUpdatePassword');
    });

    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        togglePasswordVisibility('confirm_password', 'toggleConfirmPassword');
    });


// IMPRESSION DU TABLE VISITOR
    function printTableV() {
    // Sélectionnez le tableau à imprimer
    var table = document.getElementById('visitorTable');

    // Créez une nouvelle fenêtre pour l'impression
    var printWindow = window.open('', '', 'height=600,width=800');

    // Ajoutez le contenu HTML de la table dans la nouvelle fenêtre
    printWindow.document.write('<html><head><title>List Visitors</title>');
    printWindow.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">'); // Lien vers Bootstrap pour le style
    printWindow.document.write('</head><body>');
    printWindow.document.write(table.outerHTML);
    printWindow.document.write('</body></html>');

    // Fermez le document pour finir d'écrire le contenu
    printWindow.document.close();

    // Attendez que le contenu soit chargé, puis lancez l'impression
    printWindow.onload = function() {
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    };
}


// IMPRESSION DU TABLE MEMBER
function printTableM() {
    // Sélectionnez le tableau à imprimer
    var table = document.getElementById('memberTable');

    // Créez une nouvelle fenêtre pour l'impression
    var printWindow = window.open('', '', 'height=600,width=800');

    // Ajoutez le contenu HTML de la table dans la nouvelle fenêtre
    printWindow.document.write('<html><head><title>List Members</title>');
    printWindow.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">'); // Lien vers Bootstrap pour le style
    printWindow.document.write('</head><body>');
    printWindow.document.write(table.outerHTML);
    printWindow.document.write('</body></html>');

    // Fermez le document pour finir d'écrire le contenu
    printWindow.document.close();

    // Attendez que le contenu soit chargé, puis lancez l'impression
    printWindow.onload = function() {
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    };
}
 

function printTableA() {
    // Sélectionnez le tableau à imprimer
    var table = document.getElementById('adminTable');

    // Créez une nouvelle fenêtre pour l'impression
    var printWindow = window.open('', '', 'height=600,width=800');

    // Ajoutez le contenu HTML de la table dans la nouvelle fenêtre
    printWindow.document.write('<html><head><title>List Administrators</title>');
    printWindow.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">'); // Lien vers Bootstrap pour le style
    printWindow.document.write('</head><body>');
    printWindow.document.write(table.outerHTML);
    printWindow.document.write('</body></html>');

    // Fermez le document pour finir d'écrire le contenu
    printWindow.document.close();

    // Attendez que le contenu soit chargé, puis lancez l'impression
    printWindow.onload = function() {
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    };
}

</script>
</body>
</html>
