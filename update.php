<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Connect to the database
$conn = new mysqli("localhost", "root", "", "blog");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted (POST request)
if (isset($_POST['update'])) {
    $id = $_POST['id']; // Hidden field with post ID
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Update the post in the database
    $sql = "UPDATE posts SET title='$title', content='$content' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Post updated successfully! <a href='index.php'>Go back to all posts</a>";
    } else {
        echo "Error updating post: " . $conn->error;
    }
}

// If there's an ID in the URL (GET request), fetch that post
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get the post from the database
    $sql = "SELECT * FROM posts WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc(); // Fetch one post
    } else {
        echo "Post not found.";
        exit;
    }
} else {
    echo "No post ID provided.";
    exit;
}

$conn->close();
?>

<!-- HTML Form to edit the post -->
<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
</head>
<body>
    <h2>Edit Post</h2>
    <form method="POST" action="edit_post.php">
        <!-- Hidden field to send ID -->
        <input type="hidden" name="id" value="<?php echo $post['id']; ?>">

        <label>Title:</label><br>
        <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required><br><br>

        <label>Content:</label><br>
        <textarea name="content" rows="5" cols="40" required><?php echo htmlspecialchars($post['content']); ?></textarea><br><br>

        <input type="submit" name="update" value="Update Post">
    </form>
</body>
</html>
