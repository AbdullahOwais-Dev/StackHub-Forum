<?php
// Start session if not already started
session_start();
include 'partials/_dbconnect.php'; // Database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - StackHub Forum</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Custom Styles -->
    
    <style>
        .card{
            border: 2px solid black;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<?php include 'partials/_header.php'; ?>

<!-- Main Section -->
<div class="container my-5">
    <h1 class="text-center mb-4">About StackHub Forum</h1>

    <div class="row">
        <!-- Introduction Section -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Welcome to StackHub</h3>
                    <p class="card-text">StackHub is an interactive and user-friendly forum dedicated to helping developers, programmers, and tech enthusiasts collaborate, learn, and grow in the world of coding. Our community thrives on sharing knowledge and offering solutions to programming challenges.</p>
                    <p class="card-text">Whether you're just starting out with coding or are a seasoned developer, you'll find valuable insights and support here. Dive into various threads, engage in discussions, and share your experience with others!</p>
                </div>
            </div>
        </div>

        <!-- Mission Section -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Our Mission</h3>
                    <p class="card-text">At StackHub, our mission is to build a community where people can discuss coding challenges, ask questions, and share knowledge. We aim to create a space where both beginners and experts feel welcome and supported in their coding journey.</p>
                    <p class="card-text">Our platform is open to all types of programming-related topics, ranging from basic coding tutorials to complex development frameworks. We encourage users to participate actively and help each other grow.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Features Section -->
        <div class="col-md-12">
            <h2 class="text-center mb-4">Features</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Thread Creation</h5>
                            <p class="card-text">Easily create threads on various coding topics, share your knowledge, and ask questions.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Interactive Discussions</h5>
                            <p class="card-text">Engage in vibrant discussions with fellow coders and exchange ideas to solve coding challenges.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Code Sharing</h5>
                            <p class="card-text">Share your code snippets, examples, and solutions with the community to help others learn.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Join Us Section -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">Join Us Today!</h3>
                    <p class="card-text">Become a part of StackHub today and start engaging with thousands of developers worldwide. Ask questions, share knowledge, and become a part of an amazing tech community.</p>
                    <div class="text-center">
                        <a href="index.php" class="btn btn-primary">Sign Up Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include 'partials/_footer.php'; ?>

<!-- Bootstrap Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
