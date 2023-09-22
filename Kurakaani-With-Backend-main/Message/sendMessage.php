<?php

session_start();
$to_user = $_SESSION["to_userid"];
$current_user = $_SESSION["user_id"];

include_once '../setMessage.php';

if(isset($_POST["send-button"])) {
    $message = $_POST["message"];
    
    $query = "INSERT INTO messages(senderid , receiverid , message) VALUES('$current_user' , '$to_user' , '$message')";
    
    $response = mysqli_query($connection , $query);
    
    echo $message;
    
    header("Location:message.php");
    
    
    
}


?>