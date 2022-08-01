<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <title>What Now? Register</title>
    <!-- Styling and Fonts -->
</head>
<body>
    <?php include 'load_nav_bar.php'; ?>


    <div class="registration">
        
            <!-- Insert Important Form Stuff -->
            <div class="container">
                <h1>Set up Profile</h1>
                <div class="profile-card">
                    <!-- Build Procedurally -->
                    <!-- Form for user to upload a new profile picture -->
                    

                    <!-- Form for user to update information such as first/last name, zipcode, bio, and add new favorite categories -->
                    <form action="saveUser.php" method="POST" class="edit-form" enctype="multipart/form-data">
                        <h4>Profile Image</h4>
                        <input type="file" name="file" id="file" required>
                        <h4>Username</h4>
                        <input type='text' name='username' id='username' class='input-width' value='' required>
                        <h4>First Name</h4>
                        <input type='text' name='fname' id='fname' class='input-width' value='' required>
                        <h4>Last Name</h4>
                        <input type='text' name='lname' id='lname' class='input-width' value='' required>
                        <h4>Zip</h4>
                        <input type='number' name='zipcode' id='zipcode' class='input-width' value='' min="10000" max="99999">
                        <h4>Bio</h4>
                        <textarea type='text' name='user-bio' id='user-bio' class='input-width'> </textarea>
                        <h4>Favorite Categories</h4>
                        <select name="new-cat" id="select">
                            <option value=""></option>


                            <option value="Food">Food</option>
                            <option value="Movies">Movies</option>
                            <option value="Music">Music</option>
                            <option value="Nature">Nature</option>
                            <option value="Outdoors">Outdoors</option>
                            <option value="Recreation">Recreation</option>
                            <option value="Religious">Religious</option>
                            <option value="Shopping">Shopping</option>
                            <option value="Shows">Shows</option>
                            <option value="Sports">Sports</option>
                        </select>
                        <br>

                        <a href='#' class='button-grey' onclick='signOut();'>Cancel</a>
                        <input type="submit" value="Save" name="save-bttn" class='button-blue'>
                        
                        &nbsp;

                    </form>
                </div>
            </div>

           
            <h4> <a href="#">sign-up with Google</a></h4>
        
    </div>
  
</body>
</html>