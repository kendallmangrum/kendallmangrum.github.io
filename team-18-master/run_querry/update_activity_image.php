<?php

$conn=mysqli_connect('db.luddy.indiana.edu','i494f20_team18', 'my+sql=i494f20_team18', 'i494f20_team18');

//attempt to connect
if (mysqli_connect_errno()){
    echo 'Failed to connect to MySQL: ' .mysqli_connect_error();
}

//check session id
include '../check_permissions.php';

$activity_id = cleanse_input($_POST['activity-id']);

$statusMsg = '';
// File upload path
$targetDir = "../uploads/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

// Check if upload button was pressed and that there is a file selected for upload
if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])) {
    // Specify what type of files can be uploaded and check if user upload matches criteria
    $allowTypes = array('jpg', 'jpeg', 'png', 'gif', 'pdf');
    if(in_array($fileType, $allowTypes)) {
        
        // Upload file to server
        // Check if uploads directory exists, if not, create it
        if (($_POST["submit"]) && !file_exists($output_dir)) {
            @mkdir($output_dir, 0777);
        }        
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                
                // Insert image file into database
                $insert = "UPDATE activity SET image = '$fileName' WHERE id='$activity_id'";
            
                // Check if query worked, if not display error message
                if(mysqli_query($conn, $insert)) {
                    $statusMsg = "The file " .$fileName. " has been uploaded successfully.";
                } else {$statusMsg = "File upload failed, please try again.";}
        }else {"Sorry, there was an error uploading your file.";}
    } else {"Sorry, only JPG, PNG, JPEG, GIF, & PDF files are allowed to be uploaded.";}
} else {"Please select a file to upload.";}
echo $statusMsg;

// close connection
mysqli_close($conn);

function cleanse_input($data) {
    $data = trim($data);
    $data = stripslashes($data); 
    $data = htmlspecialchars($data);
    return $data;
}

?>