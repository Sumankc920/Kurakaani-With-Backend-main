<?php 
    session_start();
    if(isset($_SESSION["user_id"])) {
        $userid = $_SESSION["user_id"];
        include_once '../setMessage.php';
        $receiver_messaged = 0;
        $sender_messaged = 0;
        $receiver_names_array = [];
        $receiver_messages_array = [];
        $sender_names_array = [];
        $sender_messages_array = [];
        $received_message_id = -1;
        $sent_message_id = -1;
        $final_message_html = "";
        $final_messages_array = [];
        $receiver_query = "SELECT receiverid FROM messages WHERE senderid='$userid'";
        $receiver_response = mysqli_query($connection , $receiver_query);
        $sender_query = "SELECT senderid FROM messages WHERE receiverid='$userid'";
        $sender_response = mysqli_query($connection , $sender_query);
        if($receiver_response or $sender_response) {
            if(mysqli_num_rows($receiver_response) > 0) {
                $receiver_individual_msg = "";
                while($row = mysqli_fetch_assoc($receiver_response)) {
                    $receiver_id = $row["receiverid"];
                    $receiver_name_query = "SELECT name from users WHERE userid='$receiver_id'";
                    $receiver_name_response = mysqli_query($connection , $receiver_name_query);
                    if($receiver_name_response) {
                        if(mysqli_num_rows($receiver_name_response) > 0) {
                            $receiver_name_row = mysqli_fetch_assoc($receiver_name_response);
                            $get_receiver_name = $receiver_name_row["name"];
                            $received_message = "";
                            $sent_message_query = "SELECT message FROM messages WHERE senderid='$userid' AND receiverid='$receiver_id'";

                            $sent_message_response = mysqli_query($connection , $sent_message_query);

                            if($sent_message_response) {
                                if(mysqli_num_rows($sent_message_response) > 0) {
                                    $receiver_messaged = 1;
                                    $sender_messaged = 0;
                                    while($sent_message_row = mysqli_fetch_assoc($sent_message_response)) {
                                        $sent_message = $sent_message_row["message"];
                                    }
                                }
                            }

                            if($sent_message!=="") {
                                $sent_message_id = "SELECT id FROM messages WHERE message='$sent_message' AND senderid='$userid'";
                                $sent_message_id_response = mysqli_query($connection , $sent_message_id);
                                if($sent_message_id_response) {
                                    $sent_message_id_row = mysqli_fetch_assoc($sent_message_id_response);
                                    $sent_message_id = $sent_message_id_row["id"];
                                }

                            }


                        }
                    }
                    if($receiver_messaged===1) {
//                        $message = "You : ".$sent_message;
                        $message = $sent_message;

                        array_push($receiver_names_array,$get_receiver_name);
                        $current_message = [$get_receiver_name => $message];
                        $receiver_messages_array = array_merge($receiver_messages_array , $current_message);

                    }
                }
            }
            
            
            if(mysqli_num_rows($sender_response) > 0) {
                    $sender_individual_msg = "";
                    while($row = mysqli_fetch_assoc($sender_response)) {
                        $sender_id = $row["senderid"];
                        $sender_name_query = "SELECT name from users WHERE userid='$sender_id'";
                        $sender_name_response = mysqli_query($connection , $sender_name_query);
                        if($sender_name_response) {
                            if(mysqli_num_rows($sender_name_response) > 0) {
                                $sender_name_row = mysqli_fetch_assoc($sender_name_response);
                                $get_sender_name = $sender_name_row["name"];
                                $sent_message = "";
                                $received_message = "";

                                $received_message_query = "SELECT message FROM messages WHERE senderid='$sender_id' AND receiverid='$userid'";
                                $received_message_response = mysqli_query($connection , $received_message_query);

                                if($received_message_response) {
                                    if(mysqli_num_rows($received_message_response) > 0) {
                                        $sender_messaged = 1;
                                        $receiver_messaged = 0;
                                        while($received_message_row = mysqli_fetch_assoc($received_message_response)) {
                                            $received_message = $received_message_row["message"];
                                        }
                                    }
                                }

                                if($received_message!=="") {
                                    $received_message_id = "SELECT id FROM messages WHERE message='$received_message' AND receiverid='$userid'";
                                    $received_message_id_response = mysqli_query($connection , $received_message_id);
                                    if($received_message_id_response) {
                                        $received_message_id_row = mysqli_fetch_assoc($received_message_id_response);
                                        $received_message_id = $received_message_id_row["id"];
                                    }

                                }

                            }
                        }
                        if($sender_messaged===1) {
                            $message = $received_message;

                            array_push($sender_names_array,$get_sender_name);
                            $current_message = [$get_sender_name => $message];
                            $sender_messages_array = array_merge($sender_messages_array , $current_message);

                        }
                    }
                }
            
            // now findout the greater id of the message from same users meaning the recent sent or received message;
            $final_messages_array = [];
            $final_ids_array = [];
            if(sizeof($receiver_messages_array) === sizeof($sender_messages_array)) {
                    foreach($receiver_messages_array as $name => $message) {

                        $another_user_query = "SELECT userid FROM users WHERE name='$name'";
                        $another_user_response = mysqli_query($connection , $another_user_query);
                        $row = mysqli_fetch_assoc($another_user_response);
                        $another_user_id = $row["userid"];
                        
                        $receiver_message = $receiver_messages_array[$name];
                        $sender_message = $sender_messages_array[$name];

                        $first_query = "SELECT id FROM messages WHERE message='$receiver_message' AND senderid='$userid' AND receiverid='$another_user_id' ORDER BY id DESC";
                        $second_query = "SELECT id FROM messages WHERE message='$sender_message' AND receiverid='$userid' AND senderid='$another_user_id' ORDER BY id DESC";

                        $first_response = mysqli_query($connection , $first_query);
                        $second_response = mysqli_query($connection , $second_query);

                        $first_id = mysqli_fetch_assoc($first_response)["id"];
                        $second_id = mysqli_fetch_assoc($second_response)["id"]; 

                        if($first_id > $second_id) {
                            $final_message = "You : ".$receiver_message;
                            $final_ids_array[$name] = $first_id;
                        }elseif($second_id > $first_id) {
                            $final_message = $sender_message;
                            $final_ids_array[$name] = $second_id;
                        }
                        $final_messages_array[$name] = $final_message;
                }   
            }elseif(sizeof($receiver_messages_array) > sizeof($sender_messages_array)) {
                    foreach($receiver_messages_array as $name => $message) {
                        
                        $another_user_query = "SELECT userid FROM users WHERE name='$name'";
                        $another_user_response = mysqli_query($connection , $another_user_query);
                        $row = mysqli_fetch_assoc($another_user_response);
                        $another_user_id = $row["userid"];
                        
                        $receiver_message = $receiver_messages_array[$name];
                        $sender_message = $sender_messages_array[$name];

                        if($sender_message) {
                            $first_query = "SELECT id FROM messages WHERE message='$receiver_message' AND senderid='$userid' AND receiverid='$another_user_id' ORDER BY id DESC";
                            $second_query = "SELECT id FROM messages WHERE message='$sender_message' AND receiverid='$userid' AND senderid='$another_user_id' ORDER BY id DESC";
                            
                            $first_response = mysqli_query($connection , $first_query);
                            $second_response = mysqli_query($connection , $second_query);
                            
                            $first_id = mysqli_fetch_assoc($first_response)["id"];
                            $second_id = mysqli_fetch_assoc($second_response)["id"];
                            

                            if($first_id > $second_id) {
                                $final_message = "You : ".$receiver_message;
                                $final_ids_array[$name] = $first_id;
                            }elseif($second_id > $first_id) {
                                $final_message = $sender_message;
                                $final_ids_array[$name] = $second_id;
                            }
                            $final_messages_array[$name] = $final_message;
                        }else {
                            $single_query = "SELECT id FROM messages WHERE message='$receiver_message' AND senderid='$userid' AND receiverid='$another_user_id' ORDER BY id DESC";
                            
                            $single_response = mysqli_query($connection , $single_query);
                            
                            $single_id = mysqli_fetch_assoc($single_response)["id"];
                            
                            
                            $final_ids_array[$name] = $single_id;
                            
                            $final_messages_array[$name] = "You : ".$receiver_message;
                        }
                        
                    } 
            }elseif(sizeof($sender_messages_array) > sizeof($receiver_messages_array)) {
                foreach($sender_messages_array as $name => $message) {
                    
                    $another_user_query = "SELECT userid FROM users WHERE name='$name'";
                    $another_user_response = mysqli_query($connection , $another_user_query);
                    $row = mysqli_fetch_assoc($another_user_response);
                    $another_user_id = $row["userid"];
                    
                    
                    $receiver_message = $receiver_messages_array[$name];
                    $sender_message = $sender_messages_array[$name];
                    
                    if($receiver_message) {
                        
                        $first_query = "SELECT id FROM messages WHERE message='$receiver_message' AND senderid='$userid' AND receiverid='$another_user_id' ORDER BY id DESC";
                        $second_query = "SELECT id FROM messages WHERE message='$sender_message' AND receiverid='$userid' AND senderid='$another_user_id' ORDER BY id DESC";

                        $first_response = mysqli_query($connection , $first_query);
                        $second_response = mysqli_query($connection , $second_query);

                        $first_id = mysqli_fetch_assoc($first_response)["id"];
                        $second_id = mysqli_fetch_assoc($second_response)["id"];

                        if($first_id > $second_id) {
                            $final_message = "You : ".$receiver_message;
                            $final_ids_array[$name] = $first_id;
                        }elseif($second_id > $first_id) {
                            $final_message = $sender_message;
                            $final_ids_array[$name] = $second_id;
                        }
                        $final_messages_array[$name] = $final_message;
                          
                    }else {
                        $single_query = "SELECT id FROM messages WHERE message='$sender_message' AND receiverid='$userid' AND senderid='$another_user_id' ORDER BY id DESC";

                        $single_response = mysqli_query($connection , $single_query);

                        $single_id = mysqli_fetch_assoc($single_response)["id"];
                        

                        $final_ids_array[$name] = $single_id;

                        $final_messages_array[$name] = $sender_message;
                        }
                    
                } 
            }
            arsort($final_ids_array);
            foreach($final_ids_array as $name => $index) {
                $final_ids_array[$name] = $final_messages_array[$name];
            }
            
            foreach($final_ids_array as $name => $message) {
                $user_uniq_id_query = "SELECT userid , image FROM users WHERE name='$name'";
                $user_uniq_id_response = mysqli_query($connection , $user_uniq_id_query);
                $unique_id = mysqli_fetch_assoc($user_uniq_id_response);
                $image = $unique_id["image"];
                $unique_id = $unique_id["userid"];
                $final_message_html .= '<div class="user-info" id="'.$unique_id.'">
                        <div class="user-image-container">
                        <img src="../uploads/'.$image.'" alt="User">
                    </div>
                    <div class="user-info-plus-message-container">
                        <div class="user-info-container">
                            <h4 class="user-info-heading">'.$name.'</h4>
                        </div>
                        <div class="user-message-container">
                            <p class="user-info-message">'.$message.'</p>
                        </div>
                    </div>
                    </div>';    
            }
            
            echo $final_message_html;
            
            
            
//            echo "Sent message";
//            print_r($receiver_messages_array);
//            echo "receiver message";
//            print_r($sender_messages_array);
            
            
            
            
        }}


?>