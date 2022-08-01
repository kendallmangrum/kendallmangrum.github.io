<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What Now? Friends</title>

    <!-- Styling and Fonts -->
    <link href="style.css" rel="stylesheet">

    <!-- All js -->
    <!--jQuery Ajax-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- request all friends for user on page load -->
    <script type="text/javascript">
    function load_friends() {
        $(document).ready(function() {
            $.ajax({    //create an ajax request to access_notifications.php
                type: "GET",
                url: "access_friends.php",             
                dataType: "html",   //expect html to be returned                
                success: function(response){                    
                    document.getElementById("friends").innerHTML = response;
                },
            });
        });
    }
    function get_friend_requests() {
        // console.log(friend_id);
            var url = 'access_friends.php',
            data =  {'action': 'get_friend_requests'};
            $.post(url, data, function (response) {
                // Response div goes here.
                if(response != ""){
                    //What do?
                    document.getElementById('friend-request-container').innerHTML = response;
                }
                else{
                    console.log('Unable to view friend information.');
                }
                // console.log(response);
            });
    }

    load_friends();
    get_friend_requests();
    </script>

    <!-- check if already logged in -->
    <?php 
    include 'check_permissions.php';
    // $user_id = '100233765235755679450';
    // $user_id = '100233765235755679455';
    ?>
    

    <!-- js functions -->
    <script type="text/javascript">
    function del_note(note_id) {
        var url = 'access_notifications.php',
        data =  {'action': 'del_notification', 'id': note_id};
        $.post(url, data, function (response) {
            // Response div goes here.
            if(response == "success"){
                //alert("Notification successfully deleted.");
                document.getElementById(note_id).style.display = "none";
            }
            else{
                console.log('Unable to delete notification.');
            }
            //console.log(response);
        });
    }
    </script>
    
</head>
<body>
    <!-- Navigation -->
    <?php include 'load_nav_bar.php';?>
    
    <!-- main  -->
    <div class="friends-container">
        <div class="list-left">
            <h3>My Friends</h3>
            <div class="friends-list" id="friends">
                <!-- built from ajax GET request -->
            </div>
        </div>
        <div id="friends-right">
            <div id="friend-request-container">
                <!-- Friend Notifications Generate Here -->
            </div>            
            <!-- Friend Search Results Generate Here -->
            <div class="friends-search">
                <h2>Search for Friends</h2>
                <form method="POST" onsubmit="return false">
                    <input type="text" name="user-name" placeholder="Who is your friend?" class="search-max-width">
                    <div class="bttn-container">
                        <input type="submit" value="Search" name="search-bttn" class="button-blue" onclick="getSearchResults()">
                    </div>
                </form>
                <div id="friends-results">
                    <!-- List of searched friends will go here -->
                </div>
            </div>


        </div>
    </div>

    <div id="cover-card-container">
        <div id="cover-card">
            <div id='exit'>X</div>
            <div id='card-data'></div>
        </div>
    </div>

    <!-- Use BigInt js to deal with long user IDs -->
    <script src="https://peterolson.github.io/BigInteger.js/BigInteger.min.js"></script>
    <script type="text/javascript">
        document.getElementById("exit").addEventListener("click", exit_cover);

        // Allows the user to hide the cover card and the card is reset
        function exit_cover() {
            document.getElementById("cover-card-container").style.visibility = "hidden";
            document.getElementById("card-data").innerHTML = "";
            document.getElementsByTagName("BODY")[0].style.overflow = "auto";
        }
        
        //Removes the request div and updates the DB
        function del_note(notif_id) {
            //set the visibility to none
            //make a request to delete the notification from the Notfications table
            //the ID of the div to hide is the NOTIFICATION ID. NOT the user ID
        }

        // Get all data on that friend and generate a cover card
        function get_friend(friend_id) {
            // console.log(friend_id);
            var url = 'access_friends.php',
            data =  {'action': 'get_friend', 'friend_id': friend_id};
            $.post(url, data, function (response) {
                // Response div goes here.
                if(response != ""){
                    document.getElementById("cover-card-container").style.visibility = "visible";
                    document.getElementById("card-data").innerHTML = response;
                    document.getElementsByTagName("BODY")[0].style.overflow = "hidden";
                }
                else{
                    console.log('Unable to view friend information.');
                }
                // console.log(response);
            });
        }

        // Request user to be friends
        function request_friend(friend_id) {
            //take the two IDs and add both to the Friends table
            var url = 'access_friends.php',
            data =  {'action': 'request_friend', 'friend_id': friend_id};
            console.log(friend_id);
            $.post(url, data, function (response) {
                // Response div goes here.
                if(response === "success"){
                    console.log('Successfully requested friend.');
                    document.getElementById(friend_id).classList.add('button-grey');
                    document.getElementById(friend_id).classList.remove('button-blue');
                    document.getElementById(friend_id).innerHTML = "Request Sent";
                    document.getElementById(friend_id).onclick = "";
                }
                else{
                    console.log('Unable to request friend.');
                }
                console.log(response);
            });
            // Reload the friends list
            load_friends();
        }

        // Add the requesting user to friends list
        function accept_friend(friend_id) {
            //take the two IDs and add both to the Friends table
            var url = 'access_friends.php',
            data =  {'action': 'accept_friend', 'friend_id': friend_id};
            $.post(url, data, function (response) {
                // Response div goes here.
                if(response === "success"){
                    console.log('Successfully added friend.');
                    document.getElementById("banner" + friend_id).style.display = "none";
                }
                else{
                    console.log('Unable to add friend.');
                }
                console.log(response);
            });
            // Reload the friends and requests 
            load_friends();
            setTimeout(() => {  get_friend_requests(); }, 2000);
        }

        // Remove the user from the friends list
        function remove_friend(friend_id) {
            // Remove entry in table that has both my ID and Friend_ID
            var url = 'access_friends.php',
            data =  {'action': 'remove_friend', 'friend_id': friend_id};
            $.post(url, data, function (response) {
                if(response === "success"){
                    console.log('Successfully removed friend.');
                    document.getElementById(friend_id).innerHTML = "Removed Friend (Undo)";
                    document.getElementById(friend_id).onclick = 'request_friend("' + friend_id + '")';
                }
                else{
                    console.log('Unable to remove friend.');
                }
                console.log(response);
            });

            // Reload list of friends
            load_friends();
        }

        // Remove the user from the friend requests list (DENY request)
        function deny_friend(friend_id) {
            // Remove entry in table that has both my ID and Friend_ID
            var url = 'access_friends.php',
            data =  {'action': 'deny_friend', 'friend_id': friend_id};
            $.post(url, data, function (response) {
                // Response div goes here.
                if(response === "success"){
                    console.log('Successfully denied request.');
                    document.getElementById("banner" + friend_id).style.display = "none";
                }
                else{
                    console.log('Unable to remove friend request.');
                    console.log(response);
                }
                console.log(response);
            });
            // Reload list of requests
            // setTimeout(() => {  get_friend_requests(); }, 2000);

        }

        function getSearchResults() {
            $("form").on("submit", function(event) {
                event.preventDefault();
                // console.log($(this));
                var formValues = $(this).serialize();
                var cleanFormValues = formValues.replace(/^(.*?)=/, "");
                // console.log(formValues);
                data =  {'action': 'search_users', 'user_in': cleanFormValues};
                $.post("access_friends.php", data, function(response){
                    if(response != ""){
                        document.getElementById('friends-results').innerHTML = response;
                    }
                    else {
                        document.getElementById('friends-results').innerHTML = "<p>Opps! Looks like we couldn't find anyone with that information.</p>";
                    }
                });
            });
        }
    </script>

</body>
</html>