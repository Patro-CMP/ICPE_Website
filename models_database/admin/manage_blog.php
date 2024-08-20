<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ./index.php");
    exit();
}
include './../../includes/connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display_blog</title>
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
                            <a class="btn border-primary border-2 me-1 fw-bold" href="./received_messages.php">Messages</a>
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

<!-- _________Displaying Posts______________________________ -->
<div class="table-responsive" id="table-responsive">
    <h1 class="text-center">All the Posts Saved</h1>
    <table class="table table-bordered table-striped border border-3 border-info table-info">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Media Path</th>
                <th>Media</th>
                <th>Comment</th>
                <th>Date</th>
                <th>Admin Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
    <?php
        // Requête SQL pour récupérer les posts avec les informations de l'utilisateur
        $sql = "SELECT post.*, user.username 
        FROM posts post
        INNER JOIN users user ON post.author_id = user.id
        ORDER BY post.created_at DESC";
        $result = $connex->query($sql);
        while ($row = $result->fetch()) {
            if ($row !=null) {
                echo "<tr class='border border-2 border-info'>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                echo "<td>" . htmlspecialchars($row['media']) . "</td>";

                // Vérifier le type de média et l'afficher
                $media_path = './../uploads/'.htmlspecialchars($row['media']);
                if (!empty($row['media'])) {
                    if (preg_match('/\.(jpeg|jpg|png|gif)$/i', $row['media'])) {
                        echo '<td><img src="'.$media_path.'" class="card-img" alt="'.htmlspecialchars($row['title']).'"></td>';
                    } elseif (preg_match('/\.(mp4|avi|mov|mkv)$/i', $row['media'])) {
                        echo '<td><video controls class="card-img-top">';
                        echo '<source src="'.$media_path.'" type="video/mp4">';
                        echo 'Your browser does not support videos.';
                        echo '</video></td>';
                    } else {
                        echo '<td>No media available</td>';
                    }
                } else {
                    echo '<td>No media available</td>';
                }

                echo "<td>" . htmlspecialchars($row['comment']) . "</td>";
                echo "<td>" . date("Y-m-d", strtotime($row['created_at'])) . "</td>";
                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                echo "<td>
                        <button class='btn btn-success' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasRight' data-id='".htmlspecialchars($row['id'])."' data-media='".htmlspecialchars($row['media'])."' data-date='".date("Y-m-d", strtotime($row['created_at']))."' aria-controls='offcanvasRight'>
                            &#128221; Update
                        </button>&nbsp;
                        <button class='btn btn-danger' type='button' data-bs-toggle='modal' data-bs-target='#deleteModal' data-id='".htmlspecialchars($row['id'])."'>
                            &#129529; Delete
                        </button>
                    </td>";
                echo "</tr>";
            }else {
                echo "<tr colspan='8'>No Post Saved ! Please add new post</tr>";
            }
        }
    ?>
        </tbody>
    </table>
</div>

<!-- OFFCANVAS RIGHT for Update -->
<div class="offcanvas offcanvas-end bg-info" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h2 class="offcanvas-title" id="offcanvasRightLabel">Update Post</h2>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <form method="post" action="./update_post.php" enctype="multipart/form-data">
        <input type="hidden" name="update_id" id="update_id">
        <div class="mb-3">
            <label for="update_title" class="form-label">Title</label>
            <input type="text" class="form-control" id="update_title" name="update_title">
        </div>
        <div class="mb-3">
            <label for="update_comment" class="form-label">Comment</label>
            <textarea class="form-control" id="update_comment" name="update_comment" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="current_media" class="form-label">🏷 Current Media Name:</label>
            <div id="">
                <input type="text" name="current_media" id="current_media" readonly>
                <!-- Media preview will be shown here -->
            </div><br>
            <label for="update_media" class="form-label">Choose File:</label>
            <input type="file" class="form-control" id="update_media" name="update_media" required>
        </div>
        <div class="mb-3">
            🏷 Current Date for this post<br>
            <input type="text" id="current_date" name="current_date" readonly><br><br>
            <label for="update_date" class="form-label">Change Date or Enter the current date:</label>
            <input type="date" class="form-control" id="update_date" name="update_date" required>
        </div>
        <button type="submit" class="btn btn-primary fw-bold" name="update_post">Save changes</button>
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
        Are you sure you want to delete this post?
      </div>
      <div class="modal-footer">
        <form method="post" action="./delete_post.php">
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

<!-- ______Add to Blog_________________ -->
<div class="row mt-5 alert-info">
    <div class="col-sm-4 d-flex p-2 justify-content-center align-items-center border border-2">
        <!-- __________Afficher Modifier Supprimer Blog__________ -->
        <div class="flex-sm-column text-center">
            <h1 class="fw-bold mt-4">Explore Blog</h1>
            <button type="button" name="display_blog" class="btn btn-primary p-3"><a href="#table-responsive" class="link text-light fw-bold">View All Posts</a></button>
        </div>
    </div>
    <!-- __________Form to add Blog__________ -->
    <div class="col-sm-6 flex-sm-column justify-content-center align-items-center m-1">
        <h1 class="text-center fw-bold">Add to Blog</h1>
        <h3 class="text-center fw-bold"><i>Post an image <cite>[format(jpeg|jpg|png|gif)]</cite> <br> Or a video <cite>[format(mp4|avi|mov|mkv)]</cite></i></h3>
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
                <label for="media" class="form-label">Add IMAGE or VIDEO :</label><br>
                <input type="file" class="form-control-file" id="media" name="media" accept="image/*,video/*">
            </div><br>
            <div class="form-group">
                <label for="date" class="form-label">Date (DD-MM-YYYY):</label>
                <input type="date" class="form-control" id="date" name="date">
            </div><br>
            <button type="submit" name="ok" class="btn btn-primary form-control fw-bold">Add to blog</button>
        </form>
    </div>
</div>

<!-- _____JAVASCRIPT to handle the dynamic data in modals and offcanvas__________________ -->
<script>
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
        var media = button.getAttribute('data-media');
        var date = button.getAttribute('data-date');

        var updateId = offcanvasRight.querySelector('#update_id');
        var updateMedia = offcanvasRight.querySelector('#current_media');
        var updateDate = offcanvasRight.querySelector('#current_date');

        updateId.value = id;
        updateMedia.value = media;
        updateDate.value = date;
        // Fetch post details using AJAX to populate the form
        // This would require additional implementation on the server to handle the AJAX request

        // Fetch post details using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'fetch_post.php?id=' + id, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                var post = JSON.parse(xhr.responseText);
                document.getElementById('update_title').value = post.title;
                document.getElementById('update_comment').value = post.comment;
                // document.getElementById('update_media').value = post.media;
                // document.getElementById('update_date').value = post.created_at;
            } else {
                console.log('Failed to fetch post details.');
            }
        };
        xhr.send('id=' + id + '&media=' + media + '&date=' + date);
    });

</script>
</body>
</html>