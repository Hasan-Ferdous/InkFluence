<!doctype html>
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
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/write_review.css">
    <link rel="stylesheet" href="css/livesearch.css">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
<?php
session_start();
include "includes/dbh.inc.php";
include "includes/header.inc.php";

?>
<div class="container">
    <form method="POST" action="includes/write_review.inc.php">
        <label class="lebels" for="book_name">Book Name:</label><br>
        <input type="text" id="livesearch" name="book_name" required><br><br>

        <!-- Container to display live search results -->
        <div id="search-results"></div>

        <label class="lebels" for="author">Author:</label><br>
        <input type="text" id="author" name="author" required><br><br>

        <label class="lebels" for="genre">Genre:</label><br>
        <input type="text" id="genre" name="genre" required><br><br>

        <label class="lebels" for="textarea">Write your review:</label><br>
        <div class="textarea_style">
            <textarea class="textarea" id="textarea" name="review" rows="10" cols="50" required></textarea>
        </div>

        <div class="post_button" id="post">
            <button type="submit" name="submit">Post</button>
        </div>
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#livesearch').keyup(function(){
            var query = $(this).val();
            if(query != ""){
                $.ajax({
                    url: "searchlive.php", // Replace with the URL of your PHP file
                    method: "POST",
                    data:{query: query},
                    success: function(data){
                        $('#search-results').html(data);
                    }
                });
            }
            else{
                
            }
        });

        // Handle click on search result
        $(document).on('click', '#search-results p', function(){
            var bookTitle = $(this).text();
            $('#livesearch').val(bookTitle);

            // Fetch author and genre for the selected book
            $.ajax({
                url: "fetch_details.php", // Replace with the URL of your PHP file to fetch book details
                method: "POST",
                data:{book_title: bookTitle},
                success: function(data){
                    var details = JSON.parse(data);
                    $('#author').val(details.author);
                    $('#genre').val(details.genre);
                }
            });
            $('#search-results').html("");
            $('#search-results').hide();
        });
    });
</script>
</body>
</html>
