<?php
// Start or resume the session
session_start();

// Check if the session variable 'stat' exists and assign its value to $stat, or set $stat to an empty string as a default
if (isset($_SESSION['stat'])) {
    $stat = $_SESSION['stat'];
} else {
    $stat = ""; // Default value if the session variable 'stat' does not exist
}

// If the user is not authorized (stat != "su"), display an error page
if ($stat != "su") {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <?php
    // Function to render the error page for unauthorized access
    function errPageAuth() {
        echo '
        <head>
            <!-- Link to external stylesheet for styling -->
            <link rel="stylesheet" href="style.css">
            <title>Compute companion - Error</title> <!-- Title of the error page -->
            <link rel="icon" type="image/png" href="favicon.png"> <!-- Favicon for the error page -->
        </head>
        <body>
            <!-- Include necessary JavaScript libraries -->
            <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
            <script type="module" src="script.js"></script>
            <section>
                <div class="form-box">
                    <div class="form-value">
                        <!-- Error message for incorrect login -->
                        <h2>Incorrect Username or Password</h2>
                        <div class="register">
                            <form action="index.html" method="post">
                                <!-- Logout button to redirect users back to the login page -->
                                <p><button type="submit" class="friend">Logout</button></p>
                                <!-- Hidden input field to indicate logout action -->
                                <input type="hidden" id="logout" name="logout" value="true">
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </body>';
    }

    // Call the error page rendering function
    errPageAuth();
    ?>
    <script type="text/javascript">
        // JavaScript function to auto-submit a form (currently disabled by commenting out)
        function formAutoSubmit() {
            var frm = document.getElementById("form");
            frm.submit();
        }
        // window.onload = formAutoSubmit; // Disabled auto-submit functionality
    </script>
    </html>
    <?php
} else {
    // If the user is authorized (stat == "su"), display the main home page
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <!-- Link to external stylesheets for layout and design -->
        <link rel="stylesheet" href="style.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="navstyle.css">
        <title>compute companion-learn</title> <!-- Title for the authorized user's page -->
    </head>
    <body>
        <!-- Navigation bar -->
        <nav>
            <!-- Checkbox for toggling the menu visibility -->
            <input type="checkbox" id="check">

            <!-- Label for the toggle checkbox, containing the menu icon -->
            <label for="check" class="checkbtn">
                <i class="fas fa-bars"></i> <!-- Icon for a hamburger menu -->
            </label>

            <!-- Logo for the website -->
            <div class="logo">
                <a href="home.php">Compute Companion</a> <!-- Link back to the home page -->
            </div>

            <!-- Navigation menu links -->
            <ul>
                <li><a href="aboutus.html">About Us</a></li> <!-- Link to About Us page -->
                <li><a href="#">Messages</a></li> <!-- Placeholder link for messages -->
                <li class="dropdown">
                    <a href="#">Account</a> <!-- Dropdown menu for account-related options -->
                    <ul class="dropdown-content">
                        <li><a href="#">Profile</a></li> <!-- Link to user profile -->
                        <li><a href="#">Settings</a></li> <!-- Link to settings page -->
                        <li><a href="logout.php">Logout</a></li> <!-- Link to logout functionality -->
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- Main content section -->
        <div class="home_page">
            <div class="button-container">
                <!-- Button linking to the subject videos section -->
                <a href="videos.php" class="hom-but">
                    <div class="button-content">
                        <div class="icon">
                            <img src="video-tutorial.gif" alt="Icon 1" /> <!-- Icon for subject videos -->
                        </div>
                        <div class="text">
                            <h3>subject videos</h3> <!-- Title of the section -->
                            <p>a bank of use full videos to help fill in gaps in knowledge</p> <!-- Description -->
                        </div>
                    </div>
                </a>
                <!-- Button linking to notes and PowerPoint resources -->
                <a href="read.php" class="hom-but">
                    <div class="button-content">
                        <div class="icon">
                            <img src="presentation.gif" alt="Icon 2" /> <!-- Icon for notes and PowerPoints -->
                        </div>
                        <div class="text">
                            <h3>notes and powerpoints</h3> <!-- Title of the section -->
                            <p>a place full of reading resourses for you to use to gain knoledge</p> <!-- Description -->
                        </div>
                    </div>
                </a>
            </div>
    </body>
    </html>
    <?php
}
?>
