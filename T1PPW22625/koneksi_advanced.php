<?php
/**
 * File Koneksi Database Advanced
 * Menggunakan file config terpisah dan error handling yang lebih baik
 */

// Include file konfigurasi
require_once 'config.php';

class DatabaseConnection {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        $this->connect();
    }
    
    /**
     * Singleton pattern untuk koneksi database
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }
    
    /**
     * Membuat koneksi ke database
     */
    private function connect() {
        try {
            $config = getDatabaseConfig();
            
            $this->connection = new mysqli(
                $config['host'],
                $config['username'],
                $config['password'],
                $config['database']
            );
            
            if ($this->connection->connect_error) {
                throw new Exception("Connection failed: " . $this->connection->connect_error);
            }
            
            // Set charset
            $this->connection->set_charset($config['charset']);
            
            // Set SQL mode
            $this->connection->query("SET sql_mode = ''");
            
        } catch (Exception $e) {
            $this->handleError("Database connection error: " . $e->getMessage());
        }
    }
    
    /**
     * Mendapatkan koneksi database
     */
    public function getConnection() {
        return $this->connection;
    }
    
    /**
     * Handle error
     */
    private function handleError($message) {
        if (LOG_ERRORS) {
            error_log($message);
        }
        
        if (SHOW_ERRORS) {
            die("Database Error: " . $message);
        } else {
            die("Maaf, terjadi kesalahan sistem. Silakan coba lagi nanti.");
        }
    }
    
    /**
     * Tutup koneksi
     */
    public function close() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
    
    /**
     * Prevent cloning
     */
    private function __clone() {}
    
    /**
     * Prevent unserialization
     */
    private function __wakeup() {}
}

// Inisialisasi koneksi
$db = DatabaseConnection::getInstance();
$conn = $db->getConnection();

/**
 * Fungsi helper untuk prepared statement
 */
function executeQuery($sql, $params = [], $types = '') {
    global $conn;
    
    try {
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        return $stmt;
        
    } catch (Exception $e) {
        error_log("Query execution error: " . $e->getMessage());
        return false;
    }
}

/**
 * Fungsi untuk SELECT query
 */
function selectData($sql, $params = [], $types = '') {
    $stmt = executeQuery($sql, $params, $types);
    if ($stmt) {
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }
    return false;
}

/**
 * Fungsi untuk INSERT/UPDATE/DELETE query
 */
function executeNonQuery($sql, $params = [], $types = '') {
    $stmt = executeQuery($sql, $params, $types);
    if ($stmt) {
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $affected_rows;
    }
    return false;
}
?>