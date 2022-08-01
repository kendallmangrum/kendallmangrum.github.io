<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What Now? Search</title>
    <link rel="stylesheet" href="style.css">

    <!-- JQuery Ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Geocoder -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <!-- Styling and Fonts -->
    <link href="style.css" rel="stylesheet">

</head>
<body>
    <?php include 'load_nav_bar.php'; ?>
    <?php include 'check_permissions.php';?>

    <!-- Cover Card for Activity Viewing -->
    <div id="cover-card-container">
        <div id="cover-card">
            <div id='exit'>X</div>
            <div id='activity-data'></div>
        </div>
    </div>
    
    <div class="container">
        <div class="search-card">
            <h1>Search Activities</h1>
            <form method="POST" onsubmit="return false">
                <input type="text" name="keyword" placeholder="Enter keyword" class="field-width">
                <h3>Category</h3> 
                <select name="search-cat" style="width: 98%; margin-bottom: 20px;">
                    <option value=""></option>


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


                    // Query to get all of the categories in the database in alphabetical order
                    $result  = mysqli_query($conn, "SELECT name FROM category ORDER BY name");
                    while ($row = mysqli_fetch_assoc($result)) {
                        $name = $row['name'];
                        echo '<option value="'.$name.'">'.$name.'</option>';
                    }
                ?>
                </select>

                <h3>Price</h3>
                <input type="number" name="price" min="0" placeholder="Enter maximum price willing to pay" class="field-width">

                <h3>Number of Participants</h3>
                <input type="number" name="num-participants" min="1" placeholder="Number of Participants" class="field-width">

                <h3>Location (City)</h3>
                <input type="text" name="city" placeholder="Enter City" class="field-width">

                <h3>Location (Zipcode)</h3>
                <input type="number" name="zipcode" placeholder="Enter Zipcode" class="field-width" min="0">
                <br>

                <div class="bttn-container">
                    <input type="submit" value="Search" name="search-bttn" class="button-blue" onclick="getSearchResults()">
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    <input type="submit" value="What Now?" name="whatnow-bttn" class="what-now-button" onclick="whatnowActivities()">
                </div>
            </form>
        </div>

        <!-- Div to display the search results -->
        <div id="target">

        </div>


    </div>

    <div id="toast">Activity has been added to your liked activities!</div>
    <div id="toast-r">Activity has been removed from your liked activities!</div>

    <!-- Javascript function to get activities when What Now? button is pressed -->
    <script type="text/javascript">
        function whatnowActivities() {
            $.ajax({
                type: "GET",
                url: "whatnow_search.php",
                dataType: "html",
                success: function(response) {
                    document.getElementById('target').innerHTML = response;
                }
            });
        }
    </script>

    <!-- Javascript function to get activities when search button is pressed -->
    <script type="text/javascript">
        function getSearchResults() {
            $("form").on("submit", function(event) {
                event.preventDefault();
                var formValues = $(this).serialize();

                $.post("search_query.php", formValues, function(data){
                    document.getElementById('target').innerHTML = data;
                });
            });
            
        }
    </script>
    
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

        <!-- fucntion to get the coordinates of activity address -->
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

        <!-- API key to load Google Map -->
        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJxkf0ohU_fkl9eF33LGSvy6iv0dbV1Xo"
            async
        ></script>


</body>
</html>


