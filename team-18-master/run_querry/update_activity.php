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

        //session_start();
        include '../check_permissions.php';

        // form variables and sanitize them
        $activity_id = cleanse_input($_POST['activity_id']);
        // $image = cleanse_input($_POST['image']);
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

        $sql_update = "UPDATE activity
        SET name = '$name',
        description = '$description',
        open_time = '$open_time',
        close_time = '$close_time',
        street1 = '$street1',
        street2 = '$street2',
        city = '$city',
        state = '$state',
        zip = '$zip',
        price = '$price',
        max_participants = '$max_part',
        about_url = '$about_url'
        WHERE id = '$activity_id'";

        //Execute SQL query
        $run_sql = mysqli_query($conn, $sql_update);

        if ($run_sql) {
            echo "<a href='../my_activities.php'>Successfully updated</a>";
            header("Location: ../my_activities.php");
        }
        else {
            echo "<a href='../index.php'>Failed to update</a>";
            echo mysqli_error($conn);
        }
        
        // ===================== CATEGORY =====================
        $cat_id = cleanse_input($_POST['cat']);
        $cat_sql = "UPDATE activity_categories SET category_id = '$cat_id' WHERE activity_id = '$activity_id'";
        mysqli_query($conn, $cat_sql);

        // ===================== IMAGE =====================
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
                if (($_POST["submit"]) && !file_exists($output_dir)) {
                    @mkdir($output_dir, 0777);
                }        
                    if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                        
                        // Insert image file into database
                        $insert = "UPDATE activity SET image = '$fileName' WHERE activity_id = '$activity_id'";
                    
                        // Check if query worked, if not display error message
                        if(mysqli_query($conn, $insert)) {
                            $statusMsg = "The file " .$fileName. " has been uploaded successfully.";
                        } else {$statusMsg = "File upload failed, please try again.";}
                }else {"Sorry, there was an error uploading your file.";}
            } else {"Sorry, only JPG, PNG, JPEG, GIF, & PDF files are allowed to be uploaded.";}
        } else {"Please select a file to upload.";}



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