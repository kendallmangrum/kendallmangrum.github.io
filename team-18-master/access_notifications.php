<?php

$conn=mysqli_connect('db.luddy.indiana.edu','i494f20_team18', 'my+sql=i494f20_team18', 'i494f20_team18');

//attempt to connect
if (mysqli_connect_errno()){
    echo 'Failed to connect to MySQL: ' .mysqli_connect_error();
}

//check session id
include 'check_permissions.php';

//check to see what is being requested
//GET request
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //get all the user's notifications
    // echo "<p>Get Recieved.</p>";
    $sql = "SELECT n.id, t.sender_type, n.sender, t.message, t.has_confirmation_req, t.has_time_req FROM notification as n, notification_type as t WHERE n.reciever_id = '$user_id' AND n.type_id = t.id ORDER BY n.send_date";

    //run query
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // output data
        while($row = mysqli_fetch_assoc($result)) {
            $note_card = "<div id='" . $row['id'] . "' class='note-card grey-border'>
            <input type='image' alt='Delete' src='images/close.png' class='delete-note' width='20px' height='20px' onclick='del_note(" . $row['id'] . ")'></input>";

            $message = $row["message"];
            $user = "";
            $group = "";
            $activity = "";
            $prof_image = "";

            //check who/what sent the message
            //check if the sender is a user
            if ($row['sender_type'] == 'user'){
                //get the user's information
                $sender_sql = "SELECT profile_picture, CONCAT(first_name,' ',last_name) as UserName FROM user WHERE google_id = '" . $row['sender'] . "'";
                $sender_result = mysqli_query($conn, $sender_sql);
                $sender_row = mysqli_fetch_array($sender_result);
                $user = $sender_row["UserName"];
                $prof_image = $sender_row["profile_picture"];
            }
            //check if sender is group
            else if ($row['sender_type'] == 'friend_group'){
                $sender_sql = "SELECT name FROM friend_group WHERE id = " . $row['sender'];
                $sender_result = mysqli_query($conn, $sender_sql);
                $sender_row = mysqli_fetch_array($sender_result);
                $group = $sender_row['name'];
            }
            else if ($row['sender_type'] == 'planned_activit'){
                $sender_sql = "SELECT profile_picture, CONCAT(first_name,' ',last_name) as UserName , name FROM planned_activity as p, user as u, activity as a WHERE a.id = p.activity_id AND p.creator_id = u.google_id AND p.id = " . $row['sender'];
                $sender_result = mysqli_query($conn, $sender_sql);
                $sender_row = mysqli_fetch_array($sender_result);
                $user = $sender_row["UserName"];
                $activity = $sender_row["name"];
                $prof_image = $sender_row["profile_picture"];
            }

            $note_card .= "<div class='note-content'>";

            if($prof_image){
                $note_card .= "<figure class='note-profile-picture'><img src='uploads/$prof_image' class='round' alt='Profile Picture'></figure>";
            }

            //fill message placeholders
            $message = str_replace("USER", $user, $message);
            $message = str_replace("GROUP", $group, $message);
            $message = str_replace("ACTIVITY", $activity, $message);
            $note_card .= "<p>$message</p>";

            $note_card .= "</div>";
            
            //check if user needs accept/decline options
            if ($row['has_confirmation_req'] == 1){
                $note_card .= "<div class='response-buttons'>
                        <input type='submit' value='Accept' class='button-blue note-button' onclick='approve_req(" . $row['id'] . ")'></input>
                        <input type='submit' value='Decline' class='button-grey note-button' onclick='del_note(" . $row['id'] . ")'></input>
                        </div>";
            }

            $note_card .= "</div>";
            echo $note_card;
        }
    }
    //if there are no results display message.
    else {
            echo "<div class='note-card'><p>No New Notifications</p></div>";
            
        }
}

//POST request
//takes in any changes that need to be made
else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch ($_POST['action']) {
        case 'del_notification':
            delete_notification($_POST['id']);
            break;
        case 'approve_request':
            $note = get_notification($_POST['id']);
            switch ($note['type_id']){
                //accept friend request
                case 1:
                    add_friend($_POST['id']);
                    break;
                //accept invitation to join group
                case 2:
                    add_to_group($_POST['id']);
                    break;
                //accept activity invitation
                case 3:
                    accept_invitation($_POST['id']);
                    break;
            }
            break;
    }
}

//close connection
mysqli_close($conn);

//functions
//look up info from a specific notification
function get_notification($note_id){
    global $conn;
    $sql = "SELECT type_id, sender, reciever_id FROM notification WHERE id = $note_id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_array($result);
}

function delete_notification($note_id){
    global $conn;
    $sql = "DELETE FROM notification WHERE id = $note_id";
    //run query
    if (mysqli_query($conn, $sql)){
        echo "success";
    }
}

function add_friend($note_id){
    global $conn;
    $note = get_notification($note_id);
    $sql = "INSERT INTO is_friends(user1_id, user2_id) VALUES('" . $note['sender'] . "', '" . $note['reciever_id'] . "')";
    if (mysqli_query($conn, $sql)){
        echo "success";
    }
}

function add_to_group($note_id){
    global $conn;
    $note = get_notification($note_id);
    $sql = "INSERT INTO is_member(group_id, user_id) VALUES('" . $note['sender'] . "', '" . $note['reciever_id'] . "')";
    if (mysqli_query($conn, $sql)){
        echo "success";
    }
}

function accept_invitation($note_id){
    global $conn;
    $note = get_notification($note_id);
    $sql = "UPDATE invitees SET accepted = 1 WHERE plan_id = " . $note['sender'] . " AND user_id = '" . $note['sender'] . "'";
    if (mysqli_query($conn, $sql)){
        echo "success";
    }
}
?>