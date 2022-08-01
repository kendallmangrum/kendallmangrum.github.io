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


            include 'check_permissions.php';
            // session_start();
            // $username = $_SESSION['username'];
            // $user_id = $_SESSION['user_id'];
            // $username = "johndoe";
            // $user_id = "100233765235755679450";

            // Get information from form
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $zipcode = $_POST['zipcode'];
            $biography = $_POST['user-bio'];
            $favcat = $_POST['new-cat'];
            $remcat = $_POST['remove-cat'];


            // Sanitize the data
            $firstName = mysqli_real_escape_string($conn, $fname);
            $lastName = mysqli_real_escape_string($conn, $lname);
            $zip = mysqli_real_escape_string($conn, $zipcode);
            $bio = mysqli_real_escape_string($conn, $biography);
            $favoriteCategories = mysqli_real_escape_string($conn, $favcat);
            $removeCategories = mysqli_real_escape_string($conn, $remcat);

            echo $favoriteCategories;


            // Check if submit button was pressed, if so run update query to update user's information
            if (isset($_POST['save-bttn'])) {
                $query = "UPDATE user SET first_name = '$firstName', last_name = '$lastName', zip = '$zip', bio = '$bio' WHERE username = '$username'";

                // Query to update the user's favorite categories
                $category_query = "SELECT id FROM category WHERE name = '$favoriteCategories'";
                $query_result = mysqli_query($conn, $category_query);
                $row = mysqli_fetch_assoc($query_result);
                $cat_id = $row['id'];
                $fav_cat_query = "INSERT INTO user_categories (user_id, category_id) VALUES('$user_id', '$cat_id')";
                mysqli_query($conn, $fav_cat_query);
            }
            
            // Check if query was performed
            if (mysqli_query($conn, $query)) {
                echo "Record updated successfully!";
            } else {
                echo "There was an error when trying to update your information.";
            }


            if (!empty($removeCategories)) {
                $remove_query = "SELECT id FROM category WHERE name = '$removeCategories'";
                $q_result = mysqli_query($conn, $remove_query);
                $r = mysqli_fetch_assoc($q_result);
                $cate_id = $r['id'];
                $remove_category_query = "DELETE FROM user_categories WHERE user_id = '$user_id' AND category_id = '$cate_id'";
                mysqli_query($conn, $remove_category_query);
            }


        
            // Return the user back to their profile page
            header("Location: profile.php");
    
        mysqli_close($conn);
    ?>