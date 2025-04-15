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
       <!--
       <style>
            body {
            font-family: Arial, sans-serif;
            background: url('home_background.png')no-repeat;
            background-position: center;
            background-size: cover;
            margin: 0;
            text-align: center;
            }

            h1 {
            color: #333;
            }

            h2 {
            margin-top: 10px;
            color: #555;
            }

            .video-header {
            font-size: 24px;
            color:rgb(84, 87, 88);
            margin-bottom: 10px;
            }

            .video-container {
            width: 80%;
            max-width: 720px;
            margin: 20px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            overflow: hidden;
            background-color: white;
            height: 405px;
            }

            iframe {
            width: 100%;
            height: 100%;
            border: none;
            display: none; /* Hidden initially */
            }

            .placeholder {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            font-size: 18px;
            color: #666;
            font-style: italic;
            }

            .button-container {
            margin: 10px auto; /* Closer to the video container */
            display: flex;
            justify-content: center;
            gap: 5px;
            }

            button {
            padding: 10px 20px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color:rgb(68, 65, 65); /* Grey color */
            color: white;
            transition: background-color 0.3s;
            }

            button:hover {
            background-color: #505050;
            }

            .collapsible {
            width: 80%;
            max-width: 720px;
            margin: 20px auto;
            text-align: left;
            }

            .collapsible button {
            width: 100%;
            text-align: left;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            background-color:rgb(56, 58, 59);
            color: white;
            border: none;
            border-radius: 5px;
            margin-bottom: 5px;
            }

            .collapsible-content {
            display: none;
            margin-top: 5px;
            padding-left: 15px;
            }

            .collapsible-content button {
            width: auto;
            text-align: left;
            font-size: 14px;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
            }
        </style>
         -->
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
          <!-- Video container -->
            <h1>Topic videos</h1>
            <h2 class="video-header" id="video-title">No video selected</h2>

            <!-- Video container -->
            <div class="video-container">
                <iframe 
                id="youtube-video" 
                title="YouTube video player" 
                allow="accelerometer;clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>
                </iframe>
                <div id="placeholder" class="placeholder">No video loaded. Please select a video.</div>
            </div>

            <!-- Collapsible video lists -->
            <div class="collapsible">
                <button onclick="toggleCollapse('Characteristics of Contemporary Processors')"> 1.1 Characteristics of Contemporary Processors</button>
                <div id="Characteristics of Contemporary Processors" class="collapsible-content">
                <button onclick="changeVideo(' ALU, CU, registers and buses', 'https://www.youtube.com/embed/dVi2B7fGVm4')"> ALU, CU, registers and buses</button>
                <button onclick="changeVideo('Fetch, decode, execute cycle', 'https://www.youtube.com/embed/Y4O2-ilSw-o')">Fetch, decode, execute cycle</button>
                <button onclick="changeVideo('Performance of the CPU', 'https://www.youtube.com/embed/QtQBi-SOLkE')">Performance of the CPU</button>
                <button onclick="changeVideo('Pipelining', 'https://www.youtube.com/embed/Pk8gpJEWFRc')">Pipelining</button>
                <button onclick="changeVideo('Von Neumann and Harvard', 'https://www.youtube.com/embed/gVOtmMS17tI')">Von Neumann and Harvard</button>
                <button onclick="changeVideo('CISC vs RISC', 'https://www.youtube.com/embed/PaeXsm5HGJs)')">CISC vs RISC</button>
                <button onclick="changeVideo('GPUs and their uses', 'https://www.youtube.com/embed/-YIHL2int3k')">GPUs and their uses</button>
                <button onclick="changeVideo('Multi-core & parallel systems', 'https://www.youtube.com/embed/stQ4mLrQPMw')">Multi-core & parallel systems</button>
                <button onclick="changeVideo('Input, output and storage devices', 'https://www.youtube.com/embed/NFbHACNJp6o')">Input, output and storage devices</button>
                <button onclick="changeVideo('Magnetic, flash and optical storage', 'https://www.youtube.com/embed/zzyCGHfuqe8')">Magnetic, flash and optical storage</button>
                <button onclick="changeVideo('RAM and ROM', 'https://www.youtube.com/embed/yhDmlhc_2_M')">RAM and ROM</button>
                <button onclick="changeVideo('Virtual storage', 'https://www.youtube.com/embed/fmWr7gTxErA')">Virtual storage</button>

                </div>

                <button onclick="toggleCollapse('Software and Software Development')"> 1.2 Software and Software Development</button>
                <div id="Software and Software Development" class="collapsible-content">
                <button onclick="changeVideo('Need for operating systems', 'https://www.youtube.com/embed/8aFBYlR_CYw')">Need for operating systems</button>
                <button onclick="changeVideo('Interrupts', 'https://www.youtube.com/embed/iKlAWIKEyuw')">Interrupts</button>
                <button onclick="changeVideo('Paging, segmentation and virtual memory', 'https://www.youtube.com/embed/O4nwUqQodAg')">Paging, segmentation and virtual memory</button>
                <button onclick="changeVideo('Scheduling', 'https://www.youtube.com/embed/xDLMQ1ZAz3g')">Scheduling</button>
                <button onclick="changeVideo('Types of operating system', 'https://www.youtube.com/embed/YjwXNUpsByE')">Types of operating system</button>
                <button onclick="changeVideo('BIOS', 'https://www.youtube.com/embed/xpqtruZAE_0')">BIOS</button>
                <button onclick="changeVideo('Device drivers', 'https://www.youtube.com/embed/26vjzQEtwkk')">Device drivers</button>
                <button onclick="changeVideo('Virtual machines', 'https://www.youtube.com/embed/Jesf4WJJ30w')">Virtual machines</button>
                <button onclick="changeVideo('The nature of applications', 'https://www.youtube.com/embed/cKAlc3X9Tj8')">The nature of applications</button>
                <button onclick="changeVideo('Utilities', 'https://www.youtube.com/embed/AG6Sux3zvpM')">Utilities</button>
                <button onclick="changeVideo('Open vs closed', 'https://www.youtube.com/embed/BpPXFEWyFho')">Open vs closed</button>
                <button onclick="changeVideo('Translators', 'https://www.youtube.com/embed/GAHQ0bdrYTY')">Translators</button>
                <button onclick="changeVideo('Stages of compilation', 'https://www.youtube.com/embed/CTUDhrsy6f0')">Stages of compilation</button>
                <button onclick="changeVideo('Linkers, loaders and libraries', 'https://www.youtube.com/embed/8MW1naDeIDU')">Linkers, loaders and libraries</button>
                <button onclick="toggleCollapse('Development methodologies')">Development methodologies</button>
                <div id="Development methodologies" class="collapsible-content">
                    <button onclick="changeVideo('Development methodologies part 1', 'https://www.youtube.com/embed/qEmrXu8d1ys')">Development methodologies part 1</button>
                    <button onclick="changeVideo('Development methodologies part 2', 'https://www.youtube.com/embed/f_-KHPB817o')">Development methodologies part 2</button>
                </div>
                <button onclick="changeVideo('Writing & following algorithms', 'https://www.youtube.com/embed/yWWOZb5wbw8')">Writing & following algorithms</button>
                <button onclick="changeVideo('Programming paradigms', 'https://www.youtube.com/embed/Wt4FPjkCNaU')">Programming paradigms</button>
                <button onclick="changeVideo('Procedural languages', 'https://www.youtube.com/embed/we8Iz2_S8X0')">Procedural languages</button>
                <button onclick="changeVideo('Assembly language and LMC language', 'https://www.youtube.com/embed/nAbLDiytl2M')">Assembly language and LMC language</button>
                <button onclick="changeVideo('Addressing memory', 'https://www.youtube.com/embed/p3RzuDeT6IM')">Addressing memory</button>
                <button onclick="toggleCollapse('Object-oriented languages')">Object-oriented languages</button>
                <div id="Object-oriented languages" class="collapsible-content">
                    <button onclick="changeVideo('Object-oriented languages part 1', 'https://www.youtube.com/embed/9u2XQ1G5DVY')">Object-oriented languages part 1</button>
                    <button onclick="changeVideo('Object-oriented languages part 2', 'https://www.youtube.com/embed/HmVLvdgbVGE')">Object-oriented languages part 2</button>
                    <button onclick="changeVideo('Object-oriented languages part 3', 'https://www.youtube.com/embed/K9XaTFlb5Gw')">Object-oriented languages part 3</button>
                    <button onclick="changeVideo('Object-oriented languages part 4', 'https://www.youtube.com/embed/BhNifklf6a0')">Object-oriented languages part 4</button>
                </div>
                <button onclick="toggleCollapse('Introduction to programming')">Introduction to programming</button>
                <div id="Introduction to programming" class="collapsible-content">
                    <button onclick="changeVideo('Introduction to programming part 1 program flow', 'https://www.youtube.com/embed/RHdFfPSHkjw')">Introduction to programming part 1 program flow</button>
                    <button onclick="changeVideo('Introduction to programming part 2 variables & constants', 'https://www.youtube.com/embed/yoaCDZjsWwM')">Introduction to programming part 2 variables & constants</button>
                    <button onclick="changeVideo('Introduction to programming part 3 procedures & functions Title', 'https://www.youtube.com/embed/9LuEpDU_k_o')">Introduction to programming part 3 procedures & functions</button>
                    <button onclick="changeVideo('Introduction to programming part 4 mathematical operators', 'https://www.youtube.com/embed/to3H80wo9Ao')">Introduction to programming part 4 mathematical operators</button>
                    <button onclick="changeVideo('Introduction to programming part 5 string handling', 'https://www.youtube.com/embed/wgjRkQrAaxo')">Introduction to programming part 5 string handling</button>
                    <button onclick="changeVideo('Introduction to programming part 6 file handling', 'https://www.youtube.com/embed/6VADtK8X5UQ')">Introduction to programming part 6 file handling</button>
                </div>
                
                </div>

                <button onclick="toggleCollapse('Exchanging Data')"> 1.3 Exchanging Data</button>
                <div id="Exchanging Data" class="collapsible-content">
                <button onclick="changeVideo('Lossy vs lossless', 'https://www.youtube.com/embed/xMQlMdXlu-A')">Lossy vs lossless</button>
                <button onclick="changeVideo('Run length & dictionary coding', 'https://www.youtube.com/embed/3gHmQW9rgoI')">Run length & dictionary coding</button>
                <button onclick="changeVideo('Symmetric & asymmetric encryption', 'https://www.youtube.com/embed/UYqMu0PqeCE')">Symmetric & asymmetric encryption</button>
                <button onclick="changeVideo('Hashing', 'https://www.youtube.com/embed/xeVTtP5fTlY')">Hashing</button>
                <button onclick="changeVideo('Introduction to database concepts', 'https://www.youtube.com/embed/PZVIV8wC4gM')">Introduction to database concepts</button>
                <button onclick="changeVideo('Methods of capturing data', 'https://www.youtube.com/embed/V41rwfi-VhA')">Methods of capturing data</button>
                <button onclick="changeVideo('Normalisation to 3NF', 'https://www.youtube.com/embed/UY3zc9G_YZo')">Normalisation to 3NF</button>
                <button onclick="changeVideo('Normalisation to 3NF revisited', 'https://www.youtube.com/embed/RdVQeHNtnZs')">Normalisation to 3NF revisited</button>
                <button onclick="changeVideo('SQL', 'https://www.youtube.com/embed/iujWEQlHI_I')">SQL</button>
                <button onclick="changeVideo('Referential integrity', 'https://www.youtube.com/embed/oAc6_3CpeRo')">Referential integrity</button>
                <button onclick="changeVideo('Transaction processing', 'https://www.youtube.com/embed/lhSVTsRLEDM')">Transaction processing</button>
                <button onclick="changeVideo('Network characteristics & protocols', 'https://www.youtube.com/embed/Ix_uKqI0sxk')">Network characteristics & protocols</button>
                <button onclick="changeVideo('TCP IP, DNS & protocol layers', 'https://www.youtube.com/embed/H5jGQingnWI')">TCP IP, DNS & protocol layers</button>
                <button onclick="changeVideo('LANs & WANs', 'https://www.youtube.com/embed/_gr_DMoROY8')">LANs & WANs</button>
                <button onclick="changeVideo('Packet & circuit switching', 'https://www.youtube.com/embed/tcqjISYlr8w')">Packet & circuit switching</button>
                <button onclick="changeVideo('Network security threats', 'https://www.youtube.com/embed/wZFs9tVKlUs')">Network security threats</button>
                <button onclick="changeVideo('Network hardware', 'https://www.youtube.com/embed/niZyF7Zw4rg')">Network hardware</button>
                <button onclick="changeVideo('Client server & peer to peer', 'https://www.youtube.com/embed/ViiflbmWoIo')">Client server & peer to peer</button>
                <button onclick="changeVideo('HTML', 'https://www.youtube.com/embed/m4uJ9rJG92g')">HTML</button>
                <button onclick="changeVideo('CSS', 'https://www.youtube.com/embed/4WgaMcW1IFY')">CSS</button>
                <button onclick="changeVideo('JavaScript', 'https://www.youtube.com/embed/U3YfLC7O4K8')">JavaScript</button>
                <button onclick="changeVideo('Search engine indexing', 'https://www.youtube.com/embed/aVctEi8b19Q')">Search engine indexing</button>
                <button onclick="changeVideo('PageRank algorithm', 'https://www.youtube.com/embed/O3YmHcvSb60')">PageRank algorithm</button>
                <button onclick="changeVideo('PageRank algorithm revisited', 'https://www.youtube.com/embed/ffnVxn1MFj0')">PageRank algorithm revisited</button>
                <button onclick="changeVideo('Server and client side processing', 'https://www.youtube.com/embed/S_Ti1VUX6x8)')">Server and client side processing</button>
                <button onclick="changeVideo('Lossy vs lossless', 'https://www.youtube.com/embed/S09mPoDZKrU')">Lossy vs lossless</button>
                </div>

                <button onclick="toggleCollapse('Data Types, Data Structures and Algorithms')"> 1.4 Data Types, Data Structures and Algorithms</button>
                <div id="Data Types, Data Structures and Algorithms" class="collapsible-content">
                <button onclick="changeVideo('Primitive data types', 'https://www.youtube.com/embed/A_R49e7su28')">Primitive data types</button>
                <button onclick="changeVideo('Binary positive integers', 'https://www.youtube.com/embed/y8mo6u7kF9E')">Binary positive integers</button>
                <button onclick="changeVideo('Sign and magnitude', 'https://www.youtube.com/embed/hJe5xqjiAFA)')">Sign and magnitude</button>
                <button onclick="changeVideo(Two's complement', 'https://www.youtube.com/embed/LS8ZANp1Yp8')">Two's complement</button>
                <button onclick="changeVideo('Binary addition and subtraction', 'https://www.youtube.com/embed/Lpx0R-G7p2w')">Binary addition and subtraction</button>
                <button onclick="changeVideo('Hexadecimal representation', 'https://www.youtube.com/embed/qq48hNOZBzk')">Hexadecimal representation</button>
                <button onclick="changeVideo('Converting between binary, hex & denary', 'https://www.youtube.com/embed/sGs6sz5YR4M')">Converting between binary, hex & denary</button>
                <button onclick="toggleCollapse('Floating point binary')">Floating point binary</button>
                <div id="Floating point binary" class="collapsible-content">
                    <button onclick="changeVideo('Floating point binary part 1 - Overview', 'https://www.youtube.com/embed/mGfOJQgdI_U')">Floating point binary part 1 - Overview</button>
                    <button onclick="changeVideo('Floating point binary part 2 - Normalisation', 'https://www.youtube.com/embed/IGQ9YOnhWxA')">Floating point binary part 2 - Normalisation</button>
                    <button onclick="changeVideo('Floating point binary part 3 - Recap and further examples', 'https://www.youtube.com/embed/tRNTiEuXaMs')">Floating point binary part 3 - Recap and further examples</button>
                </div>
                <button onclick="changeVideo('Floating point arithmetic', 'https://www.youtube.com/embed/AcePXaxDkS8')">Floating point arithmetic</button>
                <button onclick="changeVideo('Bitwise manipulation and masks', 'https://www.youtube.com/embed/qgCEjwDt3gQ')">Bitwise manipulation and masks</button>
                <button onclick="changeVideo('Character sets', 'https://www.youtube.com/embed/YPD_Y3f5A-s')">Character sets</button>
                <button onclick="changeVideo('Arrays, records, lists & tuples', 'https://www.youtube.com/embed/e3crB2Yi4ps')">Arrays, records, lists & tuples</button>
                <button onclick="changeVideo('Tuples, static or dynamic', 'https://www.youtube.com/embed/NT-3D-ozmOg')">Tuples, static or dynamic</button>
                <button onclick="toggleCollapse('Data structures')">Data structures</button>
                <div id="Data structures" class="collapsible-content">
                    <button onclick="changeVideo('Data structures part 1 - Linked lists', 'https://www.youtube.com/embed/sdO9cPdgVAk')">Data structures part 1 - Linked lists</button>
                    <button onclick="changeVideo('Data structures part 2 - Graphs', 'https://www.youtube.com/embed/rPu8em_PX4o')">Data structures part 2 - Graphs</button>
                    <button onclick="changeVideo('Data structures part 3 - Stacks & queues', 'https://www.youtube.com/embed/_7_jYMk_R9k')">Data structures part 3 - Stacks & queues</button>
                    <button onclick="changeVideo('Data structures part 4 - Trees', 'https://www.youtube.com/embed/0amXaMnTlhI')">Data structures part 4 - Trees</button>
                    <button onclick="changeVideo('Data structures part 5 - Hash tables', 'https://www.youtube.com/embed/0Wr6C81L8Mg')">Data structures part 5 - Hash tables</button>
                </div>
                <button onclick="toggleCollapse('Data structures')">Data structures operations</button>
                <div id="Data structures" class="collapsible-content">
                    <button onclick="changeVideo('Data structures part 1 - Linked lists (operations)', 'https://www.youtube.com/embed/RJMfJJVed2s')">Data structures part 1 - Linked lists (operations)</button>
                    <button onclick="changeVideo('Data structures part 2 - Graphs (operations)', 'https://www.youtube.com/embed/Oakq0rr9sf8')">Data structures part 2 - Graphs (operations)</button>
                    <button onclick="changeVideo('Data structures part 3 - Stacks & queues (operations)', 'https://www.youtube.com/embed/0LepNscvzIY')">Data structures part 3 - Stacks & queues (operations)</button>
                    <button onclick="changeVideo('Data structures part 4 - Trees (operations)', 'https://www.youtube.com/embed/aUSMk-aolQ0')">Data structures part 4 - Trees (operations)</button>
                    <button onclick="changeVideo('Data structures part 5 - Hash tables (operations)', 'https://www.youtube.com/embed/kNesrwdlG6A')">Data structures part 5 - Hash tables (operations)</button>
                </div>
                <button onclick="changeVideo('Define problems using Boolean logic', 'https://www.youtube.com/embed/iPEVk0WrV_A')">Define problems using Boolean logic</button>
                <button onclick="toggleCollapse('Karnaugh maps')">Karnaugh maps</button>
                <div id="Karnaugh maps" class="collapsible-content">
                    <button onclick="changeVideo('Karnaugh maps part 1', 'https://www.youtube.com/embed/gT9LdBr5DbU')">Karnaugh maps part 1</button>
                    <button onclick="changeVideo(Karnaugh maps part 2', 'https://www.youtube.com/embed/D_eHFX0Hz0g')">Karnaugh maps part 2</button>
                    <button onclick="changeVideo('Karnaugh maps part 3', 'https://www.youtube.com/embed/Es7kiAydcAM')">Karnaugh maps part 3</button>
                    <button onclick="changeVideo('Karnaugh maps part 4', 'https://www.youtube.com/embed/4q6Zwf4tK34')">Karnaugh maps part 4</button>
                </div>
                <button onclick="changeVideo('Logic gates & truth tables', 'https://www.youtube.com/embed/o3mopT63weU')">Logic gates & truth tables</button>
                <button onclick="changeVideo('Simplifying Boolean algebra', 'https://www.youtube.com/embed/43MVorZRtE0')">Simplifying Boolean algebra</button>
                <button onclick="changeVideo('Simplifying Boolean algebra revisited', 'https://www.youtube.com/embed/b0i45HRXMds')">Simplifying Boolean algebra revisited</button>
                <button onclick="changeVideo('Half & full adders', 'https://www.youtube.com/embed/X4mzhHX8IwI')">Half & full adders</button>
                <button onclick="changeVideo('D-type flip flops', 'https://www.youtube.com/embed/s42EdtPOfi8')">D-type flip flops</button>


                </div>

                <button onclick="toggleCollapse('Legal, Moral, Cultural and Ethical Issues')"> 1.5 Legal, Moral, Cultural and Ethical Issues</button>
                <div id="Legal, Moral, Cultural and Ethical Issues" class="collapsible-content">
                <button onclick="changeVideo('Data Protection Act', 'https://www.youtube.com/embed/I4nPDj2k55c')">Data Protection Act</button>
                <button onclick="changeVideo('Computer Misuse Act', 'https://www.youtube.com/embed/VlFwl9iIasI')">Computer Misuse Act</button>
                <button onclick="changeVideo('Copyright Design & Patents Act', 'https://www.youtube.com/embed/qY7itrfKBSo')">Copyright Design & Patents Act</button>
                <button onclick="changeVideo('Investigatory Powers Act', 'https://www.youtube.com/embed/iQhswDsXDXA')">Investigatory Powers Act</button>
                <button onclick="toggleCollapse('Moral, social & ethical issues')">Moral, social & ethical issues</button>
                <div id="Moral, social & ethical issues" class="collapsible-content">
                    <button onclick="changeVideo('Moral, social & ethical issues part 1', 'https://www.youtube.com/embed/4h5zlBOgZz0')">Moral, social & ethical issues part 1</button>
                    <button onclick="changeVideo('Moral, social & ethical issues part 2', 'https://www.youtube.com/embed/LAYb_O67G_s')">Moral, social & ethical issues part 2</button>
                    <button onclick="changeVideo('Moral, social & ethical issues part 3', 'https://www.youtube.com/embed/qdHtUJY6YA8')">Moral, social & ethical issues part 3</button>
                    <button onclick="changeVideo('Moral, social & ethical issues part 4', 'https://www.youtube.com/embed/D2C59AnQXsI')">Moral, social & ethical issues part 4</button>
                    <button onclick="changeVideo('Moral, social & ethical issues part 5', 'https://www.youtube.com/embed/SQRMGRa8Zuw')">Moral, social & ethical issues part 5</button>
                </div>
                </div>

                <button onclick="toggleCollapse('Elements of Computational Thinking')"> 2.1 Elements of Computational Thinking</button>
                <div id="Elements of Computational Thinking" class="collapsible-content">
                <button onclick="changeVideo('The nature of abstraction', 'https://www.youtube.com/embed/QljjmB72LnI')">The nature of abstraction</button>
                <button onclick="changeVideo('The need for abstraction', 'https://www.youtube.com/embed/2N2NcwaHhb4')">The need for abstraction</button>
                <button onclick="changeVideo('Abstraction & reality', 'https://www.youtube.com/embed/pJz5ifCi7cI')">Abstraction & reality</button>
                <button onclick="changeVideo('Devise an abstract model', 'https://www.youtube.com/embed/ZPzSgWbdg3k')">Devise an abstract model</button>
                <button onclick="changeVideo('Identify inputs & outputs', 'https://www.youtube.com/embed/6HsUQbPDxv4')">Identify inputs & outputs</button>
                <button onclick="changeVideo('Determining preconditions', 'https://www.youtube.com/embed/gPTNXsL-lcA')">Determining preconditions</button>
                <button onclick="changeVideo('Caching', 'https://www.youtube.com/embed/gPTNXsL-lcA')">Caching</button>
                <button onclick="changeVideo('Reusable components', 'https://www.youtube.com/embed/92GtfIxxm3Q')">Reusable components</button>
                <button onclick="changeVideo('Identify components of a problem', 'https://www.youtube.com/embed/-JcrMQpNeOo')">Identify components of a problem</button>
                <button onclick="changeVideo('Identify components of a solution', 'https://www.youtube.com/embed/Lb9YTn1JAcc')">Identify components of a solution</button>
                <button onclick="changeVideo('Steps to solve a problem', 'https://www.youtube.com/embed/lMbaCfxWOW0')">Steps to solve a problem</button>
                <button onclick="changeVideo('Identify sub procedures', 'https://www.youtube.com/embed/EPcxire_d8Q')">Identify sub procedures</button>
                <button onclick="changeVideo('Decision points in a solution', 'https://www.youtube.com/embed/itNcYo-gVWU')">Decision points in a solution</button>
                <button onclick="changeVideo('Determine logical conditions', 'https://www.youtube.com/embed/u8S2mA-1tEg')">Determine logical conditions</button>
                <button onclick="changeVideo('Decisions & program flow', 'https://www.youtube.com/embed/HpFoodysc_o')">Decisions & program flow</button>
                <button onclick="changeVideo('Tackling concurrent problems', 'https://www.youtube.com/embed/lpM2MMfKmFU')">Tackling concurrent problems</button>
                <button onclick="changeVideo('Benefits & trade offs of concurrent processing', 'https://www.youtube.com/embed/NI5uys3UY5w')">Benefits & trade offs of concurrent processing</button>
                </div>

                <button onclick="toggleCollapse('Problem Solving and Programming')"> 2.2 Problem Solving and Programming</button>
                <div id="Problem Solving and Programming" class="collapsible-content">
                <button onclick="changeVideo('Programming constructs', 'https://www.youtube.com/embed/9hxCspfuviE')">Programming constructs</button>
                <button onclick="changeVideo('Recursion', 'https://www.youtube.com/embed/N61yojktcH8')">Recursion</button>
                <button onclick="changeVideo('Global & local variables', 'https://www.youtube.com/embed/E5US2n_EWcI')">Global & local variables</button>
                <button onclick="changeVideo('Functions & procedures', 'https://www.youtube.com/embed/qsn5SZRjd_4')">Functions & procedures</button>
                <button onclick="changeVideo('Integrated development environments', 'https://www.youtube.com/embed/O_GiVzDS2k0')">Integrated development environments</button>
                <button onclick="changeVideo('Object orientated techniques', 'https://www.youtube.com/embed/GX6HJ_115w0')">Object orientated techniques</button>
                <button onclick="changeVideo('Features of a problem', 'https://www.youtube.com/embed/r2c_SfdEQ84')">Features of a problem</button>
                <button onclick="changeVideo('Problem recognition', 'https://www.youtube.com/embed/2zNqU7bC3V8')">Problem recognition</button>
                <button onclick="changeVideo('Problem decomposition', 'https://www.youtube.com/embed/RUusIWfNCak')">Problem decomposition</button>
                <button onclick="changeVideo('Divide & conquer', 'https://www.youtube.com/embed/CPrG77GOXAM')">Divide & conquer</button>
                <button onclick="changeVideo('Use of abstraction', 'https://www.youtube.com/embed/xNHqa5oGCnM')">Use of abstraction</button>
                <button onclick="changeVideo('Backtracking, data mining & heuristics', 'https://www.youtube.com/embed/VgQGPn-2dG8')">Backtracking, data mining & heuristics</button>
                <button onclick="changeVideo('Performance modelling, pipelining & visualisation', 'https://www.youtube.com/embed/37P9f3QTP58')">Performance modelling, pipelining & visualisation</button>
                <button onclick="changeVideo('Test strategies', 'https://www.youtube.com/embed/fpGUQJN1TJI')">Test strategies</button>
                <button onclick="changeVideo('Test data & user feedback', 'https://www.youtube.com/embed/Wx45BYhGNNM')">Test data & user feedback</button>
                </div>

                <button onclick="toggleCollapse('Algorithms')"> 2.3 Algorithms</button>
                <div id="Algorithms" class="collapsible-content">
                <button onclick="changeVideo('Analysis &design of algorithms', 'https://www.youtube.com/embed/gqvf-KyQCuk')">Analysis &design of algorithms</button>
                <button onclick="changeVideo('Standard algorithms', 'https://www.youtube.com/embed/adXe5wFaq3I')">Standard algorithms</button>
                <button onclick="changeVideo('Algorithms for the main data structures', 'https://www.youtube.com/embed/Z3Z5KCyArKQ')">Algorithms for the main data structures</button>
                <button onclick="changeVideo('Implement linear search', 'https://www.youtube.com/embed/BdjaHVIvJGs')">Implement linear search</button>
                <button onclick="changeVideo('Implement binary search', 'https://www.youtube.com/embed/eme0m1ABz5M')">Implement binary search</button>
                <button onclick="changeVideo('Implement bubble sort', 'https://www.youtube.com/embed/ih-gRQYc_84')">Implement bubble sort</button>
                <button onclick="changeVideo('Implement insertion sort', 'https://www.youtube.com/embed/SpnnvFhSD8w')">Implement insertion sort</button>
                <button onclick="changeVideo('Representing, adding & removing from queues & stacks', 'https://www.youtube.com/embed/fB9cKSXoR0Y')">Representing, adding & removing from queues & stacks</button>
                <button onclick="changeVideo('Comparing suitability of algorithms', 'https://www.youtube.com/embed/YccgdNJpjN4')">Comparing suitability of algorithms</button>
                <button onclick="changeVideo('Implement merge sort', 'https://www.youtube.com/embed/EbpMZIVqCl4')">Implement merge sort</button>
                <button onclick="changeVideo('Implement quick sort', 'https://www.youtube.com/embed/hXDG9OdA9LY')">Implement quick sort</button>
                <button onclick="changeVideo('Dijkstra's shortest path', 'https://www.youtube.com/embed/YHDmA7ZlwqU')">Dijkstra's shortest path</button>
                <button onclick="changeVideo('A star pathfinding', 'https://www.youtube.com/embed/z0T1Kl5yBV4')">A star pathfinding</button>
                <button onclick="changeVideo('A star pathfinding revisited', 'https://www.youtube.com/embed/dOF3Yd6A-4M')">A star pathfinding revisited</button>
                <button onclick="changeVideo('Measures and methods to determine efficiency of algorithms', 'https://www.youtube.com/embed/A8aUjcULkLI')">Measures and methods to determine efficiency of algorithms</button>
                <button onclick="changeVideo('Comparison of the complexity of algorithms', 'https://www.youtube.com/embed/dU37Dtzb6Ig')">Comparison of the complexity of algorithms</button>
                <button onclick="changeVideo('Big O notation in practice', 'https://www.youtube.com/embed/IILaLg98xW0')">Big O notation in practice</button>
                </div>
            </div>

            <!-- JavaScript -->
            <script>
                function changeVideo(title, newUrl) {
                const iframe = document.getElementById('youtube-video');
                const placeholder = document.getElementById('placeholder');
                const videoTitle = document.getElementById('video-title');

                // Set the iframe src to the new URL and show the iframe
                iframe.src = newUrl;
                iframe.style.display = "block";

                // Update the video title
                videoTitle.textContent = title;

                // Hide the placeholder
                placeholder.style.display = "none";
                }

                function toggleCollapse(id) {
                const content = document.getElementById(id);
                if (content.style.display === "block") {
                    content.style.display = "none";
                } else {
                    content.style.display = "block";
                }
                }
            </script>
    </body>
    </html>
    <?php
}
?>
