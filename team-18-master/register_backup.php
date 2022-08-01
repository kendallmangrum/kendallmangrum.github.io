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
        <form>
            <!-- Insert Important Form Stuff -->
            <div class="container">
                <h1>Set up Profile</h1>
                <div class="profile-card">
                    <!-- Build Procedurally -->
                    <!-- Form for user to upload a new profile picture -->
                    <form action="update_user_picture.php" method="POST" enctype="multipart/form-data">
                        <h4>Profile Image</h4>
                        <input type="file" name="file" id="file">
                        <input type="submit" value="upload" name="submit">
                    </form>

                    <!-- Form for user to update information such as first/last name, zipcode, bio, and add new favorite categories -->
                    <form action="update_user.php" method="POST" class="edit-form">
                        <h4>First Name</h4>
                        <input type='text' name='fname' id='fname' class='input-width' value=''>
                        <h4>Last Name</h4>
                        <input type='text' name='lname' id='lname' class='input-width' value=''>
                        <h4>Zip</h4>
                        <input type='number' name='zipcode' id='zipcode' class='input-width' value=''>
                        <h4>Bio</h4>
                        <textarea type='text' name='user-bio' id='user-bio' class='input-width'> </textarea>
                        <h4>Favorite Categories</h4>
                        <select name="new-cat" id="select">
                            <option value=""></option>

                            <!-- Connect to database to auto fill the dropdown menu with activity categories in the database -->
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
                        <!-- Save and Cancel buttons -->
                        <!--<input type="submit" value="Save" name="save-bttn"> &nbsp; <a href="profile.php"><button>Cancel</button></a> -->
                        <button type="button" onclick="saveForm()">Save</button>
                    </form>
                </div>
            </div>

            <!---<button type="submit" class="submit">Save</button> -->
            <h4> <a href="#">sign-up with Google</a></h4>
        </form>
    </div>

    <script>src = "https://code.jquery.com/jquery-3.5.1.min.js"</script>

    <script>

        //*******************************************************
        //Start - saveForm
        //*******************************************************
        function saveForm() {
            var firstname = $('#fname').val();
            alert(firstname);
            $.ajax
                ({
                    type: 'POST',
                    url: 'updateComments.php',
                    dataType: 'json',
                    data: {
                        comments: $('#fname').val(),
                        userProfile: userProfile,
                        createdBy: createdBy,
                        createdOn: createdOn,
                        employeeFullName: $('#employeeName').val()
                    },
                    cache: false,
                    success: function (data) {
                        alert('OK');
                    },

                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Error: ' + textStatus + ' ' + errorThrown)
                    }
                }); //* End - $.ajax

        }//*End - saveForm()
    </script>
</body>
</html>