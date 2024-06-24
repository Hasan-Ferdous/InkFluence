<nav id="sidebar" class="active">
    <?php
    // Define $current_page based on the current file name
    $current_page = basename($_SERVER['PHP_SELF']);
    ?>
    <div class="custom-menu">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
            <i class="fa fa-bars"></i>
            <span class="sr-only">Toggle Menu</span>
        </button>
    </div>
    <div class="p-4">
        <h1><a href="homepage.php" class="logo">InkFluence</a></h1>
        <ul class="list-unstyled components mb-5">
            <li <?php if ($current_page === 'homepage.php') echo 'class="active"'; ?>>
                <a href="homepage.php"><span class="fa fa-home mr-3"></span> Home</a>
            </li>
            <li <?php if ($current_page === 'community.php') echo 'class="active"'; ?>>
                <a href="community.php"><span class="fa fa-users mr-3"></span> Community</a>
                <!-- Changed the icon to fa-users for community -->
            </li>
            <li <?php if ($current_page === 'write_review.php') echo 'class="active"'; ?>>
                <a href="write_review.php"><span class="fa fa-pencil mr-3"></span> Write a Review</a>
                <!-- Changed the icon from fa-briefcase to fa-pencil -->
            </li>
            <li <?php if ($current_page === 'profile.php') echo 'class="active"'; ?>>
                <a href="profile.php"><span class="fa fa-user-circle mr-3"></span> Profile</a>
                <!-- Added "Profile" link with the icon fa-user-circle -->
            </li>
            <li <?php if ($current_page === 'index.php') echo 'class="active"'; ?>>
                <a href="index.php"><span class="fa fa-sign-out mr-3"></span> Logout</a>
                <!-- Changed the icon from fa-paper-plane to fa-sign-out -->
            </li>
        </ul>
    </div>
</nav>


  
        <div class="s130">
            <form action="../Project3200/search.php" method="POST">
                <div class="inner-form">
                    <div class="input-field first-wrap">
                        <div class="svg-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                            </svg>
                        </div>
                        <input id="search" name="search" type="text" placeholder="Search">
                    </div>
                    <div class="input-field second-wrap">
                        <button type="submit" class="btn-search">SEARCH</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="js/main.js"></script>