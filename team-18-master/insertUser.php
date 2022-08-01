<?php

// $groupName = trim($_POST['groupName']);
// $userIDs = json_decode($_POST['userIDs']);

$google_id = $_POST['google_id'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$image_url = $_POST['image_url'];
$email = $_POST['email'];

//$userIDs = ["55366","51353","99999"];

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
//echo "Connected successfully";


// start session
session_start();
// set session id for browser
$_SESSION["user_id"] = $google_id;

//check if user is new or already signed up
// $sql = "SELECT * FROM user WHERE google_id = '$google_id'";
// $result = mysqli_query($conn, $sql);

// check number of results, if they are new there will be 0
$sql = "select username from user WHERE google_id = '$google_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if (count($row)>0){
    // the user already has an account
    $_SESSION["username"] = $row['username'];
   // header("Location: index.php");
    echo "exists";
}
else {
    echo "new";
    // the user is new
    //echo "new User";
    //send them to the sign up form, add the form url on the line below
    //header("Location: register.php");

}

// foreach ($userIDs as $userID) {

//     // Prepare and bind (is best used to prevent SQL injection)
//     $stmt = $conn->prepare("INSERT INTO user (google_id, email) VALUES (?, ?)");
//     $stmt->bind_param("ss", $userID, $groupName);

//     // Execute
//     $stmt->execute();

// }

mysqli_close($conn);
?>