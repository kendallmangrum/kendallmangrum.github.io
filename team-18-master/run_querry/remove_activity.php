<?php 
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

include '../check_permissions.php';

$activity_id = cleanse_input($_POST['activity_id']);
echo $activity_id;

// Delete query for the activity
$sql = "DELETE FROM activity WHERE id='$activity_id'";
$run_sql = mysqli_query($conn, $sql);
// Delete query for the activity_categories
$sql_cat = "DELETE FROM activity_categories WHERE activity_id='$activity_id'";
$run_sql_cat = mysqli_query($conn, $sql_cat);

echo $sql . $sql_cat;
echo mysqli_error($conn);

if (!$run_sql || !$run_sql_cat) {
    echo mysqli_error($conn);
}
if ($run_sql && $run_sql_cat) {
    header("Location: ../my_activities.php");
}

// close connection
mysqli_close($conn);

// Function to cleanse data
function cleanse_input($data) {
    $data = trim($data);
    $data = stripslashes($data); 
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}
?>