<?php
// Create connection
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f20_team18", "my+sql=i494f20_team18", "i494f20_team18");
// Check connection
if (!conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// get inputs, santitize text fields
$plan_id = $_POST['plan_id'];
$date = $_POST['date'];
$time = $_POST['time'];
$friends = $_POST['friend'];
$groups = $_POST['group'];
$note = mysqli_real_escape_string($conn, $_POST['note']);

// update planned activity
$sql = "UPDATE planned_activity
    SET date = '$date',
    time = '$time',
    note = '$note'
    WHERE id = $plan_id";

// run querry and check success
if (mysqli_query($conn, $sql)) {
    echo "Updated Successful";
} else {
    echo "Unable to create activity at this time.";
}

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
            }
            else {
                // create array if not created
                $friends = array($member_row['user_id']);
            }
        }
    }
}

// //  new invite users to plan
// // loop through the array of friends
foreach ($friends as &$friend) {
    $invite_sql = "INSERT INTO invitees (plan_id, user_id)
        VALUES ($plan_id, '$friend')";
    if (mysqli_query($conn, $invite_sql)) {
        echo "User invited";
    }else{
        echo "User already invited";
    }
}

// update creators information
// delete creators invitation notification
$del_note = "DELETE FROM notification WHERE type_id = 3 AND sender = $plan_id AND reciever_id = '$user_id'";
if (mysqli_query($conn, $del_note)) {
    echo "Notification Removed";
}
$mark_accept = "UPDATE invitees SET accepted = 1 WHERE user_id = '$user_id' and plan_id = $new_id";
if (mysqli_query($conn, $mark_accept)) {
    echo "Marked as accepted";
}

//close connection
mysqli_close($conn);

header("Location: ../history.php");

?>