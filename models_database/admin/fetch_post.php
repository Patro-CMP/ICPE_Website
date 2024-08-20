<?php
// Database connection
include './../../includes/connect.php'; // Adjust this to your actual database connection file

// Set header to return JSON
header('Content-Type: application/json');

// Check if ID is provided
if (isset($_POST['id'])) {
    $id = intval($_POST['id']); // Sanitize input
    
    // Prepare and execute the query
    $stmt = $connex->prepare("SELECT * FROM posts WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the result
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($post) {
        // Return JSON response
        echo json_encode($post);
    } else {
        // No post found
        echo json_encode(['error' => 'Post not found']);
    }
} else {
    // No ID provided
    echo json_encode(['error' => 'No ID provided']);
}
?>
