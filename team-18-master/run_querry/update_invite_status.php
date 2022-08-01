<?php

$conn=mysqli_connect('db.luddy.indiana.edu','i494f20_team18', 'my+sql=i494f20_team18', 'i494f20_team18');

//attempt to connect
if (mysqli_connect_errno()){
    echo 'Failed to connect to MySQL: ' .mysqli_connect_error();
}

//check session id
include '../check_permissions.php';
// session_start();
//$user_id = $_SESSION["user_id"];
//TODO: fix with permissions
//$user_id = '100233765235755679454';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // echo "enter post";
    switch ($_POST['action']) {
        case 'toggle_attend':
            echo toggle_attend($_POST['id']);
            break;
        case 'toggle_accept':
            echo toggle_accept($_POST['id']);
            break;
    }
}

//close connection
mysqli_close($conn);

// functions
function toggle_attend($plan_id){
    global $conn;
    global $user_id;
    //get current value
    $sql = "SELECT attended
        FROM invitees
        WHERE plan_id = $plan_id
        AND user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $attended = $row['attended'];

    // check what to update to
    if($attended == 1){
        $new_val = 0;
    } elseif ($attended == 0) {
        $new_val = 1;
    } else {
        $new_val = 1;
    }

    // make the update
    $sql = "UPDATE invitees
        SET attended = $new_val
        WHERE plan_id = $plan_id
        AND user_id = '$user_id'";
    if (mysqli_query($conn, $sql)){
        //send out new value
        return $new_val;
    }
}

function toggle_accept($plan_id){
    global $conn;
    global $user_id;
    //get current value
    $sql = "SELECT accepted
    FROM invitees
    WHERE plan_id = $plan_id
    AND user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $value = $row['accepted'];

    // check what to update to
    if($value == 1){
        $new_val = 0;
    } elseif ($value == 0) {
        $new_val = 1;
    } else {
        $new_val = 1;
    }

    // make the update
    $sql = "UPDATE invitees
        SET accepted = $new_val
        WHERE plan_id = $plan_id
        AND user_id = '$user_id'";
    if (mysqli_query($conn, $sql)){
        //send out new value
        return $new_val;
    }
}
?>