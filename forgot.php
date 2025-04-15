<?php
// Include your database connection here
include('connection.php');
if (!$con

            ) {
    die("Database connection error!");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email'])) {
        $email = mysqli_real_escape_string($con

            , $_POST['email']);

        // Rest of your code...
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email'])) {
        $email = mysqli_real_escape_string($con

            , $_POST['email']);

        // Verify if the email exists in the database
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0) {
            // Generate a unique token
            $token = bin2hex(random_bytes(32));

            // Save the token in the database with an expiry time (e.g., 1 hour)
            $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));
            $updateQuery = "UPDATE users SET reset_token = '$token', token_expiry = '$expiry' WHERE email = '$email'";
            mysqli_query($con

            , $updateQuery);

            // Create a reset link
            $resetLink = "https://8003-2a02-6b67-dff6-6700-8dfd-e184-19bf-fdf4.ngrok-free.app/reset_password.php?token=$token";

            // Send the reset link via email
            $subject = "Password Reset Request";
            $message = "Click the link below to reset your password:\n$resetLink";
            $headers = "From: compute.companion@gmail.com";

            if (mail($email, $subject, $message, $headers)) {
                echo "An email with a password reset link has been sent to your email address.";
            } else {
                echo "Failed to send email. Please try again later.";
            }
        } else {
            echo "Email address not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="POST" action="">
        <label for="email">Enter your registered email:</label><br>
        <input type="email" name="email" id="email" required><br>
        <button type="submit">Send Reset Link</button>
    </form>
</body>
</html>
