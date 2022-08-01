<!-- google login references for sign out button -->
<meta name="google-signin-scope" content="profile email">
<meta name="google-signin-client_id" content="559482906626-3tsjjg40la7c4q794s7fjnh2if784rvq.apps.googleusercontent.com">
<!-- <script src="https://apis.google.com/js/platform.js" async defer></script> -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<!-- js that hides & unhides content -->
<script src="js/responsive_nav.js" crossorigin="anonymous"></script>

<!-- hamburger icon -->
<script src="https://kit.fontawesome.com/bf37eaf948.js" crossorigin="anonymous"></script>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<nav class="prime-nav">
    <!-- <img class="logo-thumb" alt="What Now Logo" src="resources/..."> -->
    <div class="left-nav">
        <h1><span id='what-now'><a href="index.php">What Now?</a></span></h1>
        
        <!-- hamburger icon, only appears on mobile -->
        <div class="buger-menu" onclick="toggleDropdown()">
            <i class="fas fa-bars fa-2x"></i>
        </div>
        <!-- <script src="https://kit.fontawesome.com/bf37eaf948.js" crossorigin="anonymous"></script> -->

        <div class="dropdown toggle-item-view">
            <h1 class="nav-option">Activities</h1>
            <!-- <i class="fa fa-caret-down"></i> -->
            <div class="dropdown-content">
                <h1><a href="index.php">Search</a></h1>
                <h1><a href="create_activity.php">+ Create New</a></h1>
                <h1><a href="my_activities.php">My Activities</a></h1>
                <h1><a href="liked.php">Liked</a></h1>
                <h1><a href="history.php">Schedule</a></h1>
            </div>
        </div>
        <h1 class="toggle-item-view"><a class="nav-option" href="./friends.php">Friends</a></h1>
        <div class="dropdown toggle-item-view">
            <h1 class="nav-option">Groups</h1>
            <!-- <i class="fa fa-caret-down"></i> -->
            <div class="dropdown-content">
                <h1><a href="./groups.php">Create Group</a></h1>
                <h1><a href="./viewUserGroups.php">View Group</a></h1>
                <h1><a href="./getGroupActivity.php">Get Group Activities</a></h1>
            </div>
        </div>
    </div>

    <div class="right-nav toggle-item-view">
        <?php
            session_start();
            if(isset($_SESSION['user_id'])){
                $conn=mysqli_connect('db.luddy.indiana.edu','i494f20_team18', 'my+sql=i494f20_team18', 'i494f20_team18');

                //attempt to connect
                if (mysqli_connect_errno()){
                    echo 'Failed to connect to MySQL: ' .mysqli_connect_error();
                }
            
                //get user's profile picture
                $sql = "SELECT profile_picture FROM user WHERE google_id = '" . $_SESSION['user_id'] . "'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
                $prof_image = $row["profile_picture"];
                //set correct image
                $image_src = "uploads/$prof_image";

                //check if the user has any notifications
                $sql = "SELECT * FROM notification WHERE reciever_id = '" . $_SESSION['user_id'] . "'";
                $result = mysqli_query($conn, $sql);
                //pick right image
                if (mysqli_num_rows($result) > 0){
                    $bell_img_src = "images/bell-icon-color.png";
                }
                else {
                    $bell_img_src = "images/bell-icon.png";
                }
            }
            else {
                $image_src = "images/profile-icon.png";
                $bell_img_src = "images/bell-icon.png";
            }
        ?>

        <a href='notifications.php'>
            <img src="<?php echo $bell_img_src; ?>" width="30px" height="30px" class="notif-bell">
        </a>    
        <a href="profile.php">
            <img src="<?php echo $image_src; ?>" width="30px" height="30px" class="prof-pic round">
        </a>
        
        <div class="login-status">
            <!-- Generated based on their login status -->
            <?php
            if(isset($_SESSION['user_id']) || isset($_SESSION['incomming_id'])){
                // echo '<a  href="signout.php" >Sign-out</a>';
                echo "<h1><a href='#' class='button-grey' onclick='signOut();' style='margin-right: 20px;'>Sign out</a></h1>";
                

            } else {
                echo '<h1><a class="button-blue" href="login.php" style="margin-right: 20px;">Sign-In</a></h1>';
            }
            

            ?>
            <!-- <h1><a class="sign-up" href="./register.html">Sign-up</a></h1> -->
        </div>
    </div>
</nav>

<!-- google sign in/out script -->
<script>
    function signOut() {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
            console.log('User signed out.');
            location.assign('signout.php');
        });
    }
    function onLoad() {
        gapi.load('auth2', function() {
            gapi.auth2.init();
        });
    }
</script>
<script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>
