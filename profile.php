<!DOCTYPE html>
<html lang="en">
<head>
    <title>InkFluence</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
    <link href="assets/img/favicon.png" rel="icon">
    <link href="css/searchbox.css" rel="stylesheet">
    <link href="css/card.css" rel="stylesheet">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/profile.css">
   
</head>

<body>
<?php
include "includes/dbh.inc.php";
include "includes/header.inc.php";
include "includes/profile.inc.php";
?>
    <div class="container">
    <div class="profile-header">
        <?php 
            $profile_picture = "dp/{$user_details['id']}.jpeg";
            if (file_exists($profile_picture)) {
                echo "<img src=\"$profile_picture\" alt=\"Profile Picture\" class=\"profile-picture\">";
            } else {
                echo "<div class=\"profile-picture-placeholder\">
                        <p>No profile picture</p>
                        <form action=\"upload_profile_picture.php\" method=\"post\" enctype=\"multipart/form-data\">
                            <input type=\"file\" name=\"profile_picture\" accept=\"image/jpeg\">
                            <input type=\"submit\" value=\"Upload\">
                        </form>
                    </div>";
            }
        ?>
        <div class="profile-info">
            <h1><?php echo $user_details['username']; ?></h1>
            <p class="email"><?php echo $user_details['email']; ?></p>
        </div>
    </div>



        <div class="profile-section">
            <h2>Favourite Genre</h2>
            <p><?php echo $favourite_genre['genre_name']; ?></p>
        </div>

        <div class="profile-section">
    <h2>Read Books</h2>
    <ul class="book-list">
        <?php while ($row_read_books = $result_read_books->fetch_assoc()) : ?>
            <?php 
            $encoded_title = urlencode($row_read_books["title"]);
            $save_directory = "book_cover/";
            $filename = md5($encoded_title) . ".jpg"; // Using MD5 hash for uniqueness
            $save_path = $save_directory . $filename;

            if (!file_exists($save_path)) {
                // Download the book cover to your server if not already downloaded
                $api_key = "AIzaSyAALlAV4We348VTqK18QTDgSQgb9WlpBR4";
                $book_title = urlencode($row_read_books["title"]);
                $google_books_url = "https://www.googleapis.com/books/v1/volumes?q=" . $book_title . "&key=" . $api_key;
                $response = file_get_contents($google_books_url);
                $data = json_decode($response, true);

                if (isset($data['items'][0]['volumeInfo']['imageLinks']['thumbnail'])) {
                    $book_cover_url = $data['items'][0]['volumeInfo']['imageLinks']['thumbnail'];
                    file_put_contents($save_path, file_get_contents($book_cover_url));
                } else {
                    // Default cover image if cover not found
                    $save_path = "default_cover.jpg";
                }
            }
            ?>
            <li><?php echo "<img src='$save_path' class='card-img-top' alt='...'>"; ?></li>
        <?php endwhile; ?>
    </ul>
</div>

<div class="profile-section">
    <h2>Wishlist</h2>
    <ul class="book-list">
        <?php while ($row_wishlist = $result_wishlist->fetch_assoc()) : ?>
            <?php 
            $encoded_title = urlencode($row_wishlist["title"]);
            $save_directory = "book_cover/";
            $filename = md5($encoded_title) . ".jpg"; // Using MD5 hash for uniqueness
            $save_path = $save_directory . $filename;

            if (!file_exists($save_path)) {
                // Download the book cover to your server if not already downloaded
                $api_key = "AIzaSyAALlAV4We348VTqK18QTDgSQgb9WlpBR4";
                $book_title = urlencode($row_wishlist["title"]);
                $google_books_url = "https://www.googleapis.com/books/v1/volumes?q=" . $book_title . "&key=" . $api_key;
                $response = file_get_contents($google_books_url);
                $data = json_decode($response, true);

                if (isset($data['items'][0]['volumeInfo']['imageLinks']['thumbnail'])) {
                    $book_cover_url = $data['items'][0]['volumeInfo']['imageLinks']['thumbnail'];
                    file_put_contents($save_path, file_get_contents($book_cover_url));
                } else {
                    // Default cover image if cover not found
                    $save_path = "default_cover.jpg";
                }
            }
            ?>
            <li><?php echo "<img src='$save_path' class='card-img-top' alt='...'>"; ?></li>
        <?php endwhile; ?>
    </ul>
</div>


<div class="profile-section">
            <h2>User Reviews</h2>
            <ul class="review-list">
                <?php while ($row_user_reviews = $result_user_reviews->fetch_assoc()) : ?>
                    <li>
                        <p><strong>Book:</strong> <?php echo $row_user_reviews['book_name']; ?></p>
                        <p><strong>Review:</strong> <?php echo $row_user_reviews['review_text']; ?></p>
                        <button class="delete-button"><i class="fa fa-trash delete-icon"></i></button>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>


        
<div class="profile-section">
    <h2>Liked Books</h2>
    <ul class="book-list">
        <?php while ($row_liked_books = $result_liked_books->fetch_assoc()) : ?>
            <?php 
            $encoded_title = urlencode($row_liked_books["title"]);
            $save_directory = "book_cover/";
            $filename = md5($encoded_title) . ".jpg"; // Using MD5 hash for uniqueness
            $save_path = $save_directory . $filename;

            if (!file_exists($save_path)) {
                // Download the book cover to your server if not already downloaded
                $api_key = "AIzaSyAALlAV4We348VTqK18QTDgSQgb9WlpBR4";
                $book_title = urlencode($row_liked_books["title"]);
                $google_books_url = "https://www.googleapis.com/books/v1/volumes?q=" . $book_title . "&key=" . $api_key;
                $response = file_get_contents($google_books_url);
                $data = json_decode($response, true);

                if (isset($data['items'][0]['volumeInfo']['imageLinks']['thumbnail'])) {
                    $book_cover_url = $data['items'][0]['volumeInfo']['imageLinks']['thumbnail'];
                    file_put_contents($save_path, file_get_contents($book_cover_url));
                } else {
                    // Default cover image if cover not found
                    $save_path = "default_cover.jpg";
                }
            }
            ?>
            <li><?php echo "<img src='$save_path' class='card-img-top' alt='...'>"; ?></li>
        <?php endwhile; ?>
    </ul>
</div>


       

       

    </div>
</body>
</html>
