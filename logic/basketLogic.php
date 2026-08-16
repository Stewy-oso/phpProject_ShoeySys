<?php
session_start();
include "../includes/functions.php";

if (!isset($_SESSION['basket'])) {
  $_SESSION['basket'] = [];
}

if(isset($_POST['productID'])) {
    $productID = $_POST['productID'];
}

if (isset($_POST['add'])) {

    $productID = null;

    if (isset($_POST['productID'])) {
        $productID = (int)$_POST['productID'];
    }

    if ($productID > 0) {

        if (isset($_SESSION['basket'][$productID])) {
            $_SESSION['basket'][$productID]++;
        } else {
            $_SESSION['basket'][$productID] = 1;
        }
    }

    // * Title: How to make a redirect in PHP? 
    // * Author: GeeksforGeeks 
    // * Date: Last Updated : 12 Jul, 2025
    // *
    // * Availability: https://www.geeksforgeeks.org/php/how-to-make-a-redirect-in-php/


    header("Location: ../basket.php");
    exit;
}

if (isset($_POST['decrease'])) {

    $productID = null;

    if (isset($_POST['productID'])) {
        $productID = (int)$_POST['productID'];
    }

    if ($productID > 0 && isset($_SESSION['basket'][$productID])) {

        $_SESSION['basket'][$productID]--;

        if ($_SESSION['basket'][$productID] <= 0) {
            unset($_SESSION['basket'][$productID]);
        }
    }

    header("Location: ../basket.php");
    exit;
}

if (isset($_POST['remove'])) {

    $productID = null;

    if (isset($_POST['productID'])) {
        $productID = (int)$_POST['productID'];
    }

    if ($productID > 0) {
        unset($_SESSION['basket'][$productID]);
    }

    header("Location: ../basket.php");
    exit;
}

if (isset($_POST['clear'])) {

    $_SESSION['basket'] = [];

    header("Location: ../basket.php");
    exit;
}

if (isset($_POST['checkout'])) {

    $custID = $_SESSION['userID'];
    $basket = $_SESSION['basket'];

    if (!empty($basket)) {

        $total = calcTotal($basket);
        $orderID = createOrder($custID, $total);

        foreach ($basket as $productID => $qty) {

            $product = findProductsByID($productID);

            if (!$product) {
                continue;
            }

            createOrder_Items(
                $orderID,
                $productID,
                $qty,
                $product['price']
            );

            updateStock($productID, $qty);
        }

        $_SESSION['basket'] = [];

        echo "Successfully checked out!";
    }

    // * Title: How to make a redirect in PHP? 
    // * Author: GeeksforGeeks 
    // * Date: Last Updated : 12 Jul, 2025
    // *
    // * Availability: https://www.geeksforgeeks.org/php/how-to-make-a-redirect-in-php/

    header("Location: ../basket.php");
    exit;
}