<?php
session_start();  // Start the session or resume it

// Check if the session variable 'stat' exists. If so, assign it to $stat, otherwise set $stat to an empty string
if (isset($_SESSION['stat'])) {
    $stat = $_SESSION['stat'];
} else {
    $stat = "";  // Default to empty string if 'stat' is not set
}

// If the session variable 'stat' is not equal to "su" (authorized user), display an error page
if ($stat != "su") {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <?php
    // Function to display the error page for unauthorized users
    function errPageAuth() {
        echo '
        <head>
            <link rel="stylesheet" href="style.css">  <!-- Link to the external stylesheet -->
            <title>Compute companion - Error</title>  <!-- Title for the error page -->
            <link rel="icon" type="image/png" href="favicon.png">  <!-- Favicon for the error page -->
        </head>
        <body>
            <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script> <!-- Ionicons script -->
            <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script> <!-- For older browsers -->
            <script type="module" src="script.js"></script>  <!-- Link to an external JavaScript file -->
            <section>
                <div class="form-box">
                    <div class="form-value">
                        <h2>Incorrect Username or Password</h2>  <!-- Error message displayed -->
                        <div class="register">
                            <form action="index.html" method="post">  <!-- Form for redirection to login page -->
                                <p><button type="submit" class="friend">Logout</button></p>  <!-- Logout button -->
                                <input type="hidden" id="logout" name="logout" value="true">  <!-- Hidden input for logout action -->
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </body>';
    }

    // Call the function to render the error page
    errPageAuth();
    ?>
    <script type="text/javascript">
        // This function auto-submits the form if needed (commented out in the code)
        function formAutoSubmit() {
            var frm = document.getElementById("form");
            frm.submit();
        }
        // window.onload = formAutoSubmit;  // This line was commented out, so auto-submit is disabled
    </script>
    </html>
    <?php
} else {
    // If the user is authorized (stat == "su"), display the main home page
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <link rel="stylesheet" href="style.css">  <!-- Link to external stylesheet for styling the page -->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>  <!-- Link to Boxicons library for icons -->
        <link rel="stylesheet" href="navstyle.css">  <!-- Link to custom navigation bar styling -->
        <title>compute companion-learn</title>  <!-- Title for the authorized page -->
    </head>
    <body>
        <nav>
            <!-- Checkbox for toggling the navigation menu on smaller screens -->
            <input type="checkbox" id="check">

            <!-- Label to trigger the menu toggle (hamburger menu icon) -->
            <label for="check" class="checkbtn">
                <i class="fas fa-bars"></i>  <!-- Hamburger icon -->
            </label>

            <!-- Website logo with a link to the home page -->
            <div class="logo">
                <a href="home.php">Compute Companion</a>
            </div>

            <!-- Navigation links for the site -->
            <ul>
                <li><a href="aboutus.html">About Us</a></li>  <!-- Link to About Us page -->
                <li><a href="#">Messages</a></li>  <!-- Placeholder link for Messages (not yet implemented) -->
                <li class="dropdown"> <!-- Dropdown menu for account options -->
                    <a href="#">Account</a>  
                    <ul class="dropdown-content">
                        <li><a href="#">Profile</a></li>  <!-- Link to Profile page -->
                        <li><a href="#">Settings</a></li>  <!-- Link to Settings page -->
                        <li><a href="logout.php">Logout</a></li>  <!-- Link to logout page -->
                    </ul>
                </li>
            </ul>
        </nav>
        </body>
    </html>
    <?php
}
?>
