<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
        #ques {
            min-height: 433px;
        }
    </style>
    <title>StackHub - Coding Forums</title>
</head>

<body>
    <?php 
    session_start(); // Start the session
    include 'partials/_dbconnect.php';
    include 'partials/_header.php';
    ?>

    <?php
include 'partials/_dbconnect.php';

// Check if thread_id is set in the URL
if (!isset($_GET['thread_id'])) {
    header("Location: threadlist.php"); // Redirect to thread list if no thread ID is provided
    exit();
}

$threadId = htmlspecialchars($_GET['thread_id']);

// Fetch thread details from the database
$stmt = $conn->prepare("SELECT * FROM `threads` WHERE `thread_id` = ?");
$stmt->bind_param("i", $threadId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<h2>Thread not found.</h2>";
    exit();
}

$thread = $result->fetch_assoc();
$threadTitle = htmlspecialchars($thread['thread_title']);
$threadDesc = htmlspecialchars($thread['thread_desc']);

// Handle comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment = htmlspecialchars($_POST['comment']);

    // Insert comment into the database
    $stmt = $conn->prepare("INSERT INTO `comments` (`thread_id`, `comment`) VALUES (?, ?)");
    $stmt->bind_param("is", $threadId, $comment);
    if ($stmt->execute()) {
        // Display the success message with a button to go back
        echo '
        <div class="alert alert-success text-center mt-3" role="alert">
            <h4 class="alert-heading">🎉 Comment Submitted Successfully!</h4>
            <p>Your comment has been submitted successfully. Get back to the previous page to see your comment!</p>
            <button class="btn btn-primary mt-2" onclick="window.history.back();">Go Back</button>
        </div>';
        
        // Optionally redirect after a short delay if needed
        @header("Refresh: 5; URL=comment.php?thread_id=" . $threadId);
        exit();
    }
    
    }

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <title><?php echo $threadTitle; ?></title>
</head>
<body>
<div class="container my-4">
    <h1><?php echo $threadTitle; ?></h1>
    <p><?php echo $threadDesc; ?></p>
    <hr>
    
    <h3>Leave a Comment:</h3>
    <form method="POST">
        <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Reply</button>
    </form>
    
    <hr>
    <h3>Comments:</h3>
    <div id="commentsSection">
        <?php
        // Fetch comments for this thread
        $stmt = $conn->prepare("SELECT * FROM `comments` WHERE `thread_id` = ? ORDER BY comment_id DESC");
        $stmt->bind_param("i", $threadId);
        $stmt->execute();
        $commentsResult = $stmt->get_result();

        if ($commentsResult->num_rows > 0) {
            while ($comment = $commentsResult->fetch_assoc()) {
                echo "<p>" . htmlspecialchars($comment['comment']) . "</p><hr>";
            }
        } else {
            echo "<p>No comments yet.</p>";
        }
        ?>
    </div>
</div>
</body>
</html>

    <?php include 'partials/_footer.php'; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
</body>

</html>