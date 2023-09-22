<?php
    $individual_msg = "";
    $sender_chat = "";
   $receiver_query = "SELECT receiverid FROM messages WHERE senderid='$userid'";
    $receiver_response = mysqli_query($connection , $receiver_query);
    if($receiver_response) {
        if(mysqli_num_rows($receiver_response) > 0) {
            while($row = mysqli_fetch_assoc($receiver_response)) {
                $receiver_id = $row["receiverid"];
                $receiver_name_query = "SELECT name from users WHERE userid='$receiver_id'";
                $receiver_name_response = mysqli_query($connection , $receiver_name_query);
                if($receiver_name_response) {
                    if(mysqli_num_rows($receiver_name_response) > 0) {
                        $receiver_name_row = mysqli_fetch_assoc($receiver_name_response);
                        $get_receiver_name = $receiver_name_row["name"];
                    }
                }
                
                $message_sent_query = "SELECT message FROM messages WHERE senderid='$userid' and receiverid='$receiver_id'";
                $message_sent_response = mysqli_query($connection , $message_sent_query);
                if($message_sent_response) {
                    if(mysqli_num_rows($message_sent_response)) {
                        while($msg_row = mysqli_fetch_assoc($message_sent_response)) {
                        $individual_msg = '<div class="user-info" id="1">
                    <div class="user-image-container">
                        <img src="./img/user-7.jfif" alt="User">
                    </div>
                    <div class="user-info-plus-message-container">
                        <div class="user-info-container">
                            <h4>'.$get_receiver_name.'</h4>
                        </div>
                        <div class="user-message-container">
                            <p>You :'.$msg_row["message"].'</p>
                        </div>
                    </div>
                </div>';
//                            $sender_chat .= '<div class="sender-message-container">
//                    <span>'.$msg_row["message"].'</span>
//                </div>';
                        }
                    }
                }
                $message_received_query = "SELECT message FROM messages WHERE senderid='$receiver_id' and receiverid='$userid'";
                $message_received_response = mysqli_query($connection , $message_received_query);
                if($message_received_response) {
                    if(mysqli_num_rows($message_received_response) > 0) {
                        while($msg_rec_row = mysqli_fetch_assoc($message_received_response)) {
//                            $receiver_chat ="                    <div class='receiver-message-container'>
//                        <span>".$msg_rec_row["message"]."</span>
//                    </div>";
//                            echo $receiver_chat;
                        }
                    }
                    
                }
            }
        }
    }

?>