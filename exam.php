<?php
session_start();

// Check if session stat exists and set it to a variable
if (isset($_SESSION['stat'])) {
    $stat = $_SESSION['stat'];
} else {
    $stat = "";
}

// If the stat is not "su" (not logged in or authorized), display the error page
if ($stat != "su") {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <?php
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
                        <h2>Incorrect Username or Password</h2>
                        <div class="register">
                            <form action="index.html" method="post">
                                <p><button type="submit" class="friend">Logout</button></p>
                                <input type="hidden" id="logout" name="logout" value="true">
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </body>';
    }

    errPageAuth();
    ?>
    <script type="text/javascript">
        function formAutoSubmit() {
            var frm = document.getElementById("form");
            frm.submit();
        }
        // window.onload = formAutoSubmit; // This was commented out
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
        <title>compute companion-exam</title>
    </head>
    <body>
        <nav>
            <!-- Checkbox for toggling menu -->
            <input type="checkbox" id="check">

            <!-- Menu icon -->
            <label for="check" class="checkbtn">
                <i class="fas fa-bars"></i>
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
        <div class="exam21">
            <div class="button-container">
                <a href="#" class="hom-but">
                    <div class="button-content">
                        <div class="icon">
                            <img src="past_paper.gif" alt="Icon 1" />
                        </div>
                        <div class="text">
                            <h3>past papers</h3>
                            <p></p>
                        </div>
                    </div>
                </a>
                <a href="#" class="hom-but">
                    <div class="button-content">
                        <div class="icon">
                            <img src="ai.gif" alt="Icon 2" />
                        </div>
                        <div class="text">
                            <h3>ai generated papers</h3>
                            <p></p>
                        </div>
                    </div>
                </a>
            </div>
        </div>


    </body>
    </html>
    <?php
}
?>