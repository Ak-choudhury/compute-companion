<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
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
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="navstyle.css">
        <title>compute companion-home</title>
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


        <div class="home_page">
            <div class="button-container">
                <a href="exam.php" class="hom-but">
                    <div class="button-content">
                        <div class="icon">
                            <img src="test.gif" alt="Icon 1" />
                        </div>
                        <div class="text">
                            <h3>Exam practice</h3>
                            <p>A place to give you timed exam practice with past and generated questions</p>
                        </div>
                    </div>
                </a>
                <a href="learn.php" class="hom-but">
                    <div class="button-content">
                        <div class="icon">
                            <img src="education_16675750.gif" alt="Icon 2" />
                        </div>
                        <div class="text">
                            <h3>Learn</h3>
                            <p>A place to gain the knowledge to reach the skies</p>
                        </div>
                    </div>
                </a>
                <a href="/question_generation/index.html" class="hom-but">
                    <div class="button-content">
                        <div class="icon">
                            <img src="revise.gif" alt="Icon 3" />
                        </div>
                        <div class="text">
                            <h3>Revision</h3>
                            <p>Test your knowledge, one topic at a time, to help strengthen your understanding</p>
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
