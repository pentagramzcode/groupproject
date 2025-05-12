<?php
session_start();
$_SESSION = []; // Clear session variables

// If using cookies, delete the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

session_destroy(); // Destroy the session
header("Location: ../index.php"); // Adjust path if needed
exit; // Ensure no further code is executed
?>