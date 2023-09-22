<?php
    session_start();
    if(isset($_SESSION["user_id"])){
        include_once '../databaseConnection/settable.php';
        $id = $_SESSION["user_id"];
        
        $query = "UPDATE users SET status='Not Active' WHERE userid='$id'";
        $response = mysqli_query($connection , $query);
        
        if($response){
            session_destroy();
            $_SESSION["user_no_match_error"] = 0;
            $_SESSION["table_empty_error"] = 0;
            header("Location:../index.php");
        }
        
    }
?>