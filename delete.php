<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include('db_connection.php'); // ✅ Database connection

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // Sanitize input to prevent SQL injection
    $post_id = mysqli_real_escape_string($connection, $post_id);

    $query = "DELETE FROM posts WHERE id = $post_id";
    
    if (mysqli_query($connection, $query)) {
        header("Location: list_posts.php");
        exit();
    } else {
        echo "Error deleting post: " . mysqli_error($connection);
    }
} else {
    echo "No post ID provided!";
}
?>
``
