<?php

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
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$image_url = $_POST['image_url'];
$email = $_POST['email'];


// start session
session_start();
// set session id for browser
$_SESSION["user_id"] = $google_id;



// check number of results, if they are new there will be 0
$sql = "select username from user WHERE google_id = '$google_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if (count($row)>0){
    // the user already has an account
    $_SESSION["username"] = $row['username'];

    echo '{"status":"exists"}';
}
else {
    echo '{"status":"new"}';


}


mysqli_close($conn);
?>