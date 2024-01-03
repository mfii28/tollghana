<?php
session_start();

// Unset specific session variables if needed
// unset($_SESSION['some_variable']);

// Destroy the entire session
session_destroy();

// Redirect to the login page
header("Location: ../index.html");
exit();
?>
