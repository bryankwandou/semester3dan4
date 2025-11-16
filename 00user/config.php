<?php
// config.php - Database Configuration
class Database {
    private $host = "localhost";
    private $username = "root"; // Ganti dengan username MySQL Anda
    private $password = ""; // Ganti dengan password MySQL Anda
    private $database = "property_db"; // Nama database
    private $connection;
    
    public function __construct() {
        $this->connect();
    }
    
    private function connect() {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch(PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function closeConnection() {
        $this->connection = null;
    }
}

// Fungsi untuk membuat tabel jika belum ada
function createTables() {
    $db = new Database();
    $conn = $db->getConnection();
    
    // Tabel users
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    try {
        $conn->exec($sql);
        echo "Tabel users berhasil dibuat atau sudah ada.<br>";
    } catch(PDOException $e) {
        echo "Error creating users table: " . $e->getMessage() . "<br>";
    }
    
    // Tabel password_resets untuk OTP
    $sql = "CREATE TABLE IF NOT EXISTS password_resets (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(100) NOT NULL,
        otp VARCHAR(6) NOT NULL,
        expires_at TIMESTAMP NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        is_used BOOLEAN DEFAULT FALSE
    )";
    
    try {
        $conn->exec($sql);
        echo "Tabel password_resets berhasil dibuat atau sudah ada.<br>";
    } catch(PDOException $e) {
        echo "Error creating password_resets table: " . $e->getMessage() . "<br>";
    }
    
    $db->closeConnection();
}

// Uncomment baris di bawah untuk membuat tabel (jalankan sekali saja)
// createTables();
?>