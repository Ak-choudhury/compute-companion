<?php
  // Include database connection
  include('connection.php');

  // Get the form inputs and sanitize them
  $username = $_POST['username'];
  $password = $_POST['password'];
  $username = strtolower($username);  // Convert the username to lowercase
  $password = strtolower($password);  // Convert the password to lowercase
  $cpassword = $_POST['cpassword'];  // Get confirm password from form
  $username = stripcslashes($username);  // Remove slashes from the username
  $username = mysqli_real_escape_string($con, $username);  // Escape special characters in the username
  $email = $_POST['email'];

  // Check if the username already exists in the database
  $sql ="select * from logins where Email = '$email'";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    // If username is found, set usernameused to true
    $usernameused = "true";
  } else {
    // If no matching username, set usernameused to false
    $usernameused = "false";
  }

  // Database connection for inserting the new user
  $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

  // Check if the passwords match
  if($password == $cpassword){
      // If passwords match, proceed
      if($conn->connect_error){
          // If there's a connection error, print it and exit
          echo "$conn->connect_error";
          die("Connection Failed : ". $conn->connect_error);
      } else if ($usernameused == "true") {
          // If username is already taken, set error message and redirect back to registration
          $reg = "email already in use";
          $lin = "registration.html";
      } else {
          // If the username is unique, proceed with registration
          if(isset($_POST["email"])){
              // Get and sanitize the email if provided
              $email = $_POST['email'];
              $email = stripslashes(htmlspecialchars($email));
          } else {
              // If no email is provided, set it to an empty string
              $email = "";
          }

          // Sanitize the inputs before insertion into the database
          $username = stripcslashes($username);  
          $password = stripcslashes($password);    
          $email = stripcslashes($email);  
          $username = mysqli_real_escape_string($con, $username);  
          $password = mysqli_real_escape_string($con, $password);
          $email = mysqli_real_escape_string($con, $email);

          // Prepare and execute the query to insert new user into the database
          $stmt = $conn->prepare("INSERT INTO logins (email, Password, Name) VALUES (?, ?, ?)");
          $stmt->bind_param("sss", $email, $password, $username);
          $stmt->execute();  // Execute the query
          $stmt->close();  // Close the statement
          $conn->close();  // Close the connection

          // Set success message and redirect to login page
          $reg = "Registration Successful";
          $lin = "index.html";
      }
  } else {
      // If passwords do not match, set error message and redirect to registration
      $reg = "Passwords do not match";
      $lin = "registration.html";
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Link to the external CSS stylesheet for styling -->
  <link rel="stylesheet" href="style.css">
  <!-- Title of the page -->
  <title>Compute companion - Registration</title>
  <!-- Favicon for the webpage -->
  <link rel="icon" type="image/png" href="favicon.png">
</head>
<body>
    <!-- Ionicons script for using icons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- External JavaScript file for functionality -->
    <script type="module" src="script.js"></script>
    
    <!-- Main section containing feedback message -->
    <section>
        <div class="form-box">
            <div class="form-value">
                <!-- Display registration result message (success or error) -->
                <h2><?php echo $reg?></h2>
                <div class="register">
                    <!-- Link to go back to the previous page (either registration or login) -->
                    <p>Undo? <a href="<?php echo $lin?>">Go Back</a></p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
