<?php
    session_start();
//    $servername = "sql301.epizy.com";
//    $username = "epiz_29126545";
//    $password = "053OlRqPwYrCjZ";
//    
//    $databasename = "epiz_29126545_kurakaani";
    
    $connection = mysqli_connect("localhost" , "root" , "" , "kurakaaniusers");

    $user = $_POST["user"];

    // converts the $user escapes special chars in string for use in SQL query
    $user = mysqli_real_escape_string($connection , $user);

    $search_query = "SELECT * FROM users WHERE name LIKE '$user'";

    $search_response = mysqli_query($connection , $search_query);

    $search_output = "";

    if($search_response){
        if(mysqli_num_rows($serch_response) > 0){
            $search_output = "hello";
        }else{
            $search_output .= "No match";
        }
    }

    echo $search_output;

    

?>