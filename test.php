<?php
  session_start();
  include "includes/functions.php";

  $_SESSION['userID'] = 9;
  
  if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="includes/indexStyle.css">
</head>
<body>
    <?php seePastOrders($_SESSION['userID']); ?>
</body>
</html>