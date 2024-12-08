<?php
include 'partials/_dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment = $_POST['comment'];
    $thread_id = $_POST['thread_id'];
    $user_id = $_POST['user_id'];

    // Escape special characters to prevent XSS
    $comment = str_replace("<", "&lt;", $comment);
    $comment = str_replace(">", "&gt;", $comment);

    // Insert comment into the database
    $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_time`) 
    VALUES ('$comment_content', '$thread_id', current_timestamp())";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: threadlist.php?catid=" . $_GET['catid']);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
