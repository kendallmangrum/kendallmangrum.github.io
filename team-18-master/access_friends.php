<?php

$conn=mysqli_connect('db.luddy.indiana.edu','i494f20_team18', 'my+sql=i494f20_team18', 'i494f20_team18');

//attempt to connect
if (mysqli_connect_errno()){
    echo 'Failed to connect to MySQL: ' .mysqli_connect_error();
}

//check session id
// $user_id = '100233765235755679450';
// $user_id = '100233765235755679455';
include 'check_permissions.php';

//check to see what is being requested
//GET request
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //get all the user's notifications
    // echo "<p>Get Recieved.</p>";
    $sql = "SELECT DISTINCT user1_id, user2_id FROM is_friends WHERE user1_id = '$user_id' OR user2_id ='$user_id'";

    //run query
    $friends_result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($friends_result)) {
        if ($row['user1_id'] == $user_id) {
            $sql = "SELECT google_id, first_name, last_name, profile_picture FROM user WHERE google_id = '" . $row['user2_id'] . "'";
        }
        if ($row['user2_id'] == $user_id) {
            $sql = "SELECT google_id, first_name, last_name, profile_picture FROM user WHERE google_id = '" . $row['user1_id'] . "'";
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // output data
            while($row2 = mysqli_fetch_assoc($result)) {
                $google_id = '"'.$row2['google_id'].'"';
                $friend = "<div id='entry" . $row2['google_id'] . "' class='list-entry' onclick='get_friend(" . $google_id . ")'>
                    <img class='friend-thumb' src='uploads/" . $row2['profile_picture'] . "' alt='Profile Picture'>
                    <p>" . $row2['first_name'] . " " . $row2['last_name'] . "</p>
                </div>";
                echo $friend;
            }
        }
        //if there are no results display message.
        else {
            echo "<div class='list-entry'><p>You don't have any friends yet!</p></div>";
        }
    }
}

//POST request
//takes in any changes that need to be made
else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch ($_POST['action']) {
        case 'get_friend':
            echo get_friend($_POST['friend_id']);
            break;
        case 'get_friend_requests':
            echo get_friend_requests();
            break;
        case 'accept_friend':
            echo accept_friend($_POST['friend_id']);
            break;
        case 'deny_friend':
            echo deny_friend($_POST['friend_id']);
            break;
        case 'remove_friend':
            echo remove_friend($_POST['friend_id']);
            break;
        case 'request_friend':
            echo request_friend($_POST['friend_id']);
            break;
        case 'search_users':
            echo search_users($_POST['user_in']);
            break;
    }
}

//close connection
mysqli_close($conn);

//functions
function get_friend($friend_id){
    global $conn;
    $sql = "SELECT google_id, CONCAT(first_name, ' ', last_name) AS FullName, profile_picture, bio FROM user WHERE google_id = '" . $friend_id . "'";
    $result = mysqli_query($conn, $sql);

    //run query
    if (mysqli_query($conn, $sql)){
        // Build HTML here!
        while($row = mysqli_fetch_assoc($result)) {
            $friend_data = "<div class='info-card'>
                    <img class='activity-thumb' src='uploads/" . $row['profile_picture'] . "' alt='Profile Picture'>
                    <h2>" . $row['FullName'] . "</h2>
                    <p>" . $row['bio'] . "</p>
                    <button type='button' id='" . $row['google_id']. "' class='button-grey' onclick='remove_friend(" . '"' . $friend_id . '"' . ")'>Remove Friend</button>
                </div>";
        }
        
        echo $friend_data;
    }
}

function get_friend_requests(){
    global $conn;
    global $user_id;
    // USE THIS SECTION TO ADD BANNERS OF FRIEND REQUESTS
    $sql = "SELECT id AS notif_id, type_id, sender, reciever_id FROM notification WHERE type_id = 1 AND reciever_id = $user_id";
    //Run query
    $friend_requests = mysqli_query($conn, $sql);

    $request_banners = "";
    while($row = mysqli_fetch_assoc($friend_requests)) {
        $friend_sql = "SELECT google_id, CONCAT(first_name, ' ', last_name) AS FullName, profile_picture FROM user WHERE google_id = '" . $row['sender'] . "'";
        $friend_info = mysqli_query($conn, $friend_sql);
        while($row2 = mysqli_fetch_assoc($friend_info)) {
            $request_banners .= "<div id='banner" . $row2['google_id'] . "' class='friend-request'>
                <div class='left-nav'>
                    <img class='friend-thumb' src='uploads/" . $row2['profile_picture'] . "' alt='Profile Picture'>
                    <p>" . $row2['FullName'] . "</p>
                </div>
                <div class='right-nav'>
                    <div class='response-buttons'>
                        <input type='submit' value='Accept' class='button-blue note-button' onclick='accept_friend(" . '"' . $row2['google_id'] . '"' . ")'></input>
                        <input type='submit' value='Decline' class='button-grey note-button' onclick='deny_friend(" . '"' . $row2['google_id'] . '"' . ")'></input>
                    </div>
                </div>
            </div>";        
        }
    }
    echo $request_banners;
}

function accept_friend($friend_id){
    global $conn;
    global $user_id;
    // CHANGE SQL TO NOTIFICATION TABLE
    $sql = "INSERT INTO is_friends (user1_id, user2_id) VALUES (" . $friend_id . "," . $user_id . ")";
    // $result = mysqli_query($conn, $sql);

    //run query
    if (mysqli_query($conn, $sql)){
        $sql_del_note = "DELETE FROM notification WHERE type_id=1 AND sender = $friend_id AND reciever_id = $user_id";
        mysqli_query($conn, $sql_del_note);
        echo "success";
    }
    else {
        echo mysqli_error($conn) . $sql . $friend_id;
    }
}

function deny_friend($friend_id){
    global $conn;
    global $user_id;
    // CHANGE SQL TO NOTIFICATION TABLE
    $sql = "DELETE FROM notification WHERE type_id=1 AND sender = $friend_id AND reciever_id = $user_id";
    $deny = mysqli_query($conn, $sql);
    if ($deny) {
        echo "success";
    }
    else {
        return mysqli_error($conn) . $sql;
    }
}

function remove_friend($friend_id){
    global $conn;
    global $user_id;
    // Remove user as a friend.
    $sql = "DELETE FROM is_friends WHERE user1_id IN ($user_id, $friend_id) AND user2_id IN ($user_id, $friend_id)";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    }
    else {
        echo mysqli_error($conn);
    }
}

function request_friend($friend_id){
    global $conn;
    global $user_id;
    // Request other user to be our friend
    // Create notification for request
    $sql = "INSERT INTO notification (type_id, send_date, sender, reciever_id) VALUES (1, CURDATE(), ".$user_id.", ".$friend_id.")";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    }
    else {
        echo mysqli_error($conn) . $sql . $friend_id;
    }
    
}

function search_users($user_in) {
    global $conn;
    global $user_id;
    $sql = "SELECT google_id, CONCAT(first_name, ' ', last_name) AS FullName, profile_picture, bio FROM user ";
    
    $keywords = cleanse_input($user_in);
    $keywords = explode("+", $user_in);

    // $response = "<p>{$keywords[0]}</br>{$user_in}</br>{$len}</p>";

    if (count($keywords) == 1) {
        $sql .= "WHERE first_name LIKE '%{$keywords[0]}%' OR last_name LIKE '%{$keywords[0]}%'";
    }
    if (count($keywords) > 1) {
        $sql .= "WHERE first_name LIKE '%{$keywords[0]}%' AND last_name LIKE '%{$keywords[-1]}%'";
    }

    $response = "";
    $sql .= " ORDER BY last_name";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['google_id'] != $user_id) {
            $response .= "<div class='search-result-card'>
                <div class='image-cap'>
                    <figure class='cap'>
                        <img src='uploads/".$row['profile_picture']."' alt='Profile Picture' class='cap'>
                    </figure>
                    <div class='gradient-bg'>
                        <h2>".$row['FullName']."</h2>
                    </div>
                </div>
                <div class='search-result-container'>";
            
            // UNDER CONSTUCTION

            $sql = "SELECT DISTINCT user1_id, user2_id FROM is_friends WHERE user1_id = '$user_id' OR user2_id ='$user_id'";
            //run query
            $friends_result = mysqli_query($conn, $sql);
            if (in_array_r($row['google_id'], mysqli_fetch_all($friends_result))) {
                $response .= "<button type='button' id='" . $row['google_id']. "' class='button-grey' onclick='remove_friend(" . '"' . $row['google_id']. '"' . ")'>Remove Friend</button>
                        </div>
                    </div>";
            }
            else {
                $response .= "<button type='button' id='" . $row['google_id']. "' class='button-blue' onclick='request_friend(" . '"' . $row['google_id']. '"' . ")'>Add Friend</button>
                    </div>
                </div>";
            }
        }
    }
    return $response;
}

function cleanse_input($data) {
    $data = trim($data);
    $data = stripslashes($data); 
    $data = htmlspecialchars($data);
    return $data;
}

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}
?>