<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What Now? Google Maps</title>
    <link rel="stylesheet" href="style.css">

    <!-- JQuery Ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Geocoder -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    
    
    <!-- Styling and Fonts -->
    <link href="style.css" rel="stylesheet">

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
                });
                const geocoder = new google.maps.Geocoder();
                geocodeAddress(geocoder, map);
            }
        
        </script>
        

</head>
<body>
    <?php include 'load_nav_bar.php'; ?>
    <?php include 'check_permissions.php';?>

    <div class="container">
        
        <h2 id="activity-name"></h2>
        <h3 id="activity-address"></h3>
        <div id="map">
        </div>


    </div>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJxkf0ohU_fkl9eF33LGSvy6iv0dbV1Xo&callback=initMap&libraries=&v=weekly"
      async
    ></script>

    <!-- API key: AIzaSyCJxkf0ohU_fkl9eF33LGSvy6iv0dbV1Xo -->


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

</html>