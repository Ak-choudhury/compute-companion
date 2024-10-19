<?php

  include('connection.php');
	$username = $_POST['username'];
	$password = $_POST['password'];
  $username = strtolower($username);
  $password = strtolower($password);
  $cpassword = $_POST['cpassword'];
  $username = stripcslashes($username);    
  $username = mysqli_real_escape_string($con, $username);  
  $sql ="select *from logins where Name = '$username'";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    $usernameused = "true";
  } else {
    $usernameused = "false";
  }


	// Database connection
	$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

  if($password == $cpassword){
    
     
      if($conn->connect_error){
      		echo "$conn->connect_error";
      		die("Connection Failed : ". $conn->connect_error);
    	} else if ($usernameused == "true") {
        $reg = "Username already in use";
        $lin = "registration.html";
      } else {
          if(isset($_POST["email"])){
            $email = $_POST['email'];
            $email = stripslashes(htmlspecialchars($email));
          } else {
            $email = "";
          }
          $username = stripcslashes($username);  
          $password = stripcslashes($password);    
          $email = stripcslashes($email);  
          $username = mysqli_real_escape_string($con, $username);  
          $password = mysqli_real_escape_string($con, $password);
          $email = mysqli_real_escape_string($con, $email);
      		$stmt = $conn->prepare("insert into logins(email, Password, Name) values(?, ?, ?)");
      		$stmt->bind_param("sss", $email, $password, $username );
      		$stmt->execute();
      		$stmt->close();
      		$conn->close();
        
          $reg = "Registration Successful";
          $lin = "index.html";
      }
     
  } else {
    $reg = "Passwords do not match";
    $lin = "registration.html";
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="style.css">
  <title>Compute companion - Registration</title>
  <link rel="icon" type="image/png" href="favicon.png">
</head>
<body>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script type="module" src="script.js"></script>
    <section>
        <div class="form-box">
            <div class="form-value">
                    <h2><?php echo $reg?></h2>
                    <div class="register">
                        <p>Undo? <a href="<?php echo $lin?>">Go Back</a></p>
                    </div>
            </div>
        </div>
    </section>
</body>
</html>