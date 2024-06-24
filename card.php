<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom CSS -->
    <style>
        /* Add your custom CSS here */
        #sidebar {
            position: fixed;
            height: 100%;
            width: 250px;
            top: 0;
            left: 0;
            overflow-x: hidden;
            transition: all 0.3s;
            padding-top: 60px;
        }

        #sidebar.active {
            width: 80px;
        }

        #search {
            text-align: center;
            margin-top: 20px;
        }

        .books {
            margin-top: 120px; /* Adjust as needed */
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav id="sidebar" class="active">
        <div class="custom-menu">
            <button type="button" id="sidebarCollapse" class="btn btn-primary">
                <i class="fa fa-bars"></i>
                <span class="sr-only">Toggle Menu</span>
            </button>
        </div>
        <div class="p-4">
            <h1><a href="homepage.php" class="logo">InkFluence</a></h1>
            <ul class="list-unstyled components mb-5">
                <li class="active">
                    <a href="homepage.php"><span class="fa fa-home mr-3"></span> Home</a>
                </li>
                <li>
                    <a href="community.php"><span class="fa fa-user mr-3"></span> Community</a>
                </li>
                <li>
                    <a href="write_review.php"><span class="fa fa-briefcase mr-3"></span> Post a Review</a>
                </li>
                <li>
                    <a href="index.php"><span class="fa fa-paper-plane mr-3"></span> Logout</a>
                </li>
            </ul>

            <div class="mb-5">
                <h3 class="h6 mb-3">Subscribe for newsletter</h3>
                <form action="#" class="subscribe-form">
                    <div class="form-group d-flex">
                        <div class="icon"><span class="icon-paper-plane"></span></div>
                        <input type="text" class="form-control" placeholder="Enter Email Address">
                    </div>
                </form>
            </div>
        </div>
    </nav>

    <!-- Search Bar -->
    <div id="search" class="search_wraper">
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
                <span class="info">ex. Animal Farm, Rabindranath Tagore, Fiction</span>
            </form>
        </div>
    </div>

    <!-- Book Display Section -->
    <div class="container books">
        <?php
            echo "<div class='books'>";
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='card'>";
                    echo "<img src='http://localhost/Project3200/book_cover/image.jpg' class='card-img-top' alt='...''>";
                    // Make the book name a clickable link
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'><a href='another_page.php?bookname=" . urlencode($row["title"]) . "&writername=" . urlencode($row["author"]) . "&genre=" . urlencode($row["genre"]) . "'>" . $row["title"] . "</a></h5>";
                    echo "<h6 class='card-subtitle mb-2 text-muted'><a href='another_page.php?bookname=" . urlencode($row["title"]) . "&writername=" . urlencode($row["author"]) . "&genre=" . urlencode($row["genre"]) . "'>" . $row["author"] . "</a></h6>";
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No books found.";
            }
            echo "</div>";
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="js/main.js"></script>
</body>
</html>
