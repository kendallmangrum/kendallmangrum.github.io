<?php

$groupID = $_POST['groupID'];
$groupID = '4';

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

$sql = "UPDATE id, user_id, name, description, first_name, last_name FROM friend_group
          LEFT JOIN is_member ON id = group_id
          LEFT JOIN user ON user_id = google_id
          WHERE id =  $groupID";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

    while($row = mysqli_fetch_assoc($result)) {

     $data[] = array(
                       "groupID" => $row['group_id'],
                       "groupName" => $row['name'],
                       "userName" => trim($row["last_name"]) . ', ' . trim($row["first_name"]),
                       "groupDescription" => $row['description'],
                       );

    }

   echo (empty($data) ? null : json_encode($data));exit;

} else {

    echo "0 results";
}

 mysqli_close($conn);
?>