<?php
session_start(); // Starts the session or resumes the current session

// Destroy the session
session_unset(); // Clears all session variables, effectively removing any stored user data
session_destroy(); // Destroys the session, deleting session data on the server side

// Redirect to login page or wherever appropriate
header("Location: index.html"); // Redirects the user to 'index.html', usually the login page
exit(); // Ends the script to prevent further execution after the redirect
?>
