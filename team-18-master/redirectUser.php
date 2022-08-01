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
echo "Connected successfully";

$qry = 'select google_id from users where google_id = ?';
 
$userStatement = mysqli_prepare($conn, $qry);
 
mysqli_stmt_bind_param($userStatement, 's',$_GET['id']);
 
mysqli_stmt_execute($userStatement);
 
mysqli_stmt_bind_result($userStatement, $id);
 
mysqli_stmt_fetch($userStatement);
 
echo "id: ".$id;
echo "<br>";


?>