<?php 
    require_once '../includes/functions.php';

    $results = [];

    if (!isset($_GET['search']) || trim($_GET['search']) === "") {
        echo "<p>Please enter a search term</p>";
    } 
    else {
        $search = trim($_GET['search']);
        $results = findProductsByName($search);

        if (!is_array($results)) {
            $results = [];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../includes/indexStyle.css">
    <title>Shoey || Search Results</title>
</head>
<body>
    <header>
        <div class="logo">
            <h1>Shoey</h1>
        </div>
        
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../cart.php">Cart</a></li>
                <li><a href="../login.php">Login</a></li>
            </ul>
        </nav>

    </header>

    <main>

        <section class="browse-section">
            
                
                <?php foreach($results as $row): ?>
                    <article class="product-card">
                        <p>Error getting Image</p>

                        <h2>Name: <?php echo htmlspecialchars($row['productName']); ?></h2> 
                        <p>Price: <?php echo htmlspecialchars($row['price']); ?></p>
                        <p>Quantity: <?php echo htmlspecialchars($row['stock_qty']); ?></p>

                        <form action="basketLogic.php" method="post">
                            <input type="hidden" name="productID" value="<?php echo $row['productID']; ?>">
                            <input type="submit" name="add" value="Add To Cart">
                        </form>
                    </article>
                <?php endforeach; ?>
            
        </section>
    </main>
</body>
<?php 
?>