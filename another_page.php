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
    <link href="css/card.css" rel="stylesheet">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/book_details.css">
    <link rel="stylesheet" href="css/review_bookdetails.css">
    <link rel="stylesheet" href="css/relatedbook.css">
</head>

<body>
<?php
session_start();
include "includes/dbh.inc.php";
include "includes/header.inc.php";

// Function to fetch book details from Google Books API
function fetchBookDetails($title, $author) {
    // Replace 'YOUR_API_KEY' with your actual Google Books API key
    $api_key = 'AIzaSyAALlAV4We348VTqK18QTDgSQgb9WlpBR4';
    $url = "https://www.googleapis.com/books/v1/volumes?q=intitle:" . urlencode($title) . "+inauthor:" . urlencode($author) . "&key=$api_key";
    
    // Fetch data from Google Books API
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    
    // Check if data is available
    if(isset($data['items']) && count($data['items']) > 0) {
        // Extract relevant book details from the first result
        $book_details = $data['items'][0]['volumeInfo'];
        return $book_details;
    } else {
        return null;
    }
}

// Retrieve basic details about the book from the books table
// Function to check if the book is in the wishlist
function isInWishlist($book_id, $user_id) {
    global $conn;
    $sql = "SELECT COUNT(*) as count FROM user_book_wishlist WHERE user_id = $user_id AND book_id = $book_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'] > 0;
}

// Function to check if the book is in the read list
function isInReadList($book_id, $user_id) {
    global $conn;
    $sql = "SELECT COUNT(*) as count FROM user_book_read WHERE user_id = $user_id AND book_id = $book_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'] > 0;
}


if(isset($_GET['bookname']) && isset($_GET['writername'])) {
    // Get bookname and writername from the URL
    $bookname = $_GET['bookname'];
    
    $writername = $_GET['writername'];

    $book_id= $_GET['book_id'];

    
    // Fetch book details from Google Books API
    $book_details = fetchBookDetails($bookname, $writername);

    // Check if book details are found
    if ($book_details) {
        // Start book details container
        echo "<div class='book-details-container'>";
        
        // Display book cover on the left side
        echo "<div class='book-cover-container'>";
        if (isset($book_details['imageLinks']['thumbnail'])) {
            echo "<img src='{$book_details['imageLinks']['thumbnail']}' class='book-cover' alt='Book Cover'>";
        } else {
            echo "<img src='placeholder.jpg' class='book-cover' alt='Book Cover'>";
        }
        
        ?>
        <?php
if (isInReadList($book_id, $_SESSION['id'])) {
    // Book is in the read list, display a button to indicate it's already in the read list
    echo "<form method='post' action='includes/read.inc.php'>";
    echo "<input type='hidden' name='book_id' value='$book_id'>";
    echo "<button type='submit' class='btn btn-success read-btn' name='action' value='read' disabled>&#10003; Already Read</button>";
    echo "</form>";
} else {
    // Book is not in the read list, display the "Read" button
    echo "<form method='post' action='includes/read.inc.php'>";
    echo "<input type='hidden' name='book_id' value='$book_id'>";
    echo "<button type='submit' class='btn btn-primary read-btn' name='action' value='read'>&#x002B;Read</button>";
    echo "</form>";
}

if (isInWishlist($book_id, $_SESSION['id'])) {
    // Book is in the wishlist, display a button to remove it from the wishlist
    echo "<form method='post' action='includes/remove_from_wishlist.inc.php'>";
    echo "<input type='hidden' name='book_id' value='$book_id'>";
    echo "<button type='submit' class='btn btn-danger wishlist-btn' name='action' value='remove'>&#x2212;Remove from Wishlist</button>";
    echo "</form>";
} else {
    // Book is not in the wishlist, display the "Add to Wishlist" button
    echo "<form method='post' action='includes/wishlist.inc.php'>";
    echo "<input type='hidden' name='book_id' value='$book_id'>";
    echo "<button type='submit' class='btn btn-primary wishlist-btn' name='action' value='wishlist'>&#x002B;Add to Wishlist</button>";
    echo "</form>";
}
?>

        <?php
         // Close book cover container
         echo "</div>";
        // Display book details on the right side
        echo "<div class='book-info'>";
        // Display book title
        echo "<h2>{$book_details['title']}</h2>";
        // Display book authors
        echo "<p class='author'><strong>Author(s):</strong> " . implode(", ", $book_details['authors']) . "</p>";
        // Display book genre/category
        if (isset($book_details['categories'])) {
            echo "<p class='genre'><strong>Genre/Category:</strong> " . implode(", ", $book_details['categories']) . "</p>";
        } else {
            echo "<p class='genre'><strong>Genre/Category:</strong> Not available.</p>";
        }
        // Display book description/synopsis
        echo "<p class='description'><strong>Description:</strong> " . (isset($book_details['description']) ? $book_details['description'] : "Description not available.") . "</p>";
        // Display book publication date
        echo "<p class='published-date'><strong>Published Date:</strong> " . (isset($book_details['publishedDate']) ? $book_details['publishedDate'] : "Not available.") . "</p>";
        // Display book page count
        echo "<p class='page-count'><strong>Page Count:</strong> " . (isset($book_details['pageCount']) ? $book_details['pageCount'] : "Not available.") . "</p>";
        // Display book language
        echo "<p class='language'><strong>Language:</strong> " . (isset($book_details['language']) ? $book_details['language'] : "Not available.") . "</p>";
        // Display book preview link
        echo "<p class='preview-link'><strong>Preview Link:</strong> <a href='" . $book_details['previewLink'] . "' target='_blank'>Click here</a></p>";
        // Display book sale info
        if (isset($book_details['saleInfo']['saleability']) && $book_details['saleInfo']['saleability'] === 'FOR_SALE') {
            echo "<p class='sale-info'><strong>Sale Information:</strong> Available for sale. Price: " . $book_details['saleInfo']['listPrice']['amount'] . " " . $book_details['saleInfo']['listPrice']['currencyCode'] . "</p>";
        } else {
            echo "<p class='sale-info'><strong>Sale Information:</strong> Not available for sale.</p>";
        }
        echo "</div>"; // Close book info
        
        echo "</div>"; // Close book details container
        
    }  else {

        echo "<div class='book-details-container'>";
        // Define SQL query to fetch book information from the database
        $sqlq = "SELECT * FROM books WHERE title = '$bookname';";
    
        // Execute SQL query
        $result = $conn->query($sqlq);
    
        // Check if there are any results
        if ($result) {
            // Check if there are any rows returned
            if ($result->num_rows > 0) {
                // Display the retrieved book information
                while ($row = $result->fetch_assoc()) {
                    $encoded_title = urlencode($row["title"]);
                    echo "<div class='book-cover-container'>";
                    echo "<img src='http://localhost/Project3200/book_cover/$encoded_title.jpeg' class='book-cover' alt='Book Cover'>";
                    ?>
                     <?php
if (isInReadList($book_id, $_SESSION['id'])) {
    // Book is in the read list, display a button to indicate it's already in the read list
    echo "<form method='post' action='includes/read.inc.php'>";
    echo "<input type='hidden' name='book_id' value='$book_id'>";
    echo "<button type='submit' class='btn btn-success read-btn' name='action' value='read' disabled>&#10003; Already Read</button>";
    echo "</form>";
} else {
    // Book is not in the read list, display the "Read" button
    echo "<form method='post' action='includes/read.inc.php'>";
    echo "<input type='hidden' name='book_id' value='$book_id'>";
    echo "<button type='submit' class='btn btn-primary read-btn' name='action' value='read'>&#x002B;Read</button>";
    echo "</form>";
}

if (isInWishlist($book_id, $_SESSION['id'])) {
    // Book is in the wishlist, display a button to remove it from the wishlist
    echo "<form method='post' action='includes/remove_from_wishlist.inc.php'>";
    echo "<input type='hidden' name='book_id' value='$book_id'>";
    echo "<button type='submit' class='btn btn-danger wishlist-btn' name='action' value='remove'>&#x2212;Remove from Wishlist</button>";
    echo "</form>";
} else {
    // Book is not in the wishlist, display the "Add to Wishlist" button
    echo "<form method='post' action='includes/wishlist.inc.php'>";
    echo "<input type='hidden' name='book_id' value='$book_id'>";
    echo "<button type='submit' class='btn btn-primary wishlist-btn' name='action' value='wishlist'>&#x002B;Add to Wishlist</button>";
    echo "</form>";
}
?>
                    <?php
                    echo "</div>";
                    echo "<div class='book-info'>";
                    // Make the book name a clickable link
                    echo "<h2><a href='another_page.php?bookname=" . urlencode($row["title"]) . "&writername=" . urlencode($row["author"]) . "&genre=" . urlencode($row["genre"]) . "'>" . $row["title"] . "</a></h2>";
                    echo "<p class='author'><strong>Author(s):</strong><a href='another_page.php?bookname=" . urlencode($row["title"]) . "&writername=" . urlencode($row["author"]) . "&genre=" . urlencode($row["genre"]) . "'>" . $row["author"] . "</a></p>";
                    echo '</div>';
                }
            } else {
                // If no information found in the database
                echo "<p class='not-found'>Sorry, the information for this book could not be found.</p>";
            }
        } else {
            // If there's an error with the query
            echo "<p class='error'>Error: " . $conn->error . "</p>";
        }

        echo "</div>";
    }
}


?>


<?php
function fetchRelatedBooks($title, $author) {
    // Replace 'YOUR_API_KEY' with your actual Google Books API key
    $api_key = 'AIzaSyAALlAV4We348VTqK18QTDgSQgb9WlpBR4';
    $url = "https://www.googleapis.com/books/v1/volumes?q=related:" . urlencode($title) . "+inauthor:" . urlencode($author) . "&key=$api_key";
    
    // Fetch data from Google Books API
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    
    // Check if data is available
    if(isset($data['items']) && count($data['items']) > 0) {
        // Extract relevant book details from the results
        $related_books = array();
        foreach ($data['items'] as $item) {
            $related_books[] = $item['volumeInfo'];
        }
        return $related_books;
    } else {
        return null;
    }
}

if(isset($_GET['bookname']) && isset($_GET['writername'])) {
    // Get bookname and writername from the URL
    $bookname = $_GET['bookname'];
    $writername = $_GET['writername'];

    // Fetch book details from Google Books API
    $book_details = fetchBookDetails($bookname, $writername);

    // Fetch related books from Google Books API
    $related_books = fetchRelatedBooks($bookname, $writername);

    // Check if book details are found
    if ($book_details) {
        // Display book details...
    } else {
        // If book details are not found...
    }

    // Display related books if available

if ($related_books) {
    echo "<div class='related-books-container'>";
    echo "<h2 class='related-books-title'>Related Books</h2>";
    echo "<div class='related-books'>";
    foreach ($related_books as $related_book) {
        echo "<div class='related-book'>";
        if (isset($related_book['imageLinks']['thumbnail'])) {
            echo "<img src='{$related_book['imageLinks']['thumbnail']}' class='related-book-cover' alt='Book Cover'>";
        } else {
            echo "<img src='placeholder.jpg' class='related-book-cover' alt='Book Cover'>";
        }
        echo "<h3 class='related-book-title'>{$related_book['title']}</h3>";
        echo "<p class='related-book-author'><strong>Author(s):</strong> " . implode(", ", $related_book['authors']) . "</p>";
        echo "</div>";
    }
    echo "</div>"; // Close related-books
    echo "</div>"; // Close related-books-container
} else {
    echo "<p class='no-related-books'>No related books found.</p>";
}

}

?>

<?php

include"review_bookdetails.php";
?>
</body>
</html>