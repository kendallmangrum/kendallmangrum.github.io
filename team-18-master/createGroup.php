<?php

session_start();
$user_id = $_SESSION["user_id"];

echo $_POST['groupName'];
echo $_POST['groupDescription'];
echo $_POST['userIDs'];

$groupName = trim($_POST['groupName']);
$groupDescription = trim($_POST['groupDescription']);
$userids = json_decode($_POST['userIDs']);
//$userIDs = ["55366","51353","99999"];
    //echo userIDs;
    $servername = "db.luddy.indiana.edu";
    $dbusername = "i494f20_team18";
    $dbpassword = "my+sql=i494f20_team18";
    $dbname = "i494f20_team18";

// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

//check if signed in
include 'check_permissions.php';

$sql = "INSERT INTO friend_group (name, description) VALUES ('$groupName', '$groupDescription')";

// $sql = "INSERT group_id, user_id FROM is_member
//           LEFT JOIN friend_group ON group_id = id
//           WHERE user_id =  '$userID'";

//echo $sql;
 if(mysqli_query($conn, $sql)){
       echo "Records inserted successfully.";
  } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
// $sql = "select id from friend_group where name = $groupname";

// if (mysqli_num_rows($result) > 0) {

//     while($row = mysqli_fetch_assoc($result)) {

//        $groupid =  trim($row["id"]);

//     }

//    echo (empty($data) ? null : json_encode($data));exit;

// } else {

//     echo "0 results";
// }

//get id of newly inserted row
$get_id = mysqli_query($conn, "SELECT LAST_INSERT_ID()");
$inserted_id = mysqli_fetch_array($get_id);
$groupid = $inserted_id['LAST_INSERT_ID()'];

echo $userids;

foreach ($userids as $userid) {

    echo $userid;
    $sql = "insert into is_member (group_id, user_id) values($groupid, '$userid')";

    if(mysqli_query($conn, $sql)){
        echo "records inserted successfully.";
    } else{
       echo "error: could not able to execute $sql. " . mysqli_error($conn);
    }
    // Execute
    //$sql->execute();

}

//insert group creator
$sql = "insert into is_member (group_id, user_id) values($groupid, '$user_id')";

    if(mysqli_query($conn, $sql)){
        echo "records inserted successfully.";
    } else{
       echo "error: could not able to execute $sql. " . mysqli_error($conn);
    }


mysqli_close($conn);
?>