<?php
session_start();

// Destroy the session
session_unset();
session_destroy();

// Redirect to login page or wherever appropriate
header("Location: index.html");
exit();
?>
