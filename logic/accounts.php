<?php 
  session_start();
  
  if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
  }

    require_once '../includes/functions.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['create'])) {
            $firstname = trim($_POST['firstname'] ?? '');
            $surname = trim($_POST['surname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $phoneNo = trim($_POST['phoneNo'] ?? '');
            $dOB = trim($_POST['dOB'] ?? '');
            $address = trim($_POST['address'] ?? '');

            $errors = validateCreateForm($firstname, $surname, $email, $password, $phoneNo, $dOB, $address);
            
            if(empty($errors)) {

                $password = password_hash($password, PASSWORD_DEFAULT);
                
                createAccount(
                    $firstname, 
                    $surname, 
                    $email, 
                    $password, 
                    $phoneNo, 
                    $dOB, 
                    $address
                );

                echo '<br>Click <a href="../index.php">here</a> ';

            }
            else {
                foreach($errors as $error) {
                    echo $error . '<br>';
                }
            }
        }

        if(isset($_POST['update'])) {
            $firstname = trim($_POST['firstname'] ?? '');
            $surname = trim($_POST['surname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $phoneNo = trim($_POST['phoneNo'] ?? '');
            $address = trim($_POST['address'] ?? '');

            $errors = validateUpdateForm($firstname, $surname, $phoneNo, $address);
            $verified = verifyPassword($email, $password);
            
            if(empty($errors) && $verified == true) {

                $custID = $_SESSION['userID'];
                updateAccountDetails($firstname, $surname, $phoneNo, $address, $custID);
            }
            else {
                foreach($errors as $error) {
                    echo $error . '<br>';
                }

                if($verified == false) {
                    $_SESSION['successMsg'] = 'Account credentials incorrect! Check Password?';
                }
            }
        }

        
    }

    if(isset($_POST['delete'])) {
        $custID = $_SESSION['userID'];

        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $verified = verifyPassword($email, $password);

        if(!empty($verified)) {
            deleteAccount($custID);
            $_SESSION['successMsg'] = 'Account Deleted!';
            header('Location: ../profile.php');
            exit;
        }
        else {
            $_SESSION['failMsg'] = 'Account credentials incorrect! Check Email or Password?';
            header('Location: ../profile.php');
            exit;
        }
    }
?>
