<?php
// Create connection
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f20_team18", "my+sql=i494f20_team18", "i494f20_team18");
// Check connection
if (!conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// get user's information to record creator
include '../check_permissions.php';
// session_start();
//$user_id = $_SESSION["user_id"];

// get inputs, santitize text fields
$act_id = $_POST['plan_id'];
$date = $_POST['date'];
$time = $_POST['time'];
$friends = $_POST['friend'];
$groups = $_POST['group'];
$note = mysqli_real_escape_string($conn, $_POST['note']);

// create planned activity
$sql = "INSERT INTO planned_activity (activity_id, date, time, note, creator_id)
    VALUES ($act_id, '$date', '$time', '$note', '$user_id')";
//echo $sql;

// run querry and check success
if (mysqli_query($conn, $sql)) {

    //plan must have been created for guests to be invited
    echo "Activity has been planned";
    //get id of newly created plan
    $get_id = mysqli_query($conn, "SELECT LAST_INSERT_ID()");
    $plan_id = mysqli_fetch_array($get_id);
    $new_id = $plan_id['LAST_INSERT_ID()'];

    // invite groups to plan
    // loop through the array of groups
    foreach ($groups as &$group) {
        //get all of the group members to send them an individual invitation
        $select_members = "SELECT user_id
            FROM is_member
            WHERE group_id = $group";
        $members_result = mysqli_query($conn, $select_members);
        if (mysqli_num_rows($members_result) > 0) {
            // add each member to the friends array
            while($member_row = mysqli_fetch_assoc($members_result)) {
                // check if array was created by form
                if(isset($friends)){
                    array_push($friends, $member_row['user_id']);
                    echo "array already exists </br>";
                }
                else {
                    // create array if not created
                    $friends = array($member_row['user_id']);
                    echo "array created</br>";
                }
            }
        }
    }

    // // invite users to plan
    // // loop through the array of friends
    //add creator to array so their plan will show up on their account
    // array_push($friends, );
    if(!isset($friends)){
        // array_push($friends, $member_row['user_id']);
        // echo "array already exists </br>";
        $friends = array($user_id);
    }
    else {
        array_push($friends, $user_id);
    }
    // else {
    //     // create array if not created
        
    //     echo "array created</br>";
    // }
    echo $friends;
    
    foreach ($friends as &$friend) {
        
        $invite_sql = "INSERT INTO invitees (plan_id, user_id)
            VALUES ($new_id, '$friend')";
        if (mysqli_query($conn, $invite_sql)) {
            echo "User invited";
        }else{
            echo "User already invited";
        }
    }

    // update creators information
    // delete creators invitation notification
    $del_note = "DELETE FROM notification WHERE type_id = 3 AND sender = $new_id AND reciever_id = '$user_id'";
    if (mysqli_query($conn, $del_note)) {
        echo "Notification Removed";
    }
    $mark_accept = "UPDATE invitees SET accepted = 1 WHERE user_id = '$user_id' and plan_id = $new_id";
    if (mysqli_query($conn, $mark_accept)) {
        echo "Marked as accepted";
    }

} else {
    echo "Unable to create activity at this time.";
}

//close connection
mysqli_close($conn);

sleep(2);

header("Location: ../history.php");

?>