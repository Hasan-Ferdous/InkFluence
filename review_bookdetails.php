<?php

// Fetch reviews from the review table along with book details
$sql = "SELECT review.*, users.username, books.title AS book_name
        FROM review 
        INNER JOIN users ON review.user_id = users.id 
        INNER JOIN books ON review.book_id = books.id
        WHERE title = '$bookname' 
        ORDER BY review.posting_time DESC";

$result = mysqli_query($conn, $sql);
?>
<div class="reviews-container">
<?php
while ($row = mysqli_fetch_assoc($result)) {
?>
    <div class="review">
        <div class="user-info">
            <p class="username"><?php echo $row['username']; ?></p>
        </div>
        <div class="review-content">
            <p class="review-text"><?php echo $row['review_text']; ?></p>
            <p class="review-id">Review ID: <?php echo $row['review_id']; ?></p>
        </div>
        <div class="actions">
            <form action="includes/community.inc.php" method="POST">
                <input type="hidden" name="love_review_id" value="<?php echo $row['review_id']; ?>">
                <button type="submit" class="love-button">
                    <img src="love.png" alt="Love">
                </button>
            </form>
        </div>
    </div>
<?php
}
?>
</div>
