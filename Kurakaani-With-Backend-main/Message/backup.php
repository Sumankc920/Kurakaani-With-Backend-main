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
        $final_message = "";
        $final_messages_array = [];
        $receiver_query = "SELECT receiverid FROM messages WHERE senderid='$userid'";
        $receiver_response = mysqli_query($connection , $receiver_query);
        $sender_query = "SELECT senderid FROM messages WHERE receiverid='$userid'";
        $sender_response = mysqli_query($connection , $sender_query);
        if($receiver_response) {
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
                            $sent_message = "";
                            $received_message = "";
                            // for either of the sent or received message
                            $sent_message_query = "SELECT message FROM messages WHERE senderid='$userid' and receiverid='$receiver_id'";
                            $received_message_query = "SELECT message FROM messages WHERE senderid='$receiver_id' and receiverid='$userid'";

                            $sent_message_response = mysqli_query($connection , $sent_message_query);
                            $received_message_response = mysqli_query($connection , $received_message_query);

                            if($sent_message_response) {
                                if(mysqli_num_rows($sent_message_response) > 0) {
                                    $receiver_messaged = 1;
                                    $sender_messaged = 0;
                                    while($sent_message_row = mysqli_fetch_assoc($sent_message_response)) {
                                        $sent_message = $sent_message_row["message"];
                                    }
                                }
                            }

                            if($received_message_response) {
                                if(mysqli_num_rows($received_message_response) > 0) {
                                    $receiver_messaged = 1;
                                    $sender_messaged = 0;
                                    while($received_message_row = mysqli_fetch_assoc($received_message_response)) {
                                        $received_message = $received_message_row["message"];
                                    }
                                }
                            }

                            // comapring id of the sent message and received message and showing the last sent or received message in the ui
                            if($sent_message!=="") {
                                $sent_message_id = "SELECT id FROM messages WHERE message='$sent_message'";
                                $sent_message_id_response = mysqli_query($connection , $sent_message_id);
                                if($sent_message_id_response) {
                                    $sent_message_id_row = mysqli_fetch_assoc($sent_message_id_response);
                                    $sent_message_id = $sent_message_id_row["id"];
                                }

                            }

                            if($received_message!=="") {
                                $received_message_id = "SELECT id FROM messages WHERE message='$received_message'";
                                $received_message_id_response = mysqli_query($connection , $received_message_id);
                                if($received_message_id_response) {
                                    $received_message_id_row = mysqli_fetch_assoc($received_message_id_response);
                                    $received_message_id = $received_message_id_row["id"];
                                }

                            }

                        }
                    }
                    if($receiver_messaged===1) {
                        if($sent_message_id > $received_message_id) {
                            $message = "You : ".$sent_message;
                        }elseif($received_message_id > $sent_message_id) {
                            $message = $received_message;
                        }

                        array_push($receiver_names_array,$get_receiver_name);
                        $current_message = [$get_receiver_name => $message];
                        $receiver_messages_array = array_merge($receiver_messages_array , $current_message);

                    }
                }
                print_r($receiver_messages_array);

//                if($receiver_messaged === 1) {
//                    $receiver_names_array = array_unique($receiver_names_array);
//                    foreach($receiver_messages_array as $name => $message){
//                        $receiver_individual_msg .= '<div class="user-info" id="1">
//                                <div class="user-image-container">
//                                <img src="./img/user-7.jfif" alt="User">
//                            </div>
//                            <div class="user-info-plus-message-container">
//                                <div class="user-info-container">
//                                    <h4>'.$name.'</h4>
//                                </div>
//                                <div class="user-message-container">
//                                    <p>'.$message.'</p>
//                                </div>
//                            </div>
//                            </div>'; 
//                    }   
//                }
            }
        }
        if($sender_response) {
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
                                // for either of the sent or received message
                                $sent_message_query = "SELECT message FROM messages WHERE senderid='$userid' and receiverid='$sender_id'";
                                $received_message_query = "SELECT message FROM messages WHERE senderid='$sender_id' and receiverid='$userid'";

                                $sent_message_response = mysqli_query($connection , $sent_message_query);
                                $received_message_response = mysqli_query($connection , $received_message_query);

                                if($sent_message_response) {
                                    if(mysqli_num_rows($sent_message_response) > 0) {
                                        $sender_messaged = 1;
                                        $receiver_messaged = 0;
                                        while($sent_message_row = mysqli_fetch_assoc($sent_message_response)) {
                                            $sent_message = $sent_message_row["message"];
                                        }
                                    }
                                }

                                if($received_message_response) {
                                    if(mysqli_num_rows($received_message_response) > 0) {
                                        $sender_messaged = 1;
                                        $receiver_messaged = 0;
                                        while($received_message_row = mysqli_fetch_assoc($received_message_response)) {
                                            $received_message = $received_message_row["message"];
                                        }
                                    }
                                }

                                // comapring id of the sent message and received message and showing the last sent or received message in the ui
                                if($sent_message!=="") {
                                    $sent_message_id = "SELECT id FROM messages WHERE message='$sent_message'";
                                    $sent_message_id_response = mysqli_query($connection , $sent_message_id);
                                    if($sent_message_id_response) {
                                        $sent_message_id_row = mysqli_fetch_assoc($sent_message_id_response);
                                        $sent_message_id = $sent_message_id_row["id"];
                                    }

                                }

                                if($received_message!=="") {
                                    $received_message_id = "SELECT id FROM messages WHERE message='$received_message'";
                                    $received_message_id_response = mysqli_query($connection , $received_message_id);
                                    if($received_message_id_response) {
                                        $received_message_id_row = mysqli_fetch_assoc($received_message_id_response);
                                        $received_message_id = $received_message_id_row["id"];
                                    }

                                }

                            }
                        }
                        if($sender_messaged===1) {
                            if($sent_message_id > $received_message_id) {
                                $message = "You : ".$sent_message;
                            }elseif($received_message_id > $sent_message_id) {
                                $message = $received_message;
                            }

                            array_push($sender_names_array,$get_sender_name);
                            $current_message = [$get_sender_name => $message];
                            print_r($current_message);
                            $sender_messages_array = array_merge($sender_messages_array , $current_message);

                        }
                    }
//                    print_r($sender_messages_array);
//                    foreach($current_message as $key => $value){
//                        echo $key;
//                    }
//                print_r($sender_messages_array);

//                    if($sender_messaged === 1) {
//                        $sender_names_array = array_unique($sender_names_array);
//                        foreach($sender_messages_array as $name => $message){
//                            $sender_individual_msg .= '<div class="user-info" id="'.$sender_id.'">
//                                    <div class="user-image-container">
//                                    <img src="./img/user-7.jfif" alt="User">
//                                </div>
//                                <div class="user-info-plus-message-container">
//                                    <div class="user-info-container">
//                                        <h4>'.$name.'</h4>
//                                    </div>
//                                    <div class="user-message-container">
//                                        <p>'.$message.'</p>
//                                    </div>
//                                </div>
//                                </div>'; 
//                        }   
//                    }
                }
//            echo $sender_id;
        }
//        if($receiver_messaged === 1 and $sender_messaged === 0) {
//            $final_messages_array = array_merge($receiver_messages_array , $sender_messages_array);
//        }elseif($sender_messaged === 1 and $receiver_messaged ===0) {
//            $final_messages_array = array_merge($sender_messages_array , $receiver_messages_array);
//        }
//        foreach($final_messages_array as $name => $message) {
//            $final_message .= '<div class="user-info" id="1">
//                    <div class="user-image-container">
//                    <img src="./img/user-7.jfif" alt="User">
//                </div>
//                <div class="user-info-plus-message-container">
//                    <div class="user-info-container">
//                        <h4>'.$name.'</h4>
//                    </div>
//                    <div class="user-message-container">
//                        <p>'.$message.'</p>
//                    </div>
//                </div>
//                </div>';    
//        }
//        echo $final_message;
        
    }



?>