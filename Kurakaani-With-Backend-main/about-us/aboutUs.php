<?php
//    session_start();
//    $current_user_id = $_SESSION["user_id"];
//    $connection = mysqli_connect("localhost" , "root" , "" , "kurakaaniusers");
//
//    if($connection){
//        $query = "SELECT image FROM users WHERE user_id = '$current_user_id'";
//        $response = mysqli_query($connection , $query);
//        if($response){
//            $row = mysqli_fetch_assoc($response);
//            $image = $row["image"];
//            $user_image = '<img src="../uploads/'.$image.'">';
//        }
//    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width , initial-scale=1.0">
    <title>Wanna Know about the Team</title>
    <link rel="stylesheet" type="text/css" href="aboutUs.css">
</head>
<body>
    <div class="main-container">
        <nav>
           <div class="logo-container">
               <img src="../Welcome/img/logo.jpg" alt="kurakaani-logo" class="kurakaani-logo">
           </div>
            <ul class="nav-list">
               <li><a href="../Message/message.php">Message Zone</a></li>
               <li><a href="../about-us/aboutUs.php" style="color : #e67e22;">About Us</a></li>
                <li><a href="../Welcome/welcome.php" class="logout-link">Logout</a></li>
            </ul>
        </nav>
       <div class="short-description-container">
           Hello Everyone , We are the students of NCIT College , Balkumari , Lalitpur currently studying in Undergraduate Level of Software Engineering , batch of 2019. This website was created with the involvement of we three brothers. Also , this would not have been possible without the help of our teacher , Mr. Ramu Pandey sir. Below are the list of our team.
       </div>
       <div class="other-items-container">
            <div class="teachers-container">
                <div class="teacher-title-container">
                    Teacher
                </div>
                <div class="teacher">
                  <div class="teacher-info">
                        <img src="../Welcome/img/admin-1.jpg" alt="Rkesh Silwal" class="admin-1-img">
                        <span>Ramu Pandey</span>
                  </div>
                </div>
            </div>
            <div class="admins-container">
                <div class="title-container">
                    Admins
                </div>
                <div class="admins admin-1">
                  <div class="admin-info">
                        <img src="../Welcome/img/admin-1.jpg" alt="Rkesh Silwal" class="admin-1-img">
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
                        <img src="../Welcome/img/admin-2.jpg" alt="Arun Bikram" class="admin-2-img">
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
                        <img src="../Welcome/img/admin-3.jpg" alt="Suman Kc" class="admin-3-img">
                        <span>Suman Kc</span>
                    </div>
                    <div class="icons-container">
                        <i class="fas fa-comment-alt"></i>
                        <i class="fas fa-phone"></i>
                        <i class="fas fa-info-circle"></i>
                    </div>
                </div>
            </div>
       </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@5.4.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.4.0/dist/ionicons/ionicons.js"></script>
</body>
</html>