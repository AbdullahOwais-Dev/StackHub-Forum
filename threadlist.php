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
              body {
        background-color: #f8f9fa; /* Light background color */
        font-family: 'Arial', sans-serif; /* Change font */
      }
      .form-group label {
        font-weight: bold;
        color: #333; /* Darker text for labels */
      }
      .form-control {
        border-radius: 4px; /* Rounded borders on input fields */
        border: 1px solid #ced4da; /* Light border color */
        height: 45px; /* Set default height for most fields */
      }
      .form-control:focus {
        border-color: #007bff; /* Blue border on focus */
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.25); /* Blue glow effect on focus */
      }
      /* Increased height for Explanation field */
      #explaination {
        height: 120px;
      }
      .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 12px 20px;
        font-size: 18px;
      }
      .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
      }
      .form-group {
        margin-bottom: 20px; 
      }
        #ques {
            min-height: 433px;
        }
    </style>
    <title>Welcome to StackHub - Coding Forums</title>
</head>

<body>
<?php
include 'partials/_dbconnect.php';
include 'partials/_header.php';

// Fetch all threads from the database
$stmt = $conn->prepare("SELECT * FROM `threads`");
$stmt->execute();
$result = $stmt->get_result();

?>

<div class="container my-4">
    <h1 class="py-0 my-0 text-center">Ask a New Question</h1>
    <form action="submit_question.php" method="POST">
    <div class="form-group">
        <label for="questionTitle">Question Title</label>
        <input type="text" class="form-control" id="questionTitle" name="questionTitle" required>
    </div>
    <div class="form-group">
        <label for="questionDesc">Question Description</label>
        <textarea class="form-control" id="questionDesc" name="questionDesc" rows="4" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit Question</button>
</form>

    <br>
    <hr>
    <h1 class="py-0 my-0 text-center">All Threads</h1><hr>
    <div class="row">
        <?php
        // Check if there are threads and loop through them
        if ($result->num_rows > 0) {
            while ($thread = $result->fetch_assoc()) {
                $threadId = htmlspecialchars($thread['thread_id']);
                $threadTitle = htmlspecialchars($thread['thread_title']);
                $threadDesc = htmlspecialchars($thread['thread_desc']);
                ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title"><?php echo $threadTitle; ?></h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?php echo $threadDesc; ?></p><br><hr>
<button class="btn btn-primary" onclick="location.href='comment.php?thread_id=<?php echo $threadId; ?>'">Reply Thread</button>                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p>No threads available.</p>';
        }
        ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="threadModal" tabindex="-1" role="dialog" aria-labelledby="threadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="threadModalLabel">Thread Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 id="modalThreadTitle"></h5>
                <p id="modalThreadDesc"></p>
                <h6>Answers:</h6>
                <div id="modalAnswers"></div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include 'partials/_footer.php'; ?>

<!-- Optional JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybQXTx4fvhHAm5J1awBEdku9KALvrPgYrJ3uu7MBr1jpz9FQR" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOUb1rKFtFmx3IW1E1nUkhba7EOgpgAzH14z9a7EIYwE+ts" crossorigin="anonymous"></script>

<script>
$(document).ready(function() {
    // When the modal is about to be shown
    $('#threadModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var threadId = button.data('threadid'); // Extract info from data-* attributes

        // AJAX request to fetch thread details and answers
        $.ajax({
            url: 'fetch_thread.php', // Create this PHP file to fetch thread data
            type: 'GET',
            data: { thread_id: threadId },
            success: function(data) {
                var threadData = JSON.parse(data);
                $('#modalThreadTitle').text(threadData.title);
                $('#modalThreadDesc').text(threadData.description);
                $('#modalAnswers').empty(); // Clear previous answers

                // Append answers to the modal
                if (threadData .answers.length > 0) {
                    threadData.answers.forEach(function(answer) {
                        $('#modalAnswers').append('<p>' + answer + '</p>');
                    });
                } else {
                    $('#modalAnswers').append('<p>No answers available.</p>');
                }
            },
            error: function() {
                $('#modalAnswers').append('<p>Error fetching thread details.</p>');
            }
        });
    });
});
</script>