<?php
session_start();
session_unset();
session_destroy();

// Hapus cookie juga
setcookie('username', '', time() - 3600, "/");

header("Location: login.html");
exit;
?>
