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

    // Initialize variables to hold error messages
    $errorMessage = "";

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the question title and description from the form and sanitize input
        $questionTitle = trim($_POST['questionTitle']);
        $questionDesc = trim($_POST['questionDesc']);

        // Validate input (you may want to add more validation)
        if (empty($questionTitle) || empty($questionDesc)) {
            $errorMessage = "Both fields are required.";
        } elseif (strlen($questionTitle) > 255) {
            $errorMessage = "Question title cannot exceed 255 characters.";
        } elseif (strlen($questionDesc) > 65535) {
            $errorMessage = "Question description cannot exceed 65535 characters.";
        }

        // If no validation errors, proceed to prepare and execute the statement
        if (empty($errorMessage)) {
            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO threads (thread_title, thread_desc) VALUES (?, ?)");
            if ($stmt) {
                $stmt->bind_param("ss", $questionTitle, $questionDesc);

                    // Redirect to the thread list page after successful submission
                    if ($stmt->execute()) {
                        // Display success message before redirection
                        echo '<div class="alert alert-success text-center mt-3" role="alert">';
                        echo '<h4 class="alert-heading">🎉 Question Added Successfully!</h4>';
                        echo '<p>The question has been added successfully. Get back to the previous page to view the question!</p>';
                        echo '<button class="btn btn-primary mt-2" onclick="window.history.back();">Go Back</button>';
                        echo '</div>';
                        
                        // Redirect to the thread list page after displaying the message
                        @header("Refresh: 5; URL=threadlist.php"); // Redirect after 5 seconds
                        exit();
                    }
                    
                    exit();
                } else {
                    $errorMessage = "Error: " . $stmt->error;
                }

                // Close the statement
                $stmt->close();
            } else {
                $errorMessage = "Error preparing statement: " . $conn->error;
            }
        }
    

    // Close the database connection
    $conn->close();
    ?>

    <!-- Display error message if exists -->
    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>

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