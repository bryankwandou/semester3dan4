
<?php
session_start();

// Hapus semua session variables
session_unset();

// Hancurkan session
session_destroy();

// Hapus cookie remember_user jika ada
if (isset($_COOKIE['remember_user'])) {
    setcookie('remember_user', '', time() - 3600, '/');
}

// Redirect ke login.php
header("Location: login.php");
exit();
?>