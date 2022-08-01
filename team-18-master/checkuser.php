<?php

// start session
session_start();

$servername = "db.luddy.indiana.edu";
$dbusername = "i494f20_team18";
$dbpassword = "my+sql=i494f20_team18";
$dbname = "i494f20_team18";

//Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

//Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$google_id = $_POST['google_id'];

$_SESSION["incomming_id"] = $google_id;
$_SESSION["email"] = $_POST['email'];

// check number of results, if they are new there will be 0
$sql = "select username from user WHERE google_id = '$google_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);


if (count($row)>0){
    $_SESSION["username"] = $row['username'];
    $_SESSION["user_id"] = $google_id;
    echo '{"status":"exists"}';
}
else {
    echo '{"status":"new"}';
}

mysqli_close($conn);
?>
