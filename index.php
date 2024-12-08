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
    <title>Welcome to StackHub - Coding Forums</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>

    <?php
    // Display error or success messages
    if (isset($_GET['error'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                ' . htmlspecialchars($_GET['error']) . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
    }
    if (isset($_GET['success'])) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                ' . htmlspecialchars($_GET['success']) . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
    }

    // Initialize category variables
    $catname = "";
    $catdesc = "";

    // Check if 'category_id' is set in the GET request
    if (isset($_GET['category_id'])) {
        // Validate that 'category_id' is a positive integer
        $id = $_GET['category_id'];

        if (filter_var($id, FILTER_VALIDATE_INT) && $id > 0) {
            // Use prepared statements for security
            $id = (int)$id; // Cast to integer after validation

            // Prepare the SQL statement
            $stmt = $conn->prepare("SELECT * FROM `categories` WHERE category_id = ?");
            if ($stmt) {
                $stmt->bind_param("i", $id); // 'i' indicates the parameter type is integer
                $stmt->execute();
                $result = $stmt->get_result();

                // Check if any rows were returned
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $catname = $row['category_name'];
                        $catdesc = $row['category_description'];
                    }
                } else {
                    // Handle the case where no category was found
                    $catname = "Category not found";
                    $catdesc = "";
                }

                $stmt->close();
            } else {
                // Handle SQL preparation error
                $catname = "Database error: Unable to prepare statement.";
                $catdesc = "";
            }
        } else {
            // Handle invalid category ID
            $catname = "Invalid category ID";
            $catdesc = "";
        }
    } else {
        // Handle the case where 'category_id' is not set
        $catname = "Category ID not provided";
        $catdesc = "";
    }
    ?>

    <!-- Slider starts here -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/img1.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/img2.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/img3.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <a class="carousel-control prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- Category container starts here -->
    <div class="container my-4" id="ques">
        <h2 class="text-center my-4">StackHub - Browse Categories</h2>
        <div class="row my-4">
            <!-- Fetch all the categories and use a loop to iterate through categories -->
            <?php 
                $sql = "SELECT * FROM `categories`"; 
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)){
                    $id = $row['category_id'];
                    $cat = $row['category_name'];
                    $desc = $row['category_description'];
                
                    // Assign specific image for each category manually
                    switch($id) {
                        case 1:
                            $imageSrc = 'img/python.jpg';
                            break;
                        case 2:
                            $imageSrc = 'img/javascript.jpg';
                            break;
                        case 3:
                            $imageSrc = 'img/C++.jpg';
                            break;
                        case 4:
                            $imageSrc = 'img/java.jpg';
                            break;
                        case 5:
                            $imageSrc = 'img/react.jpg';
                            break;
                        case 6:
                            $imageSrc = 'img/laravel.jpg';
                            break;        
                        case 7:
                            $imageSrc = 'img/bootstrap.jpg';
                            break;
                        // Add more cases for other categories if needed
                        default:
                            $imageSrc = 'img/default.jpg';
                            break;
                    }
    
                    echo '<div class="col-md-4 my-2">
                            <div class="card" style="width: 18rem;">
                                <img src="' . $imageSrc . '" class="card-img-top" alt="image for this category" style="width: 100%; height: 200px; object-fit: cover;">
                                <div class="card-body" style="height: 190px;">
                                    <h5 class="card-title"><a href="threadlist.php?catid=' . $id . '">' . $cat . '</a></h5>
                                    <p class="card-text">' . substr($desc, 0, 90) . '... </p>
                                    <a href="threadlist.php?catid=' . $id . '" class="btn btn-primary">View Threads</a>
                                </div>
                            </div>
                        </div>';
                } 
            ?>
        </div>
    </div>

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