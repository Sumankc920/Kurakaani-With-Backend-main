<?php
session_start();
//$servername = "sql301.epizy.com";
//$username = "epiz_29126545";
//$password = "053OlRqPwYrCjZ";
//
//$databasename = "epiz_29126545_kurakaani";

$connection = mysqli_connect("localhost" , "root" , "" , "kurakaaniusers");

$id = $_POST["id"];

$query = "SELECT * FROM users WHERE userid='$id'";

$response = mysqli_query($connection , $query);

if($response){
    $row = mysqli_fetch_assoc($response);
    $status = $row["status"];
    $style="";
    if($status !== "Active"){
        $style="background-color : red;";
    }
    $html_send = '<div class="user-image-and-name-container">
                        <div class="active-icon-container">
                            <div class="active-icon" style="'.$style.'">
                            </div>
                        </div>
                        <div class="user-spec-image-and-active-status">
                            <img src="../uploads/'.$row["image"].'">
                            <div class="user-name-and-active-status">
                                <h3>'.$row["name"].'</h3>
                                <p>'.$row["status"].'</p>
                            </div>
                        </div>
                    </div>
                    <div class="icons-container">
                        <ion-icon name="videocam-outline" class="videocall-icon"></ion-icon>
                        <ion-icon name="call-outline" class="audiocall-icon"></ion-icon>
                        <ion-icon name="ellipsis-vertical-outline" class="options-icon"></ion-icon>
                    </div>';
}

echo $html_send;

?>