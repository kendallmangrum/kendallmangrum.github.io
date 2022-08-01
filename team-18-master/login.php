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
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- Styling and Fonts -->
</head>
<body class='color_background'>

    <?php include 'load_nav_bar.php';
    if (isset($_SESSION['user_id'])){
        //echo "session not set";
        header("Location: index.php");
    }
    ?>
    <div class="container search-card" id="sign-in-page">
        <h1>Welcome to <span id="what-now-text">What Now?</span></h1>
        <p>Discover exciting new things to do in your area! Invite your friends to try something new or share your favorite actvities with the rest of the world.</p>

        <div class="google-signin"></div>
        <div class="g-signin2" data-onsuccess="onSignIn"></div>
    </div>

    <script>
        function onSignIn(googleUser) {
            var profile = googleUser.getBasicProfile();
            var id_token = googleUser.getAuthResponse().id_token;
            $.ajax({
                type: "POST",
                url: "checkuser.php",
                data: {
                    'google_id': profile.getId(),
                    'email': profile.getEmail()
                },
                cache: false,
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj.status == 'new') {
                        location.assign('register.php');
                        
                    }
                    else if (obj.status == 'exists') {
                        location.assign('index.php');
                       
                    }
                    else {
                        console.log(data);
                    }
                }
            });
        }

    </script>

</body>
</html>
