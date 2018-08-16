<?php
// Include config file
require_once 'config.php';

// Database table required for this php file to work:
//     CREATE TABLE users (
//     id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
//     username VARCHAR(64) NOT NULL UNIQUE,
//     password VARCHAR(64) NOT NULL,
//     salt2 VARCHAR(64) NOT NULL,
//     created_at DATETIME DEFAULT CURRENT_TIMESTAMP);


// Define variables and initialize with empty values
$username = $password = $salt2 = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
  // $_POST is set

  // Validate username
  if(empty(trim($_POST["username"]))){
    // Empty username field
    $username_err = "Please enter a username.";
  }
  else {
    // if username field was entered,
    $username = trim($_POST["username"]);

    // Prepare the select statement
    $sql = "SELECT id FROM users WHERE username = '$username'";

    if($result = $conn->query($sql)) { // is the db query successful?
      if ($result->num_rows > 0) {  // if a row returned, then username is taken
          $username_err = "This username is already taken.";
      }
    }
    // if db query has an error, e.g. wrong SQL statament:
    else print "Oops! Something went wrong. Please try again later.<br>";
  }

  // Validate password
  if(empty(trim($_POST['password']))){
      $password_err = "Please enter a password.";
  } elseif(strlen(trim($_POST['password'])) < 6){
      $password_err = "Password must have at least 6 characters.";
  } else {
      $password = trim($_POST['password']);
  }

  // Validate confirm password
  if(empty(trim($_POST["confirm_password"]))){
      $confirm_password_err = 'Please confirm password.';
  } else {
      $confirm_password = trim($_POST['confirm_password']);
      if($password != $confirm_password){
          $confirm_password_err = 'Password did not match.';
      }
  }

  // Salting
  $salt2 = bin2hex(random_bytes(32)); // !!! requires PHP7
  $token = hash('sha256', SALT1.$password.$salt2);
  print "SALT1: " . SALT1 . " Len: " . strlen(SALT1) . "<br><br>";
  print "Password: " . $password . " Len: " . strlen($password) . "<br><br>";
  print "Salt2: " . $salt2 . " Len: " . strlen($salt2) . "<br><br>";
  print "Token: " . $token . " Len: " . strlen($token) . "<br><br>";
  //$password = $token;

  // Check input errors before inserting in database
  if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
    // Prepare an insert statement
    $sql = "INSERT INTO users (username, password, salt2) VALUES ('$username', '$token', '$salt2')";

    if ($conn->query($sql) === TRUE) {
      header("location: login.php");
    }
  }
  $conn->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; margin: auto; padding: 20px; }
    </style>
</head>
<body>
    <div class="jumbotron text-center">
        <img src="isg.png" width="250px" alt="ISG Logo">
        <h2 class="m-4">Callcenter</h2>
    </div>
  <div class="container">
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label for="usr">Username</label>
                <input type="text" name="username" id="usr" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label for="pwd">Password</label>
                <input type="password" name="password" id="pwd" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label for="cpwd">Confirm Password</label>
                <input type="password" name="confirm_password" id="cpwd" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
  </div>
</body>
</html>
