<?php
// Include your database connection here
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['token'], $_POST['password'], $_POST['confirm_password'])) {
        $token = mysqli_real_escape_string($con

            , $_POST['token']);
        $password = mysqli_real_escape_string($con

            , $_POST['password']);
        $confirmPassword = mysqli_real_escape_string($con

            , $_POST['confirm_password']);

        if ($password === $confirmPassword) {
            // Verify token and check expiry
            $query = "SELECT * FROM users WHERE reset_token = '$token' AND token_expiry > NOW()";
            $result = mysqli_query($con

            , $query);

            if (mysqli_num_rows($result) > 0) {
                // Hash the new password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Update the password in the database and clear the token
                $updateQuery = "UPDATE users SET password = '$hashedPassword', reset_token = NULL, token_expiry = NULL WHERE reset_token = '$token'";

                if (mysqli_query($con

            , $updateQuery)) {
                    echo "Your password has been successfully reset. You can now log in.";
                } else {
                    echo "Failed to reset your password. Please try again.";
                }
            } else {
                echo "Invalid or expired token.";
            }
        } else {
            echo "Passwords do not match.";
        }
    }
} elseif (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($con

            , $_GET['token']);

    // Verify if the token exists and is valid
    $query = "SELECT * FROM users WHERE reset_token = '$token' AND token_expiry > NOW()";
    $result = mysqli_query($con

            , $query);

    if (mysqli_num_rows($result) === 0) {
        die("Invalid or expired token.");
    }
} else {
    die("Invalid request.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script>
        function togglePasswordVisibility(id) {
            const input = document.getElementById(id);
            if (input.type === 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        }
    </script>
</head>
<body>
    <h2>Reset Password</h2>
    <form method="POST" action="">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
        <label for="password">New Password:</label><br>
        <input type="password" name="password" id="password" required>
        <button type="button" onclick="togglePasswordVisibility('password')">Show</button><br><br>

        <label for="confirm_password">Confirm New Password:</label><br>
        <input type="password" name="confirm_password" id="confirm_password" required>
        <button type="button" onclick="togglePasswordVisibility('confirm_password')">Show</button><br><br>

        <button type="submit">Reset Password</button>
    </form>
</body>
</html>