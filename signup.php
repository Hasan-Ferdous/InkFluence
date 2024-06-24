<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account</title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Roboto:400,500,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
  <div class="loginbox">
    <img src="resources/avatar.png" class="avatar" alt="Avatar">
    <h1>Create Account</h1>
    <form method="POST" action="includes/signup.inc.php" onsubmit="return validateForm()">
      <p>Userame:</p>
      <input type="text" id="username" name="username" required>
      <p>Email:</p>
      <input type="email" id="email" name="email" required>
      <p>Password:</p>
      <input type="password" id="pass1" name="pass1" required>
      <p>Confirm Password:</p>
      <input type="password" id="pass2" name="pass2" required>
      <input type="submit" value="Submit" name="create_account">
    </form>
  </div>
</body>
</html>
