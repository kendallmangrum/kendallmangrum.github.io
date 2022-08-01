<html>
    <head>
        <title>Get Group Activities</title>
        <!-- Styling -->
        <link href="style.css" rel="stylesheet">
        <!-- Ajax -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    </head>


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
    //session_start();
    //$username = $_SESSION["username"];
    // $user_id = $_SESSION["user_id"];
    //$user_id = '100233765235755679451';

    // Determine what activities a user has liked
   // $test = 'user_id';
    $sql_is_member = "SELECT group_id FROM is_member WHERE user_id = '$user_id'";
    $is_member_acts = mysqli_query($conn, $sql_is_member);
    $is_member_array = [];

    if (mysqli_num_rows($is_member_acts) > 0) {
        while ($r = mysqli_fetch_assoc($is_member_acts)) {
            $r = $r['activity_id'];
            array_push($is_member_array, $r);
        }
    }

    //var_dump($r);



    // Obtained from: https://stackoverflow.com/questions/5398674/get-users-current-location
    $user_ip = getenv('REMOTE_ADDR');
    $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
    $country = $geo["geoplugin_countryName"];
    $city = $geo["geoplugin_city"];

    // Get the time from the server (assume user is in EST time zone)
    $time = date("H:i");

   // foreach ($is_member_array as $groupID) {



    // Create search query
    $sql_search = "SELECT DISTINCT activity.id, activity.name, activity.description, activity.open_time, activity.close_time, activity.price, activity.street1, activity.street2, activity.city, activity.state, activity.zip, 
                activity.max_participants, activity.image, activity.about_url, category.name as catname FROM activity, activity_categories, category, user, user_categories, is_member WHERE ";

    // Append the user's current city and time
    $sql_search .= "activity.id = activity_categories.activity_id AND category.id = activity_categories.category_id AND activity_categories.activity_id = activity.id AND user.google_id = user_categories.user_id AND category.id = user_categories.category_id AND user.google_id = '$user_id' GROUP BY activity.id ORDER BY activity.name ASC";


    // Create search result heading and div container for flexbox display
    $output = "<h1 class='search-heading'>Your Group Activies</h1>
                <div class='flex-search-container'>";

        // Loop through results of query
        $sql_result = mysqli_query($conn, $sql_search);
        if (mysqli_num_rows($sql_result) > 0) {
            while ($row = mysqli_fetch_assoc($sql_result)) {
                // echo $row['image'];
                $act_id = $row['id'];
                $act_name = $row['name'];
                $act_street1 = $row['street1'];
                $act_street2 = $row['street2'];
                $act_state = $row['state'];
                $act_zip = $row['zip'];
                $act_city = $row['city'];
                $act_cat = $row['catname'];
                $act_image = $row['image'];

                $addr = "" . $act_street1 . " " . $act_street2 . " " . $act_city . ", " . $act_state . " " . $act_zip;

                // removed show_activity
                $output .= "<div class='search-result-card'>
                            <div class='image-cap'>
                            <figure class='cap'>
                                <img src='".$act_image."' alt='Activity Image' class='cap'>
                            </figure>
                            <div class='gradient-bg'>
                                <h2 id='a".$act_id."' onclick='show_activity(" .$act_id .")'>".$act_name."</h2>";

               // if (in_array($act_id, $liked_array)) {
                //    $output .= "<img src='images/liked.png' alt='like button' class='like-heart' id='heart".$act_id."' onclick='likeActivity($act_id)'>";
               // } else {
                //    $output .= "<img src='images/unliked.png' alt='like button' class='like-heart' id='heart".$act_id."' onclick='likeActivity($act_id)'>";
               // }

                $output .= "
                
                            <div id='click-here' onclick='show_activity(" .$act_id .")'>
                            </div>
                            </div>
                            </div>
                            <div class='search-result-container'>
                                <p>Location: ".$act_city."</p>
                                <p>Category: ".$act_cat."</p>
                                <p class='hidden' id='addr".$act_id."'>$addr</p>
                                <button type='button' class='button-blue' onclick='maps_popup(".$act_id.")'>View Location</button>
                                </div>
                                </div>";

                            
                                        
                        }
                    } else {
                        $output .= "No matching activities found.";
                    }
                    $output .= "</div>"
                    
                    
            
                    echo $output;
                    
               // }

        // close connection
        mysqli_close($conn);

?>
</html>