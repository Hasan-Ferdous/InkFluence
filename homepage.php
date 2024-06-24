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
  </head>

<body>
    <?php
    session_start();
    include "includes/dbh.inc.php";
    include "includes/header.inc.php";
    include "includes/homepage.inc.php";
    include "books.php";

    $conn->close();
    ?>
    
</body>
</html>
