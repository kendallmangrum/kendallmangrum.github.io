<!doctype html>
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
        <h1>My Profile</h1>
        <div class="profile-card">


            <!-- Build Procedurally -->

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
                //session_start();
                //$username = $_SESSION["username"];
                // $user_id = $_SESSION["user_id"];
                // $username = "johndoe";

                // Sql statement to get the user's profile picture, name, username, and bio from the database
                $sql = "SELECT profile_picture, CONCAT(first_name,' ',last_name) as Name, bio, username FROM user WHERE google_id = '$user_id'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    // output data
                    while($row = mysqli_fetch_assoc($result)) {
                        // Display html content on page
                        echo "<div class='flex-container'>
                                <img src='uploads/" . $row['profile_picture']. "' alt='Profile Picture' class='profile-picture'>
                                <div class='names'>
                                    <h1 class='fullname'>" . $row['Name'] . "</h1>
                                    <h3 class='username'>@" . $row['username'] . "</h3>
                                </div>
                                <form action='edit_profile.php'>
                                    <input type='submit' value='Edit' class='edit-profile-button'/>
                                </form>
                                
                            </div>
                            <h3>Bio</h3>
                            <p class='user-bio'>". $row['bio'] . "</p>";
                    }
                } else {echo "0 result";}

                    // Set up and display the user's favorite categories
                    echo "<h3>Favorite Categories</h3>";
                    // Get the user's favorite categories from the database
                    $sql_fav_cat = "SELECT category.name FROM category, user, user_categories WHERE user.google_id = user_categories.user_id AND category.id = user_categories.category_id AND user.username = '$username' ORDER BY category.name";
                    $sql_result = mysqli_query($conn, $sql_fav_cat);
                    if (mysqli_num_rows($sql_result) > 0) {
                        echo "<div class='flex-wrap flex-center'>";
                        while($row = mysqli_fetch_assoc($sql_result)) {
                            echo "<p class='category'>" .$row['name']. "</p>";
                        }
                        echo "</div>";
                    } else {echo "No favorites yet...";}

                //close connection
                mysqli_close($conn);
            ?>
        </div>
    </div>
</body>
</html>