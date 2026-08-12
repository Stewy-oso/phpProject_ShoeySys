<?php 
session_start();
require_once '../includes/functions.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$errors = validateLogin($email, $password);

  if (empty($errors)) {
    $user = verifyPassword($email, $password);

    if ($user) {
        $_SESSION['userID'] = $user['CustID'];
        $_SESSION['email'] = $user['email'];

        header("Location: ../index.php");
        exit;
    } 
    
    else {
        $errors[] = "Invalid email or password";
    }
  }
}
// *    Title: How to make a redirect in PHP?
// *    Author: GeeksforGeeks
// *    Date: Last Updated : 12 Jul, 2025
// *    
// *    Availability: https://www.geeksforgeeks.org/php/how-to-make-a-redirect-in-php/
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="../includes/indexStyle.css">
      <title>Document</title>
    </head>
    <body>
      <header>
      <div class="logo">
        <h1>Shoey</h1>
      </div>
    </header>

    <main> 
      <?php 
        foreach($errors as $error) {
          echo htmlspecialchars($error) . '<br>';
        }

      ?>
    </main>
    </body>
    </html>