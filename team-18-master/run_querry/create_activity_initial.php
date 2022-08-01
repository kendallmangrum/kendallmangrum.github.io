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

// form variables and sanitize them
// $image = "uploads/" . cleanse_input($_POST['image']);
$name = cleanse_input($_POST['activity-name']);
$description = cleanse_input($_POST['description']);
$open_time = cleanse_input($_POST['open_time']);
$close_time = cleanse_input($_POST['close_time']);
$street1 = cleanse_input($_POST['street1']);
$street2 = cleanse_input($_POST['street2']);
$city = cleanse_input($_POST['city']);
$state = cleanse_input($_POST['state']);
$zip = cleanse_input($_POST['zip']);
$price = cleanse_input($_POST['price']);
$max_part = cleanse_input($_POST['max_participants']);
$about_url = cleanse_input($_POST['about_url']);

// ========================= INSERT ACTIVITY ========================= 

// Base SQL INSERT statement 
if ($street2 != "" && $about_url != "") {
    $sql_insert = "INSERT INTO activity (name, description, creator_id, open_time, close_time, price, street1, street2, city, state, zip, max_participants, about_url)
    VALUES ('$name', '$description', '$user_id', '$open_time', '$close_time', '$price', '$street1', '$street2', '$city', '$state', '$zip', '$max_part', '$about_url')";
}
else if ($street2 != "") {
    $sql_insert = "INSERT INTO activity (name, description, creator_id, open_time, close_time, price, street1, street2, city, state, zip, max_participants)
    VALUES ('$name', '$description', '$user_id', '$open_time', '$close_time', '$price', '$street1', '$street2', '$city', '$state', '$zip', '$max_part')";
}
else if ($about_url != "") {
    $sql_insert = "INSERT INTO activity (name, description, creator_id, open_time, close_time, price, street1, city, state, zip, max_participants, about_url)
    VALUES ('$name', '$description', '$user_id', '$open_time', '$close_time', '$price', '$street1', '$city', '$state', '$zip', '$max_part', '$about_url')";
}
else {
    $sql_insert = "INSERT INTO activity (name, description, creator_id, open_time, close_time, price, street1, city, state, zip, max_participants)
    VALUES ('$name', '$description', '$user_id', '$open_time', '$close_time', '$price', '$street1', '$city', '$state', '$zip', '$max_part')";
}
$sql_result = mysqli_query($conn, $sql_insert);
if ($sql_result) {
    // echo "Works!";
    header("Location: ../my_activities.php");
}
else {
    echo "Uh oh! Something went wrong.<br>";
    echo $sql_insert . "<br>";
    echo mysqli_error($conn);
    echo "<html><body>
    <p>$sql_insert</p>
    " . mysqli_error($conn) . "
    <p></p>
    </body></html>";
}

// ========================= CATEGORY INSERT ========================= 
$cat_id = cleanse_input($_POST['cat']);
$sql = "SELECT id FROM activity WHERE creator_id = '$user_id' AND name = '$name' AND description = '$description'";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
    $act_id = $row['id'];
}
$cat_insert = "INSERT INTO activity_categories (activity_id, category_id) VALUES ('$act_id', '$cat_id')";
if (mysqli_query($conn, $cat_insert)) {
    // echo "Category added";
}
else {
    echo mysqli_error($conn);
}


// ========================= IMAGE UPLOAD ========================= 

$statusMsg = '';
// File upload path
$targetDir = "../uploads/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

// Check if upload button was pressed and that there is a file selected for upload
if(!empty($_FILES["file"]["name"])) {
    // Specify what type of files can be uploaded and check if user upload matches criteria
    $allowTypes = array('jpg', 'jpeg', 'png', 'gif', 'pdf');
    if(in_array($fileType, $allowTypes)) {
        
        // Upload file to server
        // Check if uploads directory exists, if not, create it
        if (!file_exists($output_dir)) {
            @mkdir($output_dir, 0777);
        }        
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                
                // Insert image file into database
                $insert = "UPDATE activity SET image = '$fileName' WHERE creator_id = '$user_id' AND name = '$name' AND description = '$description'";
            
                // Check if query worked, if not display error message
                if(mysqli_query($conn, $insert)) {
                    $statusMsg = "The file " .$fileName. " has been uploaded successfully.";
                } else {$statusMsg = "File upload failed, please try again.";}
        }else {"Sorry, there was an error uploading your file.";}
    } else {"Sorry, only JPG, PNG, JPEG, GIF, & PDF files are allowed to be uploaded.";}
} else {"Please select a file to upload.";}

echo $statusMsg;

// sleep(2);

// header("Location: ../my_activities.php");
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