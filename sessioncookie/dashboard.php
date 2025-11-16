<?php
session_start();

if (!isset($_SESSION['username'])) {
    if (isset($_COOKIE['username'])) {
        $_SESSION['username'] = $_COOKIE['username'];
    } else {
        echo "Akses ditolak. <a href='login.html'>Login dulu</a>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #e8f0fe;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .dashboard {
      background: white;
      padding: 40px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .dashboard h2 {
      color: #333;
      margin-bottom: 20px;
    }
    .dashboard a {
      display: inline-block;
      margin-top: 15px;
      padding: 10px 20px;
      background: #dc3545;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
    .dashboard a:hover {
      background: #c82333;
    }
  </style>
</head>
<body>
  <div class="dashboard">
    <h2>Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>Anda berhasil login.</p>
    <a href="logout.php">Logout</a>
  </div>
</body>
</html>
