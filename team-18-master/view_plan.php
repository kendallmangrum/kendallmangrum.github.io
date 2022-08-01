<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What Now? Create Plan</title>

    <!-- Styling and Fonts -->
    <link href="style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nerko+One&display=swap" rel="stylesheet">

    <!-- check if already logged in -->
    <?php
        // session_start();
        // if (!isset($_SESSION['userid'])){
        //     header("Location: login.php");
        // }
        // $user_id = $_SESSION["user_id"];
        //$user_id = '100233765235755679454';
        include 'check_permissions.php';
    ?>

    <!-- js functions -->    
</head>
<body>
    <!-- Navigation -->
    <?php include 'load_nav_bar.php';?>
    
    <!-- main  -->
    <br>
    <div class="container page-content">
        <!-- get all planned activities invited to after today -->
        <?php
            // Create connection
            $conn = mysqli_connect("db.luddy.indiana.edu", "i494f20_team18", "my+sql=i494f20_team18", "i494f20_team18");
            // Check connection
            if (!conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $plan_id = $_POST['plan_id'];

            $sql = "SELECT p.id, p.activity_id, DATE_FORMAT(p.date, '%W, %M %D') as date, TIME_FORMAT(p.time, '%h:%i %p') as time, a.name, a.image, a.description, p.note, a.price, a.open_time, a.close_time, a.about_url, p.creator_id
            FROM planned_activity p, activity a
            WHERE p.id = $plan_id
            AND a.id = p.activity_id";
            $result = mysqli_query($conn, $sql);

            $row = mysqli_fetch_array($result);
            if($row){
                // Display html content on page
                echo "<div class='grey-border'>";
                echo "<div class='image-cap'>
                    <a type='button' class='button-grey' href='history.php' id='back-bttn'>Back to Planned</a>
                    <figure class='cap'>
                        <img src='uploads/" . $row['image'] . "' class='cap'>
                    </figure>
                    <div class='gradient-bg'>";

                //only plan organizer can edit
                if ($user_id == $row['creator_id']){
                echo "<form action='edit_plan.php' method='post'>
                    <input type='hidden' name='plan_id' value='$plan_id'>
                    <input type='submit' value='Edit' class='button-white' id='edit-plan'>
                    </form>";
                }

                echo "<h2 class='lg-cap'>" . $row['name'] . "</h2>";

                // get host's name
                $host_sql = "SELECT CONCAT(u.first_name,' ',u.last_name) as UserName
                FROM user u, planned_activity p
                WHERE p.creator_id = u.google_id
                AND p.creator_id = '" . $row['creator_id'] . "'";
                $host_result = mysqli_query($conn, $host_sql);
                $host_row = mysqli_fetch_array($host_result);
                echo "<p>Hosted by: " . $host_row['UserName'] . "</p>";
                
                echo "</div>
                </div>
                <div class='after-cap-lg'>";
                echo "<p class='lg-date-time'>" . $row['date'] . " @ " . $row['time'] . "</p>";

                // Get categories for activity
                $activity_id = $row['activity_id'];
                
                $cat_sql = "SELECT c.name
                FROM activity_categories, category c
                WHERE activity_id = $activity_id
                AND category_id = c.id";
                $cat_result = mysqli_query($conn, $cat_sql);
                if (mysqli_num_rows($cat_result) > 0) {
                    // output data
                    echo "<div class='flex-wrap flex-center'>";
                    while($cat_row = mysqli_fetch_assoc($cat_result)) {
                        echo "<p class='category'>" . $cat_row['name'] . "</p>";
                    }
                    echo "</div>";
                }
                

                //get activity categories here
                
                echo "<p>" . $row['description'] . "";

                //get invitees here
                echo "<h2>Guests</h2><div class='flex-wrap'>";
                $guest_sql = "SELECT u.profile_picture, CONCAT(u.first_name,' ',u.last_name) as UserName
                FROM user u, invitees i
                WHERE i.plan_id = $plan_id
                AND i.user_id = u.google_id";
                //run query
                $guest_result = mysqli_query($conn, $guest_sql);
                if (mysqli_num_rows($guest_result) > 0) {
                    // output data
                    while($guest_row = mysqli_fetch_assoc($guest_result)) {
                        echo "<div class='user'>
                                <figure class='med-prof-img'>
                                    <img src='uploads/" . $guest_row['profile_picture'] . "' class='round' alt='Profile Picture'>
                                </figure>
                                <p>" . $guest_row['UserName'] . "</p>
                            </div>";
                    }
                }
                else {
                    echo "<p>No guests</p>";
                }

                echo "</div><h2>Note</h2><p>" . $row['note'] . "</p>
                    <h2>Price</h2>";

                //TODO: display dollar signs based on price value
                for ($x=1; $x<=5; $x++){
                    echo "<figure class='icon'>";
                    if ($x <= $row['price']){
                        echo "<img src='images/dollar-black.png'>";
                    }
                    else {
                        echo "<img src='images/dollar-grey.png'>";
                    }
                    echo "</figure>";
                }

                echo "<p>Open " . $row['open_time'] . " - " . $row['close_time'] . "</p>
                    <a target='_blank' href='" . $row['about_url'] . "'><button class='button-grey'>Learn More</button></a>";

                //TODO: add google map integration here
                echo "</div>
                </div>";
            }
            else{
                echo "Something went wrong";
            }

            //close connection
            mysqli_close($conn);
        ?>
    </div>

</body>
</html>