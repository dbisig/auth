<?php
// Include config file
require 'config.php';

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

print("Mysqli: (\$conn)<br>");
print_r($conn);
print "<br><br>";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
  // $_POST is set
  echo "\$_REQUEST set<br><br>";
  echo "\$_POST:<br>";
  print_r($_POST);

  // Validate username
  if(empty(trim($_POST["username"]))){
    // Empty username field
    $username_err = "Please enter a username.";
  }
  else {
    // username field entered
    $username = ($_POST["username"]);
    $param_username = trim($_POST["username"]);
    echo "<br>username: is set to $username<br>";
    echo "<br>param username: is set to $param_username<br>";

    // Prepare a select statement
    $sql = "SELECT id FROM users WHERE username = '$username'";
    echo "<br>\$sql =  $sql<br>";

// BEGIN TEST


/* INSERT DUMMY DATA
$sql = "INSERT INTO users (username, password)
VALUES ('Johnny', 'pass')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
INSERT DUMMY DATA */


    if($result = $conn->query($sql)) {
      //print_r($result->fetch_assoc());
      if ($result->num_rows > 0) {
          // output data of each row
          $username_err = "This username is already taken.";
          while($row = $result->fetch_assoc()) {
              echo "id: " . $row["id"]. " - Name: " . $row["username"]. " " . $row["password"]. "<br>";
          }
      } else {
          echo "$username not found";
      }
    }
    else print "Oops! Something went wrong. Please try again later.<br>";

// END TEST
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

  // Check input errors before inserting in database
  if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
    // Prepare an insert statement
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    print "$sql<br>";

    if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
      header("location: login.php");
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

  $conn->close();
}


else {
  // if $_REQUEST not set
  echo "\$_REQUEST is not set<br><br>";
}
$conn->close();
//$username_err = "MyError1";
//$password_err = "MyError2";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
  <div class="container">
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
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
