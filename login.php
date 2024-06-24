<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="icon" type="image/x-icon" href="resources/favicon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Helvetica+Neue:400,700&display=swap" rel="stylesheet">
    <script src="script/login.js"></script>
  </head>
  <body>
    <div class="loginbox">
      <img src="resources/avatar.png" class="avatar">
      <form action="includes/login.inc.php" method="POST">
        <h1>Login</h1>
        <?php if(isset($error_message)) { ?>
          <p><?php echo $error_message; ?></p>
        <?php } ?>
        <p>Email</p>
        <input type="text" name="email" placeholder="Enter Email">
        <p>Password</p>
        <input type="password" name="pass1" id="pass1" placeholder="Enter Password">
        <input type="submit" name="submit" value="Login">
        <a href="resetpass.php">Forget your password?</a><br>
        <p class="mt-3 text-muted">Not registered? <a href="signup.php">Create a new account</a></p>
      </form>
    </div>
  </body>
</html>
