<?php 
  session_start();
  include "includes/functions.php";
  
  if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="includes/indexStyle.css" />
    <title>Shoey || Main</title>
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

    <hr />

    <main>
      <section class="search-section">
        <form action="logic/results.php" name="searchProducts" method="get">
          <input
            type="text"
            name="search"
            id="pSearch"
            placeholder="Search..."
          />
          <input type="submit" value="Search" id="submitSearch" />
        </form>
      </section>

      <section class="browse-section">
        <article class="product-card">
          <img src="images/shoe1.jpg" alt="Nike Air Jordans Image" />
          <h2>Nike Air Jordans</h2>
          <p>€69.99</p>
          <form action="logic/basketLogic.php" method="post">
            <input type="hidden" name="productID" value="1" />
            <input type="submit" name="add" value="Add To Cart" />
          </form>
        </article>

        <article class="product-card">
          <img src="images/shoe1.jpg" alt="Nike Zoom Vomero Image" />
          <h2>Nike Zoom Vomero</h2>
          <p>€49.99</p>
          <form action="logic/basketLogic.php" method="post">
            <input type="hidden" name="productID" value="2" />
            <input type="submit" name="add" value="Add To Cart" />
          </form>
        </article>

        <article class="product-card">
          <img src="images/shoe1.jpg" alt="NB 990 v6 Image" />
          <h2>NB 990 v6</h2>
          <p>€29.99</p>
          <form action="logic/basketLogic.php" method="post">
            <input type="hidden" name="productID" value="3" />
            <input type="submit" name="add" value="Add To Cart" />
          </form>
        </article>

        <article class="product-card">
          <img src="images/shoe1.jpg" alt="Adidas Astir Image" />
          <h2>Adidas Astir</h2>
          <p>€75.00</p>
          <form action="logic/basketLogic.php" method="post">
            <input type="hidden" name="productID" value="5" />
            <input type="submit" name="add" value="Add To Cart" />
          </form>
        </article>
      </section>
    </main>

    <!-- <hr> -->
    <footer>&copy; Shoey</footer>
  </body>
</html>
