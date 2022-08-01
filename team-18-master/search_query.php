<html>
    <head>
        <title>What Now? - Search Results</title>
        <link href="style.css" rel="stylesheet">
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
        //$user_id = '100233765235755679450';

        // Determine what activities a user has liked
        $test = 'user_id';
        $sql_liked = "SELECT activity_id FROM likes WHERE user_id = '$user_id'";
        $liked_acts = mysqli_query($conn, $sql_liked);
        $liked_array = [];

        if (mysqli_num_rows($liked_acts) > 0) {
            while ($r = mysqli_fetch_assoc($liked_acts)) {
                $r = $r['activity_id'];
                array_push($liked_array, $r);
            }
        }

        

        // form variables and sanitize them
        $keyword = cleanse_input($_POST['keyword']);
        $category = cleanse_input($_POST['search-cat']);
        $price = cleanse_input($_POST['price']);
        $num_part = cleanse_input($_POST['num-participants']);
        $city_name = cleanse_input($_POST['city']);
        $zipcode = cleanse_input($_POST['zipcode']);

        // Base SQL SELECT statement 
        $sql_search = "SELECT DISTINCT activity.id, activity.name, activity.description, activity.open_time, activity.close_time, activity.price, activity.street1, activity.street2, activity.city, activity.state, activity.zip, 
                activity.max_participants, activity.image, activity.about_url, category.name as catname FROM activity, activity_categories, category WHERE ";

        // Keyword
        if($keyword != "") {
            $sql_search .= "activity.description LIKE '%{$keyword}%' ";
        }

        // Category
        if($category != "" && $keyword != "") {
            $sql_search .= "AND category.name = '$category' ";
        }else if($category != "") {
            $sql_search .= "category.name = '$category' ";
        }

        // Price
        if($price != "" && ($keyword != "" || $category != "")) {
            $sql_search .= "AND activity.price <= $price ";
        }else if($price != "") {
            $sql_search .= "activity.price <= $price ";
        }

        // Participants
        if($num_part != "" && ($keyword != "" || $category != "" || $price != "")) {
            $sql_search .= "AND activity.max_participants >= $num_part OR activity.max_participants = 0 ";
        }else if($num_part != "") {
            $sql_search .= "activity.max_participants >= $num_part OR activity.max_participants = 0 ";
        }

        // City 
        if($city_name != "" && ($keyword != "" || $category != "" || $price != "" || $num_part != "")) {
            $sql_search .= "AND activity.city = '$city_name' ";
        }else if($city_name != "") {
            $sql_search .= "activity.city = '$city_name' ";
        }

        // Zipcode
        if($zipcode != "" && ($keyword != "" || $category != "" || $price != "" || $num_part != "" || $city_name != "")) {
            $sql_search .= "AND activity.zip = '$zipcode' ";
        }else if($zipcode != "") {
            $sql_search .= "activity.zip = '$zipcode' ";
        }

        // If all are blank
        if($keyword == "" && $category == "" && $price == "" && $num_part == "" && $city_name == "" && $zipcode == "") {
            $sql_search .= "activity.id = activity_categories.activity_id AND category.id = activity_categories.category_id GROUP BY activity.id ORDER BY activity.name ASC";
        } else {
            $sql_search .= "AND activity.id = activity_categories.activity_id AND category.id = activity_categories.category_id GROUP BY activity.id ORDER BY activity.name ASC";
        }
        
        
        // Add Search results heading and container for flexbox display
        $output = "<h1 class='search-heading'>Search Results</h1>
                <div class='flex-search-container'>";

        // Display search results
        $sql_result = mysqli_query($conn, $sql_search);
        if (mysqli_num_rows($sql_result) > 0) {
            while ($row = mysqli_fetch_assoc($sql_result)) {
                $act_id = $row['id'];
                $act_name = $row['name'];
                $act_city = $row['city'];
                $act_cat = $row['catname'];
                $act_image = $row['image'];
                $act_street1 = $row['street1'];
                $act_street2 = $row['street2'];
                $act_state = $row['state'];
                $act_zip = $row['zip'];

                $addr = "" . $act_street1 . " " . $act_street2 . " " . $act_city . ", " . $act_state . " " . $act_zip;

                // Append the search results to output variable
                $output .= "<div class='search-result-card'>
                        <div class='image-cap'>
                            <figure class='cap'>
                                <img src='uploads/".$act_image."' alt='Activity Image' class='cap'>
                            </figure>
                            <div class='gradient-bg'>
                                <h2 id='a".$act_id."' onclick='show_activity(" .$act_id .")'>".$act_name."</h2>"; //Add show activity popup here
                                
                if (in_array($act_id, $liked_array)) {
                    $output .= "<img src='images/liked.png' alt='like button' class='like-heart' id='heart".$act_id."' onclick='likeActivity($act_id)'>";
                } else {
                    $output .= "<img src='images/unliked.png' alt='like button' class='like-heart' id='heart".$act_id."' onclick='likeActivity($act_id)'>";
                }            

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
        $output .= "</div>
        
        <script type='text/javascript'>
        var images = document.getElementByClassName('like-heart');
        for (let i = 0; i < images.length; i++) {
            images[i].addEventListener('click', likeActivity);
            console.log('images[i]');
        }
        </script>";

        echo $output;
        
        // close connection
        mysqli_close($conn);


        

        // Function to cleanse data
        function cleanse_input($data) {
            $data = trim($data);
            $data = stripslashes($data); 
            $data = htmlspecialchars($data);
            return $data;
        }
 
    ?>
    </html>