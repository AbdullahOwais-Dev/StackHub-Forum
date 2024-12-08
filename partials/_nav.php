<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/forum/index.php">StackHub</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <!-- Home link -->
        <li class="nav-item">
          <a class="nav-link active" href="/forum/index.php">Home</a>
        </li>
        <!-- Signup link (opens signup modal) -->
        <li class="nav-item">
          <a class="nav-link" href="#" data-toggle="modal" data-target="#signupmodal">Sign Up</a>
        </li>
        <!-- Login link -->
        <li class="nav-item">
          <a class="nav-link" href="/forum/login.php">Login</a>
        </li>
        <!-- Logout link (only visible if logged in) -->
        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            echo '<li class="nav-item">
                    <a class="nav-link" href="/forum/logout.php">Logout</a>
                  </li>';
        }
        ?>
      </ul>
    </div>
  </div>
</nav>
