<?php

session_start();
$to_user = $_SESSION["to_userid"];
$current_user = $_SESSION["user_id"];

include_once '../setMessage.php';

include_once "../databaseConnection/settable.php";
if(isset($_SESSION["user_id"])) {
    include_once '../setMessage.php';
    $userid = $_SESSION["user_id"];
    $username_query = "SELECT name,status FROM users WHERE userid='$userid'";
    $username_response = mysqli_query($connection , $username_query);
    if($username_response) {
        if(mysqli_num_rows($username_response) > 0) {
            $row = mysqli_fetch_assoc($username_response);
            $username = $row["name"];
            $user_status = $row["status"];
        }
    }
}else {
    header("Location:../check-user.php");
}


    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Welcome ! - Find and Message your loved ones.</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width , initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="message.css">
    </head>
    <body>
        <section class="message-section">
            <div class="online-preview-container">
                <div class="your-message-container">
                    <h2>Your Messages</h2>
                </div>
                <div class="online-preview-container__user-search-container">
                    <form name="user-search" class="user-search-form" method="get" action="#">
                        <input type="text" placeholder="Search..." class="user-search">
                    </form>
                </div>
                <div class="online-preview-container__online-users-container">
<!--
                    <div class="user-info" id="1">
                        <div class="user-image-container">
                            <img src="./img/user-7.jfif" alt="User">
                        </div>
                        <div class="user-info-plus-message-container">
                            <div class="user-info-container">
                                <h4>Anibas</h4>
                            </div>
                            <div class="user-message-container">
                                <p>You : thik tah xa ni?</p>
                            </div>
                        </div>
                    </div>
-->
                </div> 
                <div class="welcome-page-redirect">
                    <a href="../Welcome/welcome.php">Go to Welcome Page</a>
                </div> 
            </div>
            <?php ?>
            <div class="messages-container">
                <div class="user-title-container">
                    <div class="hamburger">
                        <ion-icon name="reorder-three-outline" class="hamburger-icon"></ion-icon>                    
                    </div>
<!--
                    <div class="user-image-and-name-container">
                        <div class="active-icon-container">
                            <div class="active-icon" style="opacity : 0;">
                            </div>
                        </div>
                        <div class="user-spec-image-and-active-status">
                            <img src="./img/user-1.jfif" alt="user-1" style="opacity : 0;">
                            <div class="user-name-and-active-status">
                                <h3 style="opacity : 0;"><?php echo $username;?></h3>
                                <p style="opacity : 0;"><?php echo $user_status; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="icons-container">
                        <ion-icon name="videocam-outline" class="videocall-icon" style="opacity : 0;"></ion-icon>
                        <ion-icon name="call-outline" class="audiocall-icon" style="opacity : 0;"></ion-icon>
                        <ion-icon name="ellipsis-vertical-outline" class="options-icon" style="opacity : 0;"></ion-icon>
                    </div>
-->
                </div>
                <div class="user-messages-container">
<!--
                    <div class="sender-message-container">
                        <span >Hello</span>
                    </div>
                    
-->
                </div>
            </div>
            <div class="backdrop">

            </div>
            <div class="enter-message-container">
                <div class="other-files-container">
                    <ion-icon name="add-circle-outline" class="other-files-icon"></ion-icon>
                </div>
                <div class="message-box-container">
                    <form class="message-form" name="message-form" method="post" action="./sendMessage.php" class="message-form">
                        <div class="text-container">
                            <input type="text" class="message-text" placeholder="Enter message" name="message" autocomplete="off">
                            <button type="submit" name="send-button"><ion-icon name="send-sharp" class="send-button"></ion-icon></button>
                        </div>
                    </form>
                </div>
                <div class="emoji-container">
                    <ion-icon name="thumbs-up-outline" class="thumbs-up-emoji"></ion-icon>
                </div>
            </div>
        </section>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script src="message.js"></script>
        <script type="module" src="https://unpkg.com/ionicons@5.4.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule="" src="https://unpkg.com/ionicons@5.4.0/dist/ionicons/ionicons.js"></script>
    </body>
</html>