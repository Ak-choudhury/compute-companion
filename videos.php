<?php
session_start();  // Start the session to manage user login state

// Check if session stat exists and set it to a variable
if (isset($_SESSION['stat'])) {
    $stat = $_SESSION['stat'];  // If 'stat' exists in session, assign it to $stat
} else {
    $stat = "";  // If 'stat' doesn't exist, initialize $stat as an empty string
}

// If the stat is not "su" (not logged in or authorized), display the error page
if ($stat != "su") {  // Check if the session status is not equal to "su" (admin or authorized user)
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <?php
    // Define the error page when user is not authorized
    function errPageAuth() {
        echo '
        <head>
            <link rel="stylesheet" href="style.css">  <!-- Link to external stylesheet -->
            <title>Compute companion - Error</title>  <!-- Set page title -->
            <link rel="icon" type="image/png" href="favicon.png">  <!-- Link to the site favicon -->
        </head>
        <body>
            <!-- Include external scripts for icons -->
            <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
            <script type="module" src="script.js"></script>  <!-- Link to custom script -->
            
            <!-- Form box for the error message -->
            <section>
                <div class="form-box">
                    <div class="form-value">
                        <h2>Incorrect Username or Password</h2>  <!-- Error message for incorrect login -->
                        <div class="register">
                            <form action="index.html" method="post">  <!-- Form to logout and redirect to login page -->
                                <p><button type="submit" class="friend">Logout</button></p>  <!-- Logout button -->
                                <input type="hidden" id="logout" name="logout" value="true">  <!-- Hidden input to indicate logout -->
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </body>';
    }

    // Call the function to display the error page
    errPageAuth();
    ?>
    <script type="text/javascript">
        // JavaScript function to auto-submit a form (though it's not in use here)
        function formAutoSubmit() {
            var frm = document.getElementById("form");
            frm.submit();  // Submit the form automatically (this is commented out in the code)
        }
        // window.onload = formAutoSubmit;  // This was commented out (if you want auto-submit to trigger on page load)
    </script>
    </html>
    <?php
} else {
    // If the user is authorized (stat == "su"), display the main home page
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <link rel="stylesheet" href="style.css">  <!-- Link to external stylesheet -->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>  <!-- Link to Boxicons for icons -->
        <link rel="stylesheet" href="navstyle.css">  <!-- Link to external CSS for navigation -->
        <title>compute companion-learn</title>  <!-- Set the page title -->
    </head>
    <body>
        <nav>
            <!-- Checkbox for toggling menu visibility on mobile -->
            <input type="checkbox" id="check">

            <!-- Menu icon that activates the checkbox to toggle menu visibility -->
            <label for="check" class="checkbtn">
                <i class="fas fa-bars"></i>  <!-- Icon for the menu (hamburger icon) -->
            </label>

            <!-- Site logo that links to the homepage -->
            <div class="logo">
                <a href="home.php">Compute Companion</a>
            </div>

            <!-- Navigation links (About Us, Messages, Account) -->
            <ul>
                <li><a href="aboutus.html">About Us</a></li>  <!-- Link to About Us page -->
                <li><a href="#">Messages</a></li>  <!-- Placeholder for Messages page -->
                <li class="dropdown">  <!-- Dropdown menu for account-related options -->
                    <a href="#">Account</a>
                    <ul class="dropdown-content">
                        <li><a href="#">Profile</a></li>  <!-- Link to Profile page -->
                        <li><a href="#">Settings</a></li>  <!-- Link to Settings page -->
                        <li><a href="logout.php">Logout</a></li>  <!-- Link to logout -->
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- The body of the page, this section could be for displaying further content (like quizzes or user dashboard) -->
    </body>
    </html>
    <?php
}
?>
