<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>What Now? Liked Activities</title>
        <link rel="stylesheet" href="style.css">

        <!-- JQuery Ajax -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Styling and Fonts -->
        <link href="style.css" rel="stylesheet">

    </head>
    <body>
        <?php include 'load_nav_bar.php'; ?>

        <!-- Cover Card for Activity Viewing -->
    <div id="cover-card-container">
        <div id="cover-card">
            <div id='exit'>X</div>
            <div id='activity-data'></div>
        </div>
    </div>

        <div class="container">
            <h1>Your Liked Activities</h1>
            <div class="flex-search-container">

            <!-- input liked activities here -->
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
                // $user_id = '100233765235755679450';
                include 'check_permissions.php';

                // SQL statement to get the information about the activities they have liked
                $sql = "SELECT activity.id, activity.name, activity.image, activity.city, activity.street1, activity.street2, activity.state, activity.zip, category.name as catname FROM 
                activity, activity_categories, category, likes WHERE activity.id = activity_categories.activity_id 
                AND category.id = activity_categories.category_id AND likes.activity_id = activity.id AND likes.user_id = '$user_id' 
                GROUP BY activity.id ORDER BY activity.name ASC";

                // Create output variable
                $output= "";
                
                // Loop through query results to create activity cards to display
               $sql_result = mysqli_query($conn, $sql);
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

                        // Create activity cards
                        $output .= "<div class='search-result-card'>
                                        <div class='image-cap'>
                                            <figure class='cap'>
                                                <img src='uploads/".$act_image."' alt='Activity Image' class='cap'>
                                            </figure>
                                            <div class='gradient-bg'>
                                                <h2 id='a".$act_id."' onclick='show_activity(" .$act_id .")'>".$act_name."</h2>
                                                <img src='images/liked.png' alt='like button' class='like-heart' id='heart".$act_id."' onclick='likeActivity($act_id)'>
                                                <div id='click-here' onclick='show_activity(" .$act_id .")'>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='search-result-container'>
                                            <p>Location: ".$act_city."</p>
                                            <p>Category: ".$act_cat."</p>
                                            <p class='hidden' id='addr".$act_id."'>$addr</p>
                                            <button type='button' class='button-blue' onclick='maps_popup(" .$act_id .")'>View Location</button>
                                        </div>
                                    </div>";
                   }
               } else {
                   $output .= "<p>Looks like you haven't liked any activities yet...</p>";
               }
               

               echo $output;
            //    close connection
            mysqli_close($conn);


            ?>

            <div id="toast">Activity has been added to your liked activities!</div>
            <div id="toast-r">Activity has been removed from your liked activities!</div>
        </div>
        
        <!-- Javascript function to allow users to like and unlike activities -->
        <script type='text/javascript'>
                function likeActivity(act_id) {
                    console.log(act_id); 
                    let image = document.getElementById('heart' + act_id);

                    if (image.src.match('images/unliked.png')) {
                        image.src = 'images/liked.png';

                        let msg = document.getElementById('toast');
                        msg.className = 'show';
                        setTimeout(function() {msg.className = msg.className.replace('show', ''); }, 3000);

                        $.ajax({
                            type: 'POST',
                            url: 'update_liked_activities.php',
                            data: {'action': 'add_liked', 'id': act_id},
                            success: function() {
                                // alert('Activity has been added to your liked Activities!');
                            }
                        });
                    }else {
                        image.src = 'images/unliked.png';

                        let msg = document.getElementById('toast-r');
                        msg.className = 'show';
                        setTimeout(function() {msg.className = msg.className.replace('show', ''); }, 3000);

                        $.ajax({
                            type: 'POST', 
                            url: 'update_liked_activities.php',
                            data: {'action': 'remove_liked', 'id': act_id},
                            success: function() {
                                // alert('Activity has been removed from your liked Activities.');
                            }
                        });
                    }
                }
        </script>

        <script type="text/javascript">
            document.getElementById("exit").addEventListener("click", exit_cover);

            function exit_cover() {
                document.getElementById("cover-card-container").style.visibility = "hidden";
                document.getElementById("activity-data").innerHTML = "";
                document.getElementsByTagName("BODY")[0].style.overflow = "auto";
            }
        </script>


        <!-- Function to show actiivty details -->
        <script type="text/javascript">
            function show_activity(activity_id) {
                var url = 'access_activities.php',
                data = {'action': 'view_activity', 'id': activity_id};
                $.post(url, data, function (response) {
                    // response div goes here.
                    if(response != "") {
                        document.getElementById("cover-card-container").style.visibility = "visible";
                        document.getElementById("activity-data").innerHTML = response;
                        document.getElementsByTagName("BODY")[0].style.overflow = "hidden";
                    } else {
                        console.log("Unable to view activity");
                    }
                });
            }
            
        </script>

            <!-- Show activity location on maps -->
        <script type="text/javascript">
            function show_maps(activity_id) {
                localStorage.setItem("activity_id", activity_id);

                address = document.getElementById("addr" + activity_id).innerText;
                localStorage.setItem("address", address);

                act_name = document.getElementById("a"+activity_id).innerText;
                localStorage.setItem("name", act_name);
                // console.log(address);
                window.location.href="access_maps.php";
            }
        </script>

        <script type="text/javascript">
            function maps_popup(activity_id) {
                localStorage.setItem("activity_id", activity_id);
                address = document.getElementById("addr" + activity_id).innerText;
                localStorage.setItem("address", address);
                act_name = document.getElementById("a"+activity_id).innerText;
                localStorage.setItem("name", act_name);
                
                document.getElementById("cover-card-container").style.visibility = "visible";
                document.getElementById("activity-data").innerHTML = "<h2 id='activity-name'></h2><h3 id='activity-address'></h3><div id='map'></div>";
                document.getElementsByTagName("BODY")[0].style.overflow = "hidden";
                initMap();
            }
        </script>

        <!-- Generate Google Maps -->
        <script type="text/javascript">
            // Initialize and add the map
            function initMap() {
                // The location
                const bloomington = { lat: 39.1653, lng: -86.5264 };
                // The map, centered at Uluru
                const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 16,
                center: bloomington,
                // mapTypeId: 'satellite'
                });
                const geocoder = new google.maps.Geocoder();
                geocodeAddress(geocoder, map);
            }
        </script>

        <script type="text/javascript">
            function geocodeAddress(geocoder, resultsMap) {
                const location = localStorage.getItem("address");
                const name = localStorage.getItem("name");
                const h2 = document.getElementById("activity-name");
                h2.innerText = name;
                const h3 = document.getElementById("activity-address");
                h3.innerText = location;
                geocoder.geocode({address: location}, (results, status) => {
                    if (status == "OK") {
                        resultsMap.setCenter(results[0].geometry.location);
                        new google.maps.Marker({
                            map: resultsMap,
                            position: results[0].geometry.location,
                            // label: name,
                        });
                    } else {
                        alert("Geocode was not successful for the following reason: " + status);
                    }
                });
            }
        </script>


        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJxkf0ohU_fkl9eF33LGSvy6iv0dbV1Xo"
            async
        ></script>
        
        </body>
</html>