<?php

session_start();
$user_id = $_SESSION["user_id"];
$userID = $user_id;
//$userID = '100233765235755679454';


//*** Get User Groups

 $servername = "db.luddy.indiana.edu";
 $dbusername = "i494f20_team18";
 $dbpassword = "my+sql=i494f20_team18";
 $dbname = "i494f20_team18";

// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT g.id, g.name FROM is_member im, friend_group g
          WHERE im.user_id = '$userID'
          AND im.group_id = g.id";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

    while($row = mysqli_fetch_assoc($result)) {

        $data[] = array(
                       "groupID" => $row['id'],
                       "name" => $row['name'],
                       );

    }
    
   echo (empty($data) ? null : json_encode($data));exit;

} else {
    
    echo "0 results";
}

mysqli_close($conn);
?>