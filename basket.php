<?php
session_start();
include "includes/functions.php";

if (!isset($_SESSION['userID'])) {
  header("Location: login.php");
  exit;
}

if (!isset($_SESSION['basket'])) {
  $_SESSION['basket'] = [];
}

$total = calcTotal($_SESSION['basket']);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="includes/indexStyle.css" />
    <title>Shoey || Basket</title>
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

    <main>
      <section class="basket-results">
        <?php foreach ($_SESSION['basket'] as $productID => $qty): ?>

  <?php 
    $product = findProductsByID($productID);
    if (!$product) {
      //echo "Product ID $productID not found";
    continue;
}
?>

    <h2>Product: <?php echo htmlspecialchars($product['productName']); ?></h2><br>
    <p>Price: €<?php echo htmlspecialchars($product['price']); ?></p><br>
    <p>Quantity: <?php echo htmlspecialchars($qty); ?></p><br>
    <h4>Subtotal: €<?php echo $product['price'] * $qty; ?></h4>
    <hr>


  <form action="logic/basketLogic.php" method="post">
    <input type="hidden" name="productID" value="<?php echo $productID; ?>">

    <input type="submit" name="decrease" class="basket-submit" value="Decrease Item">
    <input type="submit" name="remove" class="basket-submit" value="Remove Item">
  </form>

<?php endforeach; ?>
        </section>

        <section class="Checkout-Section">
          <div class="checkout-box">
            <h2>Order Summary</h2>

            <!-- * Title: number_format — Format a number with grouped thousands
                 * Author: The PHP Documentation Group
                 * Editions: (PHP 4, PHP 5, PHP 7, PHP 8)
                 * Availability: https://www.php.net/manual/en/function.number-format.php -->

            <p>Total: €<?php echo number_format($total, 2); ?></p>

            <form action="logic/basketLogic.php" method="post">
              <input type="submit" name="checkout" class="basket-submit" value="Checkout">
              <input type="submit" name="clear" class="basket-submit" value="Clear Basket">
            </form>
          </div>

        </section>
    </main>

    <?php 
    if (isset($_SESSION['successMsg'])) {
      echo '<script>alert("' . $_SESSION['successMsg'] . '");</script>';
      unset($_SESSION['successMsg']);

      echo '<h2 class="message">Click <a href="previousOrders.php">here</a> to see your order</h2>';
    }

    ?>

    <footer>&copy; Shoey</footer>
  </body>
</html>
