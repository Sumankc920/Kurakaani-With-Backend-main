<?php
session_start();
$logged_user = $_SESSION["user_id"];
//$servername = "sql301.epizy.com";
//$username = "epiz_29126545";
//$password = "053OlRqPwYrCjZ";
//
//$databasename = "epiz_29126545_kurakaani";

$connection = mysqli_connect("localhost" , "root" , "" , "kurakaaniusers");

$id = $_POST["id"];

$_SESSION["to_userid"] = $id;

$username_query = "SELECT name FROM users WHERE userid='$id'";

$username_response = mysqli_query($connection , $username_query);

$name = mysqli_fetch_assoc($username_response);

//        $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
//                WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
//                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
//        $query = mysqli_query($conn, $sql);
//        if(mysqli_num_rows($query) > 0){
//            while($row = mysqli_fetch_assoc($query)){
//                if($row['outgoing_msg_id'] === $outgoing_id){
//                    $output .= '<div class="chat outgoing">
//                                <div class="details">
//                                    <p>'. $row['msg'] .'</p>
//                                </div>
//                                </div>';
//                }else{
//                    $output .= '<div class="chat incoming">
//                                <img src="php/images/'.$row['img'].'" alt="">
//                                <div class="details">
//                                    <p>'. $row['msg'] .'</p>
//                                </div>
//                                </div>';
//                }
//            }
//        }else{
//            $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
//        }

$messages_query = "SELECT * FROM messages WHERE (senderid='$id' AND receiverid='$logged_user') OR (receiverid='$id' AND senderid='$logged_user') ORDER BY id";

$messages_response = mysqli_query($connection , $messages_query);


$message_html = "";

if($messages_response){
    if(mysqli_num_rows($messages_response) > 0) {
        while($row = mysqli_fetch_assoc($messages_response)) {
            if($row["senderid"] == $logged_user) {
                $message_html .= '<div class="sender-message-container"><span>'.$row["message"].'</span></div>';
            }elseif($row["senderid"] == $id) {
                $message_html .= '<div class="receiver-message-container"><span>'.$row["message"].'</span></div>';
            }
        }   
    }else {
        $message_html .= '<div class="empty-message">No Messages Sent Yet.</div>';
    }
}

echo $message_html;



//$message_html = "";
//
//$all_messages = [];
//$received_message_id = [];
//$sent_message_id = [];
//$all_messages_id = [];
//
//if($sent_messages_response) {
//    $sent_messages = [];
//    $id = -1;
//    while($row = mysqli_fetch_assoc($sent_messages_response)) {
//        $message = $row["message"];
//        $id_query = "SELECT id FROM messages WHERE message='$message'";
//        $id_response = mysqli_query($connection , $id_query);
//        $id  = mysqli_fetch_assoc($id_response);
//        $id = $id["id"];
//        $sm_id = ["received" => $id];
//        array_push($sent_message_id , $sm_id);
//        $sent_message = [$id => $message];
//        array_push($sent_messages , $sent_message);
//    }   
//    
//    array_push($all_messages , $sent_messages);
//    array_push($all_messages_id , $sent_message_id);
//}
//
//if($received_messages_response) {
//    $received_messages = [];
//    $id = -1;
//    while($row = mysqli_fetch_assoc($received_messages_response)) {
//        $message = $row["message"];
//        $id_query = "SELECT id FROM messages WHERE message='$message'";
//        $id_response = mysqli_query($connection , $id_query);
//        $id  = mysqli_fetch_assoc($id_response);
//        $id = $id["id"];
//        $rm_id = ["sent" => $id];
//        array_push($received_message_id , $rm_id);
//        $received_message = [$id => $message];
//        array_push($received_messages , $received_message);
//    }
//    
//    array_push($all_messages , $received_messages);
//    array_push($all_messages_id , $received_message_id);
//}
//
//
////print_r($all_messages);
////print_r($all_messages_id);
//
//// all_messages 0 id for received and all_messages_id
//$message_ids = [];
//for($id=0 ; $id < sizeof($all_messages_id[0]) ; $id++) {
//    // received
//    array_push($message_ids , $all_messages_id[0][$id]["received"]);
//    
//}
//
//for($id=0 ; $id < sizeof($all_messages_id[1]) ; $id++) {
//    // sent
//    array_push($message_ids , $all_messages_id[1][$id]["sent"]);
//    
//}
//
//asort($message_ids);
//
//
////print_r($all_messages);
////print_r($all_messages_id);
//
//foreach($message_ids as $keys => $values){
//    for($id = 0 ; $id < sizeof($all_messages) ; $id++){
//        for($i=0 ; $i < sizeof($all_messages[$id]) ; $i++) {
//            foreach($all_messages[$id][$i] as $mkeys => $mvalues) {
//                if($mkeys == $values){
////                    echo "Hello";
//                    for($a = 0 ; $a < sizeof($all_messages_id) ; $a++) {
//                        for($ai = 0 ; $ai < sizeof($all_messages_id[$a]) ; $ai++){
//                            foreach($all_messages_id[$a][$ai] as $idkeys => $idvalues) {
//                                if($mkeys == $idvalues){
//                                    if($idkeys == "received"){
//                                        $message_html .= '<div class="receiver-message-container"><span>'.$mvalues.'</span></div>';
//                                    }elseif($idkeys == "sent") {
//                                        $message_html .= '<div class="sender-message-container"><span>'.$mvalues.'</span></div>';
//                                    }
//                                }
//                            }
//                        }
//                    }
//                }
//            }
//        }
//    }
//}
//
//echo $message_html;






?>