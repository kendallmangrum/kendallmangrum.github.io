<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What Now? Profile</title>
    <!-- Styling and Fonts -->
    <link href="style.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/jpg" href="favicon">
</head>
<body>
    <!-- Navigation -->
    <?php include 'load_nav_bar.php'; ?>
    <?php include 'check_permissions.php';?>
    
    <!-- Can be replaced to edit profile  -->
    <div class="container">
        <h1>Edit Profile</h1>
        <div class="profile-card">
            <!-- Build Procedurally -->

            <?php
                if(!empty($statusMsg)) {
                    echo $statusMsg;
                }
            ?>

            <!-- Form for user to upload a new profile picture -->
            <form action="update_user_picture.php" method="POST" enctype="multipart/form-data"> 
                <h4>Profile Image</h4> 
                <input type="file" name="file" id="file">
                <input type="submit" value="upload" name="submit">
            </form>

            <!-- Form for user to update information such as first/last name, zipcode, bio, and add new favorite categories -->
            <form action="update_user.php" method="POST" class="edit-form">
            <?php
                $servername = "db.luddy.indiana.edu";
                $dbusername = "i494f20_team18";
                $dbpassword = "my+sql=i494f20_team18";
                $dbname = "i494f20_team18";

                // session_start():
                // $username = $_SESSION['username'];
                // $id = $_SESSION['user_id'];
                // $username = 'johndoe';

                // Create connection
                $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
                // Check connection
                if (!conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                // Query to get all of the categories in the database in alphabetical order
                $result  = mysqli_query($conn, "SELECT first_name, last_name, zip, bio FROM user WHERE google_id = '$user_id'");
                while ($row = mysqli_fetch_assoc($result)) {
                    $fname = $row['first_name'];
                    $lname = $row['last_name'];
                    $zip = $row['zip'];
                    $bio = $row['bio'];

                    echo "<h4>First Name</h4>
                    <input type='text' name='fname' id='fname' class='input-width' value='$fname'>
                    <h4>Last Name</h4>
                    <input type='text' name='lname' id='lname' class='input-width' value='$lname'>
                    <h4>Zip</h4>
                    <input type='number' name='zipcode' id='zipcode' class='input-width' value='$zip'>
                    <h4>Bio</h4>
                    <textarea type='text' name='user-bio' id='user-bio' class='input-width'>$bio</textarea>";
                }
                mysqli_close($conn);
            ?>
                
                <h4>Add Favorite Categories</h4>
                <select name="new-cat" >
                    <option value=""></option>

                <!-- Connect to database to auto fill the dropdown menu with activity categories in the database -->
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
                // Query to get all of the categories in the database in alphabetical order
                $result  = mysqli_query($conn, "SELECT name FROM category ORDER BY name");
                while ($row = mysqli_fetch_assoc($result)) {
                    $name = $row['name'];
                    echo '<option value="'.$name.'">'.$name.'</option>';
                }
                echo "</select>";


                echo "<h4>Remove Favorite Categories</h4>
                        <select name='remove-cat'>
                            <option value=''></option>";

                // Query to get all of the categories in the database in alphabetical order
                $cats = mysqli_query($conn, "SELECT category.name FROM user, category, user_categories WHERE user.google_id = user_categories.user_id AND user_categories.user_id = '$user_id' AND user_categories.category_id = category.id GROUP BY category.id ORDER BY name");
                while ($row = mysqli_fetch_assoc($cats)) {
                    $catname = $row['name'];
                    echo "<option value='".$catname."'>".$catname."</option>";
                }
                


                mysqli_close($conn);
                ?>
                </select>
                <br>
                <!-- Save and Cancel buttons -->
                <input type="submit" value="Save" name="save-bttn"> &nbsp; <a href="profile.php"><button>Cancel</button></a>
            </form>
        </div>
    </div>

    

</body>
</html>