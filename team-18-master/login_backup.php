<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What Now? Login</title>
    <link href="style.css" rel="stylesheet">
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="559482906626-3tsjjg40la7c4q794s7fjnh2if784rvq.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <!-- Styling and Fonts -->
</head>

<body>
    <?php include 'load_nav_bar.php';
    session_start();
    if (isset($_SESSION['user_id'])){
        header("Location: index.php");
    }
    ?>
    
    <!-- Div to hold login/signup buttons -->
    <div class="g-login">
        <h2>Sign-in</h2>

        <div class="google-signin"></div>
        <div class="g-signin2" data-onsuccess="onSignIn"></div>
        <!-- <h4>Or <a href="#">sign-up with Google</a></h4> -->

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script>
            function onSignIn(googleUser) {
                // Useful data for your client-side scripts:
                var profile = googleUser.getBasicProfile();
                // console.log("ID: " + profile.getId());
                // console.log('Full Name: ' + profile.getName());
                // console.log('Given Name: ' + profile.getGivenName());
                // console.log('Family Name: ' + profile.getFamilyName());
                // console.log("Image URL: " + profile.getImageUrl());sonstring
                // console.log("Email: " + profile.getEmail());

                // The ID token you need to pass to your backend:
                var id_token = googleUser.getAuthResponse().id_token;
                //console.log("ID Token: " + id_token);
               
                $.ajax({
                    type: "POST",
                    url: "checkuser.php",
                    data: {
                        // groupName: $('#groupName').val(),
                        // userIDs: jsonString,
                        'google_id': profile.getId(),
                        'fname': profile.getGivenName(),
                        'lname': profile.getFamilyName(),
                        'image_url': profile.getImageUrl(),
                        'email': profile.getEmail()
                    },
                    cache: false,
                    success: function (data) {
                        console.log(data);
                        alert(data['status']);
                        if (data == 'new') {
                            location.assign('register.php?token=' + id_token);
                        }
                        else if (data == 'exists') {
                            location.assign('index.php');
                        }
                        else {
                            console.log(data);
                        }
                        // $('#group-created-modal').modal({ backdrop: 'static', keyboard: false });

                        // $('#modalGroupName').text($('#groupName').val());
                       

                        // $('#group-created-modal').on('hidden.bs.modal', function (e) {
                        //     $('#group-created-modal').modal('hide');
                        //location.assign('index.php?token=' + id_token);
                    }
                });
            }
        </script>
    </div>
    <!-- <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div> -->
    <!-- <a href="#" onclick="signOut();">Sign out</a> -->
    <script>
        function signOut() {
            var auth2 = gapi.auth2.getAuthInstance();
            auth2.signOut().then(function () {
                console.log('User signed out.');
            });
        }
    </script>
</body>
</html>