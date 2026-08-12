<?php 

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

        elseif(isset($_POST['delete'])) {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');


        }
    }
?>
