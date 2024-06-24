<?php
session_start();
include 'includes/dbh.inc.php';

// Fetch reviews from the review table along with book details
$sql = "SELECT review.*, users.username, books.title AS book_name, books.author, books.genre
FROM review 
INNER JOIN users ON review.user_id = users.id 
INNER JOIN books ON review.book_id = books.id
LEFT JOIN loved_book ON review.review_id = loved_book.review_id
GROUP BY review.review_id
ORDER BY love_index DESC, review.posting_time DESC";
$result = mysqli_query($conn, $sql);

// Check if the user has already loved the review
$user_id = $_SESSION['id']; // Assuming you have stored user_id in session
$loved_reviews = array();
$sql_loved = "SELECT review_id FROM loved_book WHERE user_id = $user_id";
$result_loved = mysqli_query($conn, $sql_loved);
while ($row_loved = mysqli_fetch_assoc($result_loved)) {
    $loved_reviews[] = $row_loved['review_id'];
}
?>
<div class="reviews-container">
<?php
while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <div class="review">
        <div class="user-info">
            <p class="username"><?php echo $row['username']; ?></p>
        </div>
        <div class="book-info">
            <?php
            // Define absolute path to save directory
            $save_directory = "book_cover/";
            // Create directory if it doesn't exist
            if (!file_exists($save_directory)) {
                mkdir($save_directory, 0777, true);
            }
            
            $encoded_title = urlencode($row["book_name"]);
            $filename = md5($encoded_title) . ".jpg"; // Using MD5 hash for uniqueness
            $save_path = $save_directory . $filename;

            if (!file_exists($save_path)) {
                // Download the book cover to your server if not already downloaded
                $api_key = "AIzaSyAALlAV4We348VTqK18QTDgSQgb9WlpBR4"; // Replace with your Google Books API key
                $book_title = urlencode($row["book_name"]);
                $google_books_url = "https://www.googleapis.com/books/v1/volumes?q=" . $book_title . "&key=" . $api_key;
                $response = file_get_contents($google_books_url);
                $data = json_decode($response, true);

                if (isset($data['items'][0]['volumeInfo']['imageLinks']['thumbnail'])) {
                    $book_cover_url = $data['items'][0]['volumeInfo']['imageLinks']['thumbnail'];
                    file_put_contents($save_path, file_get_contents($book_cover_url));
                } else {
                    // Default cover image if cover not found
                    $save_path = "default_cover.jpeg";
                }
            }
            
            echo "<img src='$save_path' class='book-image' alt='Book Image'>";
            ?>
            
            <p>Title: <a href='another_page.php?bookname=<?php echo urlencode($row["book_name"]); ?>&writername=<?php echo urlencode($row["author"]); ?>&genre=<?php echo urlencode($row["genre"]); ?>'><?php echo $row['book_name']; ?></a></p>
            <p>Author: <a href='another_page.php?bookname=<?php echo urlencode($row["book_name"]); ?>&writername=<?php echo urlencode($row["author"]); ?>&genre=<?php echo urlencode($row["genre"]); ?>'><?php echo $row['author']; ?></a></p>
            <p>Genre: <a href='another_page.php?bookname=<?php echo urlencode($row["book_name"]); ?>&writername=<?php echo urlencode($row["author"]); ?>&genre=<?php echo urlencode($row["genre"]); ?>'><?php echo $row['genre']; ?></a></p>
        </div>
        <div class="review-content">
            <p class="review-text"><?php echo $row['review_text']; ?></p>
            <p class="review-id">Review ID: <?php echo $row['review_id']; ?></p>
        </div>
        <div class="actions">
        <form action="includes/community.inc.php" method="POST">
    <?php if (in_array($row['review_id'], $loved_reviews)) { ?>
        <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
    <input type="hidden" name="love_review_id" value="<?php echo $row['review_id']; ?>">
        <button type="submit" class="love-button">
            <img src="loved.png" alt="Loved">
        </button>
    <?php } else { ?>
        <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
    <input type="hidden" name="love_review_id" value="<?php echo $row['review_id']; ?>">
        <button type="submit" class="love-button">
            <img src="love.png" alt="Love">
        </button>
    <?php } ?>
    <p class="love-count">Upvotes: <?php echo $row['love_index']; ?></p> <!-- Display count of loves -->
</form>

        </div>
    </div>
    <?php
}
?>
</div>
