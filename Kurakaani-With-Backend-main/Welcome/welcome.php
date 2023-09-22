<?php
    include_once "../databaseConnection/settable.php";
    if(isset($_SESSION["user_id"])) {
        $user_session = $_SESSION["user_id"];
//        echo $user_session;
        $user_name_query = "SELECT name,image FROM users WHERE userid='$user_session'";
        $user_name_response = mysqli_query($connection , $user_name_query);
        if($user_name_response) {
            if(mysqli_num_rows($user_name_response) > 0) {
                $row = mysqli_fetch_assoc($user_name_response);
                $username = $row["name"];
                $welcome_user = '<h3>Welcome , '.$username.'</h3>';
                $image = $row["image"];
                $user_image = '<img src="../uploads/'.$image.'" alt="no-user-logo" class="no-user-logo">';
            }   
        }else {
            echo "no_user_error";
        }
        $all_users_query = "SELECT name , image FROM users WHERE userid != '$user_session'";
        $all_users_response = mysqli_query($connection , $all_users_query);
        $all_users = '<p style="text-align:center; margin-top:15px;">No users to show.</p>';
        if($all_users_response) {
            if(mysqli_num_rows($all_users_response) > 0) {
                $all_users = '';
                while($row = mysqli_fetch_assoc($all_users_response)) {
                    $all_users .= '<div class="users"><div class="user-info"><img src="../uploads/'.$row['image'].'" alt="user" class="user-1-img"><span>'.$row['name'].'</span></div><div class="users-icon-container"><i class="fas fa-comment-alt"></i><i class="fas fa-phone"></i></i><i class="fas fa-user-plus"></i></div></div>';
                }
            }
        }
        
    }else {
        echo "Error";
    }

    if(isset($_POST["message-button"])) {
        include_once '../setMessage.php';
        $sender_id = $_SESSION["user_id"];
        $receiver_name = $_POST["receiver-name"];
        $message = $_POST["message"];
        
        
        if(!empty($message)) {
            $receiver_id_query = "SELECT userid FROM users WHERE name='$receiver_name'";
            $receiver_id_response = mysqli_query($connection , $receiver_id_query);
            if($receiver_id_response) {
                if(mysqli_num_rows($receiver_id_response) > 0) {
                    $row = mysqli_fetch_assoc($receiver_id_response);
                    $receiver_id = $row["userid"];
                }
            }
            echo $sender_id;
            echo $receiver_id;
            echo $receiver_name;
            echo $message;

            $message_send_query = "INSERT INTO messages(senderid , receiverid , message) VALUES('$sender_id' , '$receiver_id' , '$message')";

            $message_send_response = mysqli_query($connection , $message_send_query);
            header("Location:../Message/message.php");   
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width , initial-scale = 1.0">
    <title>Welcome , <?php echo $username;?></title>
    <link rel="stylesheet" type="text/css" href="welcome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
   <div class="layer"></div>
    <div class="info-container">
        <div class="heading-container">
            <?php echo $welcome_user; ?>
        </div>
        <div class="app-info-container">
            <p>You are successfully signed up. Using our site , you can communicate with friends and family all over the globe.</p>
        </div>
        <div class="button-container">
            <button class="ok-button">Ok</button>
        </div>
    </div> 
    <div class="logout-info-container">
        <h4>Logging out! Are you sure?</h4>
        <button class="logout-ok-button">Yes</button>
    </div>
    <nav>
       <div class="logo-container">
           <img src="./img/logo.jpg" alt="kurakaani-logo" class="kurakaani-logo">
       </div>
        <ul class="nav-list">
           <li><a href="../Message/message.php">Message Zone</a></li>
           <li><a href="../about-us/aboutUs.php">About Us</a></li>
            <li><a href="#" class="logout-link">Logout</a></li>
            <li><?php echo $user_image; ?></li>
        </ul>
    </nav>
    <div class="other-items-container">
        <div class="admins-container">
            <div class="title-container">
                Admins
            </div>
            <div class="admins admin-1">
              <div class="admin-info">
                    <img src="./img/admin-1.jpg" alt="Rkesh Silwal" class="admin-1-img">
                    <span>Rikesh Silwal</span>
              </div>
                <div class="icons-container">
                    <i class="fas fa-comment-alt"></i>
                    <i class="fas fa-phone"></i>
                    <i class="fas fa-info-circle"></i>
                </div>
            </div>
            <div class="admins admin-2">
              <div class="admin-info">
                    <img src="./img/admin-2.jpg" alt="Arun Bikram" class="admin-2-img">
                    <span>Arun Khatri</span>
              </div>
                <div class="icons-container">
                    <i class="fas fa-comment-alt"></i>
                    <i class="fas fa-phone"></i>
                    <i class="fas fa-info-circle"></i>
                </div>
            </div>
            <div class="admins admin-3">
                <div class="admin-info">
                    <img src="./img/admin-3.jpg" alt="Suman Kc" class="admin-3-img">
                    <span>Suman Kc</span>
                </div>
                <div class="icons-container">
                    <i class="fas fa-comment-alt"></i>
                    <i class="fas fa-phone"></i>
                    <i class="fas fa-info-circle"></i>
                </div>
            </div>
        </div>
        <div class="users-container">
            <div class="user-title-container">
                All Users
            </div>
            <?php echo $all_users; ?>
        </div>
<!--
        <div class="friends-container">
            <div class="friends-title-container">
                Friends
            </div>
            <div class="friends friend-1">
                <div class="friend-info">
                    <img src="./img/admin-1.jpg" alt="Rkesh Silwal" class="friend-1-img">
                    <span>Suraj Singht Basnet</span>
                </div>
                <div class="friends-icon-container">
                    <i class="fas fa-comment-alt"></i>
                    <i class="fas fa-phone"></i>
                    <i class="fas fa-video"></i>
                </div>
            </div>
        </div>
-->
    </div>
    <div class="popup-message-container">
       <div class="cross"></div>
       <div class="popup-header-container">
            <h2 class="popup-quick-header">Quick Message</h2>
       </div>
        <div class="to-from-container">
            <h3>To : <span class="to"></span></h2>
            <h3>From : <span><?php echo $username; ?></span></h3>
        </div>
        <div class="input-box-container">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="message-form">
                <input type="text" name="message" class="message-field">
                <input type="text" name="receiver-name" class="receiver-name" hidden>
                <button type="submit" name="message-button" class="send-button"><ion-icon name="send-sharp" class="send-button-icon"></button>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="welcome.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.4.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.4.0/dist/ionicons/ionicons.js"></script>
</body>
</html>