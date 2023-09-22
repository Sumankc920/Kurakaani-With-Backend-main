<?php
    session_start();
    // to redirect to createaccount whenever we switch from sign in to create account
    $_SESSION["duplicate_login"] = 0;
    if(isset($_POST["submit"])) {
        include_once '../databaseConnection/settable.php';
        $first_name = $_POST["first-name"];
        $last_name = $_POST["last-name"];
        $email = $_POST["email"];
        $password = $_POST["first-password"];
        
        $full_name = $first_name." ".$last_name;
        $full_name = ucwords($full_name);
//        $password = md5($password);
        
        
        //from database connection
        if($table_response) {
            $check_query = "SELECT * FROM users WHERE email='$email' and password='$password'";
            $check = mysqli_query($connection , $check_query);
            if($check) {
                $rows = mysqli_num_rows($check);  
                if($rows > 0) {
                    $_SESSION["duplicate_login"] = 1;
                    echo "Error";
                    header("Location:createaccount.php");
                }else {
                    if(isset($_FILES["image-file"])) {
                        $file = $_FILES["image-file"];
                        $filename = $file["name"];
                        
                        $tmp_location = $file["tmp_name"];
                        $uid = uniqid('' , true);
                        $new_filename = $uid.$filename;
                        $new_location = "../uploads/".$new_filename;
                        if(move_uploaded_file($tmp_location , $new_location)) {
                            $userid = uniqid("" , true);
                            $insert_value_query = "INSERT IGNORE INTO users(name , email , password , userid , image , status) VALUES('$full_name' , '$email' , '$password' , '$userid' , '$new_filename' , 'Active')";
                            $insert_value_response = mysqli_query($connection , $insert_value_query);
                            if($insert_value_response) {
                                echo "Value inserted";
                                $_SESSION["duplicate_login"] = 100;
                                $_SESSION["user_id"] = $userid;
                                header("Location:../Welcome/welcome.php");
                            }else {
                                echo "Error inserting value";
                            }   
                        }
                    }else {
                        $filename = $_POST["jsimagename"];
                        $userid = uniqid("" , true);
                        $insert_value_query = "INSERT IGNORE INTO users(name , email , password , userid , image , status) VALUES('$full_name' , '$email' , '$password' , '$userid' , '$filename' , 'Active')";
                        $insert_value_response = mysqli_query($connection , $insert_value_query);
                        if($insert_value_response) {
                            echo "Value inserted";
                            $_SESSION["duplicate_login"] = 100;
                            $_SESSION["user_id"] = $userid;
                            header("Location:../Welcome/welcome.php");
                        }else {
                            echo "Error inserting value";
                        } 
                    }  
                }
            }
        }else {
            echo "Error creating table";
            $_SESSION["table_creation_error"] = 1;
        }
        
    }
    // to remove the popup when we go back from sign in to add account
    if(isset($_SESSION["duplicate_login"])) {
        if($_SESSION["duplicate_login"] === 0) {
            header("Location:createaccount.php");          
        }  
    }

        

?>
