<?php

//    $servername = "sql301.epizy.com";
//    $username = "epiz_29126545";
//    $password = "053OlRqPwYrCjZ";
//    
//    $databasename = "epiz_29126545_kurakaani";
    
    $connection = mysqli_connect("localhost" , "root" , "" , "kurakaaniusers");
    if($connection){
        $message_table = "CREATE TABLE IF NOT EXISTS messages(id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY , senderid VARCHAR(25) NOT NULL , receiverid VARCHAR(25) NOT NULL , message VARCHAR(2000) NOT NULL)";
        $message_table_response = mysqli_query($connection , $message_table);
    }else{
        echo "Unable to connect to the database";
    }


?>
