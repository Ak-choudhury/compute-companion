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
        <title>compute companion-home</title>
    </head>
    <body>
        <div class="home_page">
            <div class="button-container">
                <a href="page1.html" class="hom-but">
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
                <a href="page2.html" class="hom-but">
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
                <a href="page3.html" class="hom-but">
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
