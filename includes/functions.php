<?php 
    function getDBConnection() {
     try {
            $pdo = new PDO ('mysql:host=localhost;dbname=shoey; charset=utf8', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $output = 'DB Connection established';

            //echo $output . '<br>';

            return $pdo;
        }
        catch(PDOException $e) {
            $output = 'Unable to connect to DB. ERROR: ' . $e->getMessage() . ' in ' . $e->getFile() . ' : ' . $e->getLine();
            echo $output;
        }
    }

    ##############################################################
    // Product Functions
    ##############################################################

    // Select statement
    function findProductsByName($productName /*$p_id*/) {
        $pdo = getDBConnection();
        $sql = 'SELECT * FROM PRODUCTS WHERE productName LIKE :pName'; //OR productID = :p_id';
        
        $result = $pdo->prepare($sql);

        $result->bindValue(':pName', '%' . $productName . '%');
        //$result->bindValue(':p_id', $p_id);

        try {
            $result->execute();
            return $row = $result->fetchAll(PDO::FETCH_ASSOC);
        }
        
        catch(PDOException $e) {
            $output = 'Error! ' . $e->getMessage();
            echo $output;
        }
    }

        // Select statement
    function findProductsByID($p_id) {
        $pdo = getDBConnection();
        $sql = 'SELECT productName, price FROM products WHERE productID = :p_id';
        
        $result = $pdo->prepare($sql);

        $result->bindValue(':p_id', $p_id);

        try {
            $result->execute();
            return $row = $result->fetch(PDO::FETCH_ASSOC);
        }
        
        catch(PDOException $e) {
            $output = 'Error! ' . $e->getMessage();
            echo $output;
        }
    }

    // Insert statement
    function insertProduct($productName, $productDesc, $productPrice, $productQty) {

        $pdo = getDBConnection();
        $sql = "INSERT INTO products (productName, description, price, stock_qty) VALUES (:pName, :pDesc, :pPrice, :pStock_qty)";

        $result = $pdo->prepare($sql);

        $result->bindValue(':pName', $productName);
        $result->bindValue(':pDesc', $productDesc);
        $result->bindValue(':pPrice', $productPrice);
        $result->bindValue(':pStock_qty', $productQty);

        try {
            $result->execute();
            echo "Product Inserted successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Delete statement
    function deleteProduct($p_id) {

        $pdo = getDBConnection();
        $sql = 'DELETE FROM PRODUCTS WHERE productID = :p_id';

        $result = $pdo->prepare($sql);

        $result->bindValue(':p_id', $p_id);

        try{
            $result->execute();
            echo "Product No. " . $p_id . ". Click <a href='root/deleteForm.html'> here </a> to go back.";
        }
        catch(PDOException $e) {
            $output = "Error! " . $e->getMessage();
            echo $output;
        }
    }

    function updateStock($p_id, $qty) {

        $pdo = getDBConnection();

        $sql = 'UPDATE PRODUCTS
                SET stock_qty = stock_qty - :quantity
                WHERE productID = :p_id';
        
        $result = $pdo->prepare($sql);

        $result->bindValue(':p_id', $p_id);
        $result->bindValue(':quantity', $qty);

        try {
            $result->execute();
            echo 'Stock Updated!';
        }
        catch(PDOException $e) {
            $output = "Error! " . $e->getMessage();
            echo $output;
        }
    }

    ##############################################################
    // Account Functions
    ##############################################################

    function createAccount($firstname, $surname, $email, $password, $phoneNo, $dOB, $address) {

        $pdo = getDBConnection();
        $sql = 'INSERT INTO CUSTOMERS (firstname, surname, email, password, phoneNo, dateOfBirth, address)
            VALUES (:firstname, :surname, :email, :password, :phoneNo, :dOB, :address)';

        $result = $pdo->prepare($sql);

        $result->bindValue(':firstname', $firstname);
        $result->bindValue(':surname', $surname);
        $result->bindValue(':email', $email);
        $result->bindValue(':password', $password);
        $result->bindValue(':phoneNo', $phoneNo);
        $result->bindValue(':dOB', $dOB);
        $result->bindValue(':address', $address);

        try {
            $result->execute();
            echo 'Account Successfully created!';
        }
        catch(PDOException $e) {
            $output = "Error! " . $e->getMessage();
            echo $output;
        }
    }

    function verifyPassword($email, $password) {
        $pdo = getDBConnection();
        $sql = 'SELECT CustID, email, password FROM customers WHERE email = :email';

        $result = $pdo->prepare($sql);
        $result->bindValue(':email', $email);
        $result->execute();
        
        $user = $result->fetch(PDO::FETCH_ASSOC);

        if(!$user) {
            return false;
        }

        if(password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    
    ##############################################################
    // Calculations AND Validation
    ##############################################################

    function calcTotal($basket) {
        $total = 0;

        foreach($basket as $productID => $qty) {
            $product = findProductsByID($productID);

            if(!$product) continue;

            $total += $product['price'] * $qty;
        }

        return $total;
    }
    

    function validateCreateForm($firstname, $surname, $email, $password, $phoneNo, $dOB, $address) {
        
        $errors = [];
    
        if(empty($firstname)) {
            $errors[] = "Firstname is required";
        }
        if(empty($surname)) {
            $errors[] = "Surname is required";
        }
        if(empty($email)) {
            $errors[] = "Email is required";
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email is invalid";
        }
        if(strlen($password) < 8) {
            $errors[] = "Password must be 8 characters long";
        }
        if(strlen($phoneNo) < 10 || strlen($phoneNo) > 11) {
            $errors[] = "Valid phone number is required";
        }
        if(empty($dOB)) {
            $errors[] = "Date Of Birth is required";
        }
        if(empty($address)) {
            $errors[] = "Address is required";
        }

        return $errors;
        
    }

    function validateLogin($email, $password) {

        $errors = [];
        
        //$username = $_POST['username'] ?? '';
        //$password = $_POST['password'] ?? '';

        if(empty($email)) {
            $errors[] = 'ERROR: Email cannot be empty';
            //return $error;
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] ='ERROR: Invalid Email';
        }
        if (empty($password)) {
            $errors[] ='ERROR: Password cannot be empty';
            //return $error;
        }

        return $errors;
    }

    

    ####################################################################
    // Order Functions
    ####################################################################
    
    function createOrder($custID, $total) {
        $pdo = getDBConnection();

        $sql = 'INSERT INTO orders (orderDate, status, totalAmt, CustID)
                VALUES (NOW(), "Pend", :total, :custID)';

        $result = $pdo->prepare($sql);

        $result->bindValue(':total', $total);
        $result->bindValue(':custID', $custID);

        try {
            $result->execute();
            return $pdo->lastInsertId();

            // *    Title: PDO::lastInsertId
            // *    Author: The PHP Documentation Group
            // *    Editions: (PHP 5 >= 5.1.0, PHP 7, PHP 8, PECL pdo >= 0.1.0)
            // *    
            // *    Availability: https://www.php.net/manual/en/pdo.lastinsertid.php

        }
        catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }
    
    function createOrder_Items($orderID ,$productID, $qty, $productPrice) {
        $pdo = getDBConnection();

        $sql = "INSERT INTO order_items (orderID, productID, quantity, unitPrice)
                VALUES (:orderID, :productID, :quantity, :unitPrice)";

        $result = $pdo->prepare($sql);

        $result->bindValue(':orderID', $orderID);
        $result->bindValue(':productID', $productID);
        $result->bindValue(':quantity', $qty);
        $result->bindValue(':unitPrice', $productPrice);

        try {
            $result->execute();
        }
        catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    function updateOrderStatus($orderID, $status) {
        $pdo = getDBConnection();

        $sql = "UPDATE ORDERS SET STATUS = :status WHERE orderID = :orderID";

        $result = $pdo->prepare($sql);

        $result->bindValue(':orderID', $orderID);
        $result->bindValue(':status', $status);

        // VALID STATUS = "Pend" "Canc" "Comp"

        try {
            $result->execute();
            echo 'Order Status: ' . $status;
        }
        catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    function seePastOrders($custID) {
        $pdo = getDBConnection();

        $sql = "SELECT O.orderID, O.orderDate, O.status, O.totalAmt, O_T.quantity, O_T.unitPrice, P.productName
                FROM Orders O
                INNER JOIN Order_Items O_T ON O.OrderID = O_T.OrderID
                INNER JOIN Products P ON P.productID = O_T.productID
                WHERE O.CustID = :custID
                ORDER BY O.orderDate DESC";

        $result = $pdo->prepare($sql);

        $result->bindValue(':custID', $custID);
        
        try {    
            $result->execute();

            $previousOrder = '';
            $previousTotal = '';
            while($row = $result->fetch()) {
                $currentOrder = $row['orderID'];
                
                if($currentOrder != $previousOrder) {
                    if($previousOrder != $currentOrder) {
                        if($previousOrder != '') {
                            echo '<h2 class="productInfo">Total: ' . $previousTotal . '</h2>';
                            echo '</div>';
                        }
                    }
                    $previousTotal = $row['totalAmt'];
                    echo '<div class="orderContainer">';
                    echo '<div class="orderInfo">';
                    echo '<h2>Order ID: ' . $row['orderID'] . '</h2>';
                    echo '<h3>Date: ' . $row['orderDate'] . '</h3>';
                    echo '<h3>Status: ' . $row['status'] . '</h3>';
                    echo '</div>';
                    echo '<hr>';
                    }
                    echo '<div class="productInfo">';
                    echo '<h2 id="underline">' . $row['productName'] . '</h2>';
                    echo '<h3>Quantity Ordered: ' . $row['quantity'] . '</h3>';
                    echo '<h4>Price per Unit: ' . $row['unitPrice'] . '</h4>';
                    echo '</div>';
                    $previousOrder = $currentOrder; 
                    
                }

                echo '</div>';
        }
        catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }
?>