<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What Now? My Activities</title>

    <!-- Styling and Fonts -->
    <link href="style.css" rel="stylesheet">

    <!-- check if already logged in -->
    <?php
        // session_start();
        // if (!isset($_SESSION['userid'])){
        //     header("Location: login.php");
        // }
        // $user_id = $_SESSION["user_id"];
        // $user_id = '100233765235755679450';
        include 'check_permissions.php';
    ?>

    <!-- All js -->
    <!--jQuery Ajax-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- js functions -->
    <script type="text/javascript">
        // This is where all my JS will go...
        // IF I HAD ANY
    </script>

</head>
<body>
    <!-- Navigation -->
    <?php include 'load_nav_bar.php';?>
    
    <!-- main  -->
    <div class="container">
        <h1>My Activities</h1>
        <div class="card-grid">
            <!-- get all planned activities invited to after today -->
            <?php
                // Create connection
                $conn = mysqli_connect("db.luddy.indiana.edu", "i494f20_team18", "my+sql=i494f20_team18", "i494f20_team18");
                // Check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $sql = "SELECT id, name, TIME_FORMAT(open_time, '%h:%i %p') as open_time, TIME_FORMAT(close_time, '%h:%i %p') as close_time, CONCAT(city, ', ', state) as location, image
                FROM activity
                WHERE creator_id = '$user_id'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // output data
                    while($row = mysqli_fetch_assoc($result)) {
                        // Display html content on page
                        echo "<div class='activity-card grey-border'>
                                <div class='image-cap'>
                                    <figure class='cap'>
                                        <img src='uploads/" . $row['image'] . "' class='cap'>
                                    </figure>
                                    <div class='gradient-bg'>
                                        <h2>" . $row['name'] . "</h2>
                                    </div>
                                </div>
                                <div class='after-cap'>
                                    <p class='date-time'>" . $row['open_time'] . "</p>
                                    <p class='date-time'>" . $row['close_time'] . "</p>
                                    <form action='edit_activity.php' method='post'>
                                        <input type='hidden' name='activity_id' value='" . $row['id'] . "' id='activity-page'>
                                        <input type='submit' value='View/Edit' class='button-grey' id='view_activity'>
                                    </form>
                                </div>
                            </div>";
                    }
                } else {
                    echo "No upcomming activities.";
                }

                //close connection
                mysqli_close($conn);
            ?>
        </div>
    </div>

</body>
</html>