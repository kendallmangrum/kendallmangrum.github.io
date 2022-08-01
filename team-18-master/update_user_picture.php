<?php
        
        $servername = "db.luddy.indiana.edu";
        $dbusername = "i494f20_team18";
        $dbpassword = "my+sql=i494f20_team18";
        $dbname = "i494f20_team18";

        // Create connection
        $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
        // Check connection
        if (!conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

            include "check_permissions.php";
            // session_start();
            // $username = $_SESSION['username'];
            // $user_id = $_SESSION['user_id'];
            // $username = "johndoe";
            $statusMsg = '';
 

            // File upload path
            $targetDir = "uploads/";
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
                    if (!file_exists($output_dir)) {
		                @mkdir($output_dir, 0777);
	                }        
                        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                            
                            // Insert image file into database
                            $insert = "UPDATE user SET profile_picture = '$fileName' WHERE username = '$username'";
                        
                            // Check if query worked, if not display error message
                            if(mysqli_query($conn, $insert)) {
                                $statusMsg = "The file " .$fileName. " has been uploaded successfully.";
                            } else {$statusMsg = "File upload failed, please try again.";}
                    }else {"Sorry, there was an error uploading your file.";}
                } else {"Sorry, only JPG, PNG, JPEG, GIF, & PDF files are allowed to be uploaded.";}
            } else {"Please select a file to upload.";}

            echo $statusMsg;

            // Return user to the edit profile page
            header("Location: edit_profile.php");
        mysqli_close($conn);
    ?>