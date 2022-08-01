<?php
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

 // Get information from form
          //  $length = 10;
          //  $_SESSION['user_id'] = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);           
           $google_id = $_SESSION["incomming_id"];
           $email = $_SESSION["email"];

            // Sanitize the data
            $userName = mysqli_real_escape_string($conn, $_POST['username']);
            $firstName = mysqli_real_escape_string($conn, $_POST['fname']);
            $lastName = mysqli_real_escape_string($conn, $_POST['lname']);
            $zip = mysqli_real_escape_string($conn, $_POST['zipcode']);
            $bio = mysqli_real_escape_string($conn, $_POST['user-bio']);
            $favoriteCategories = mysqli_real_escape_string($conn, $_POST['new-cat']);
            $removeCategories = mysqli_real_escape_string($conn, $_POST['remove-cat']);
            // need to link file names to user
            $fileName = basename($_FILES["file"]["name"]);
            
            if (isset($_POST['save-bttn'])) {
                $query = "INSERT INTO user (google_id, email, first_name, last_name, username, zip, profile_picture, bio)
                VALUES ('$google_id', '$email', '$firstName', '$lastName', '$userName', '$zip', '$fileName', '$bio')";
                $status = mysqli_query($conn, $query) or die(mysqli_error($conn));
                
                 // Check if query was performed
                if ($status) {
                    $_SESSION["username"] = $userName;
                    $_SESSION["user_id"] = $google_id;
                    $fav_cat_query = "INSERT INTO user_categories (user_id, category_id) VALUES('$google_id', '$favoriteCategories')";
                    mysqli_query($conn, $fav_cat_query);
                    
                    //Upload Image begin
                    $target_dir = "uploads/";
                    $target_file = $target_dir . basename($_FILES["file"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    // Check if image file is a actual image or fake image
                    
                      $check = getimagesize($_FILES["file"]["tmp_name"]);
                      if($check !== false) {
                        echo "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                      } else {
                        echo "File is not an image.";
                        $uploadOk = 0;
                      }
                    	  // Check if $uploadOk is set to 0 by an error
					if ($uploadOk == 0) {
						echo "Sorry, your file was not uploaded.";
					// if everything is ok, try to upload file
					} else {
						if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
						// Return the user back to their profile page
                        header("Location: profile.php");
                        //echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
						} else {
						echo "Sorry, there was an error uploading your file.";
						}
					}
                    
                    //Upload Image end

        
                } else {
                    echo "There was an error when trying to update your information.";
                }

            }
        
    mysqli_close($conn);
  ?>