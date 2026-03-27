<?php
include('connection.php');

$reg = "Invalid request";
$lin = "registration.html";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = isset($_POST['username']) ? strtolower(trim($_POST['username'])) : "";
    $password = isset($_POST['password']) ? strtolower(trim($_POST['password'])) : "";
    $cpassword = isset($_POST['cpassword']) ? strtolower(trim($_POST['cpassword'])) : "";
    $email = isset($_POST['email']) ? strtolower(trim($_POST['email'])) : "";

    $username = stripslashes($username);
    $password = stripslashes($password);
    $cpassword = stripslashes($cpassword);
    $email = stripslashes($email);

    $username = mysqli_real_escape_string($con, $username);
    $password = mysqli_real_escape_string($con, $password);
    $cpassword = mysqli_real_escape_string($con, $cpassword);
    $email = mysqli_real_escape_string($con, $email);

    if (empty($username) || empty($password) || empty($cpassword) || empty($email)) {
        $reg = "All fields are required";
        $lin = "registration.html";
    } elseif ($password !== $cpassword) {
        $reg = "Passwords do not match";
        $lin = "registration.html";
    } else {
        $checkSql = "SELECT * FROM logins WHERE Email = '$email'";
        $result = $con->query($checkSql);

        if (!$result) {
            die("Check query failed: " . $con->error);
        }

        if ($result->num_rows > 0) {
            $reg = "Email already in use";
            $lin = "registration.html";
        } else {
            $stmt = $con->prepare("INSERT INTO logins (Email, Password, Name) VALUES (?, ?, ?)");

            if (!$stmt) {
                die("Prepare failed: " . $con->error);
            }

            $stmt->bind_param("sss", $email, $password, $username);

            if ($stmt->execute()) {
                $reg = "Registration Successful";
                $lin = "index.html";
            } else {
                die("Execute failed: " . $stmt->error);
            }

            $stmt->close();
        }
    }

    $con->close();
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
                <h2><?php echo htmlspecialchars($reg); ?></h2>
                <div class="register">
                    <p>Undo? <a href="<?php echo htmlspecialchars($lin); ?>">Go Back</a></p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>