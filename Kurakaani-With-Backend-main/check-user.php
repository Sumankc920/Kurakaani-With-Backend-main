<?php
session_start();
if(isset($_POST["login-button"])) {
    include_once 'databaseConnection/settable.php';
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    $_SESSION["login_error"] = 0;
    $_SESSION["user_no_match_error"] = 0;
    $_SESSION["table_empty_error"] = 0;

    
    
    $query = "SELECT name,email,password FROM users";
    $select_response = mysqli_query($connection , $query);
    if($select_response) {
        if(mysqli_num_rows($select_response) > 0) {
            while($row = mysqli_fetch_assoc($select_response)) {
                if($row["email"] === $email && $row["password"] === $password) {
                    $user_id_query = "SELECT userid FROM users WHERE email='$email' and password='$password'";
                    $user_id_response = mysqli_query($connection , $user_id_query);
                    if($user_id_response) {
                        if(mysqli_num_rows($user_id_response) > 0) {
                            $row_id =mysqli_fetch_assoc($user_id_response);
                            $id = $row_id["userid"];
                            $_SESSION["user_id"] = $id; 
                            $_SESSION["table_empty_error"] = 0;
                            $_SESSION["user_no_match_error"] = 0; 
                            $check = 1;
                            $status_query = "UPDATE users SET status='Active' WHERE userid='$id'";
                            $status_response = mysqli_query($connection , $status_query);
                            header("Location:Welcome/welcome.php");
                        }
                    }
                }else {
                    $_SESSION["table_empty_error"] = 1;
                    $_SESSION["user_no_match_error"] = 1;
                    echo "table empty error";
                    header("Location:index.php");
                }
            }
        }else {
                $_SESSION["table_empty_error"] = 1;
                $_SESSION["user_no_match_error"] = 1;
                echo "table empty error";
                header("Location:index.php");
            }
    }else {
        $_SESSION["table_connection_error"] = 1;
        echo "table connection error";
        header("Location:index.php");
    }
}else if(isset($_POST["create-account-button"])) {
    $_SESSION["duplicate_login"] = 0;
    header("Location:CreateAccount/add-account.php");
}else {
    $_SESSION["duplicate_login"] = 0;
    $_SESSION["user_no_match_error"] = 0;
    $_SESSION["table_empty_error"] = 0;
    header("Location:index.php");
}

//if($_SESSION["table_empty_error"] === 1 || $_SESSION["user_no_match_error"] === 1) {
//    header("Location:index.php"); 
//}

if($check === 1){
    header("Location:Welcome/welcome.php");
}





?>