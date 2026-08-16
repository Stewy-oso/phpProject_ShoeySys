<?php
  session_start();
  include "includes/functions.php";
  
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
  <header>
      <div class="logo">
        <h1>Shoey</h1>
      </div>

      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="basket.php">Cart</a></li>
          <li><a href="logic/logout.php">Logout</a></li>
        </ul>
      </nav>
    </header>

    <?php seePastOrders($_SESSION['userID']); ?>

    <footer>&copy; Shoey</footer>
</body>
</html>