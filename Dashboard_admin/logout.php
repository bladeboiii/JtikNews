<?php
session_start();
// Destroy all session data
$_SESSION = array();

// If a session cookie is used, destroy it
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Finally, destroy the session
session_destroy();

// Redirect to homepage
header("Location: ../index.php");
exit;