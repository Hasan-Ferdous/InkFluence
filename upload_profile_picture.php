<?php
include("includes/profile.inc.php");
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file was uploaded without errors
    if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == 0) {
        $user_id = $user_details['id']; // Check if this line is correctly fetching the user ID
        echo "User ID: $user_id";
        $target_dir = "dp/";
        $target_file = $target_dir . $user_id . ".jpeg";
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if($check !== false) {
            // File is an image - do nothing
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["profile_picture"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow only certain file formats
        if($imageFileType != "jpg" && $imageFileType != "jpeg") {
            echo "Sorry, only JPG, JPEG files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // If everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["profile_picture"]["name"])). " has been uploaded.";
                // Redirect to profile page or wherever needed
                header("Location: profile.php");
                exit();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "No file uploaded.";
    }
}
?>
