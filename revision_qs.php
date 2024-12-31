<?php
session_start(); // Start the session to track user status

// Check if session 'stat' exists and set it to a variable
if (isset($_SESSION['stat'])) {
    $stat = $_SESSION['stat']; // Assign session status to $stat
} else {
    $stat = "";  // If session does not exist, set stat to an empty string
}

// If the stat is not "su" (not logged in or authorized), display the error page
if ($stat != "su") {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <?php
    // Function to render the error page when user is not authorized
    function errPageAuth() {
        echo '
        <head>
            <link rel="stylesheet" href="style.css">
            <title>Compute companion - Error</title>
            <link rel="icon" type="image/png" href="favicon.png">
        </head>
        <body>
            <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
            <script type="module" src="script.js"></script>
            <section>
                <div class="form-box">
                    <div class="form-value">
                        <h2>Incorrect Username or Password</h2> <!-- Error message -->
                        <div class="register">
                            <!-- Logout form to redirect to login page -->
                            <form action="index.html" method="post">
                                <p><button type="submit" class="friend">Logout</button></p>
                                <input type="hidden" id="logout" name="logout" value="true"> <!-- Hidden logout input -->
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </body>';
    }

    // Call function to render the error page
    errPageAuth();
    ?>
    <script type="text/javascript">
        function formAutoSubmit() {
            var frm = document.getElementById("form"); // Get form element by ID
            frm.submit(); // Automatically submit the form (though this line is commented out)
        }
        // window.onload = formAutoSubmit; // This was commented out, but you can enable it to auto-submit on page load
    </script>
    </html>
    <?php
} else {
    // If the user is authorized (stat == "su"), display the main home page
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <link rel="stylesheet" href="style.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="navstyle.css">
        <title>Compute Companion - Revise</title> <!-- Page title -->
    </head>
    <body>
    <nav>
        <!-- Checkbox for toggling the navigation menu -->
        <input type="checkbox" id="check">

        <!-- Menu icon -->
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i> <!-- Hamburger icon -->
        </label>

        <!-- Site logo -->
        <div class="logo">
            <a href="home.php">Compute Companion</a>
        </div>

        <!-- Navigation links -->
        <ul>
            <li><a href="aboutus.html">About Us</a></li>
            <li><a href="#">Messages</a></li>
            <li class="dropdown">
                <a href="#">Account</a>
                <ul class="dropdown-content">
                    <li><a href="#">Profile</a></li>
                    <li><a href="#">Settings</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Main content of the page -->
    <h1>Hello</h1> <!-- A welcome header -->
    <h1>Your Generated Quiz</h1> <!-- Quiz title -->

    <!-- Quiz form that submits answers -->
    <form action="/result" method="post">
        <div>
            <!-- Display the questions dynamically here -->
            <p>{{ questions | safe }}</p>  <!-- Template variable for dynamic content -->
        </div>

        <!-- Submit button to submit the answers -->
        <button type="submit">Submit Answers</button>

        <!-- Hidden input for the correct answer hash -->
        <input type='hidden' id='answer' name='answer' value=""> <!-- Hidden answer value -->
        <input type='hidden' id='answer_hash' name='answer_hash' value="{{ answer_hash }}"> <!-- Hidden hash for verification -->
    </form>
    </body>
    </html>
    <?php
}
?>
