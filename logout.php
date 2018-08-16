<?php
session_start();
session_destroy();
//print "You are now logged out";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="../css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <title>Logout Page</title>
</head>
<body>
  <div class="container">
    <div class="jumbotron text-center">
      <h1>Bye</h1>
      <p>You are now logged out</p>
      <a href="login.php" class="btn btn-primary">Back to login</a>
    </div>
  </div>
</body>
</html>
