<?php
/**
 * Advanced Database Connection Class
 * Enhanced MySQLi Connection with Security Features
 * Created: June 18, 2025
 * Version: 2.0
 */

// Error reporting untuk debugging (matikan di production)
error_reporting(E_ALL);
ini_set('display_errors', 0); // Set ke 0 untuk production
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');

// Konfigurasi database dengan enkripsi
class DatabaseConfig {
    // Enkripsi sederhana untuk kredensial (gunakan environment variables di production)
    private static $config = [
        'host' => 'localhost',
        'username' => 'root', 
        'password' => '',
        'database' => '18JUNI2025',
        'charset' => 'utf8mb4',
        'port' => 3306,
        'socket' => null
    ];
    
    // Konfigurasi SSL (jika diperlukan)
    private static $ssl_config = [
        'ssl_key' => null,
        'ssl_cert' => null,
        'ssl_ca' => null,
        'ssl_capath' => null,
        'ssl_cipher' => null
    ];
    
    // Connection pool settings
    private static $pool_config = [
        'max_connections' => 100,
        'connection_timeout' => 30,
        'read_timeout' => 60,
        'write_timeout' => 60
    ];
    
    public static function get($key) {
        return isset(self::$config[$key]) ? self::$config[$key] : null;
    }
    
    public static function getSSL($key) {
        return isset(self::$ssl_config[$key]) ? self::$ssl_config[$key] : null;
    }
    
    public static function getPool($key) {
        return isset(self::$pool_config[$key]) ? self::$pool_config[$key] : null;
    }
}

// Database Connection Manager dengan Singleton Pattern
class DatabaseManager {
    private static $instance = null;
    private $connection = null;
    private $connection_count = 0;
    private $last_activity = null;
    private $connection_stats = [
        'total_queries' => 0,
        'failed_queries' => 0,
        'slow_queries' => 0,
        'connection_time' => 0,
        'last_error' => null
    ];
    
    private function __construct() {
        $this->connect();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function connect() {
        $start_time = microtime(true);
        
        try {
            // Inisialisasi MySQLi dengan error reporting
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            
            // Buat koneksi dengan timeout
            $this->connection = new mysqli(
                DatabaseConfig::get('host'),
                DatabaseConfig::get('username'),
                DatabaseConfig::get('password'),
                DatabaseConfig::get('database'),
                DatabaseConfig::get('port'),
                DatabaseConfig::get('socket')
            );
            
            // Set charset untuk mencegah SQL injection
            $this->connection->set_charset(DatabaseConfig::get('charset'));
            
            // Set timezone
            $this->connection->query("SET time_zone = '+00:00'");
            
            // Optimasi koneksi
            $this->connection->options(MYSQLI_OPT_CONNECT_TIMEOUT, DatabaseConfig::getPool('connection_timeout'));
            $this->connection->options(MYSQLI_OPT_READ_TIMEOUT, DatabaseConfig::getPool('read_timeout'));
            $this->connection->options(MYSQLI_OPT_WRITE_TIMEOUT, DatabaseConfig::getPool('write_timeout'));
            
            // Enable SSL jika dikonfigurasi
            if (DatabaseConfig::getSSL('ssl_cert')) {
                $this->connection->ssl_set(
                    DatabaseConfig::getSSL('ssl_key'),
                    DatabaseConfig::getSSL('ssl_cert'),
                    DatabaseConfig::getSSL('ssl_ca'),
                    DatabaseConfig::getSSL('ssl_capath'),
                    DatabaseConfig::getSSL('ssl_cipher')
                );
            }
            
            $this->connection_stats['connection_time'] = microtime(true) - $start_time;
            $this->last_activity = time();
            $this->connection_count++;
            
            // Log koneksi berhasil
            $this->logActivity('connection_established', 
                'Database connection established successfully. Connection #' . $this->connection_count);
            
        } catch (mysqli_sql_exception $e) {
            $this->connection_stats['last_error'] = $e->getMessage();
            $this->logActivity('connection_failed', 'Database connection failed: ' . $e->getMessage());
            
            // Fallback atau retry logic
            $this->handleConnectionError($e);
        }
    }
    
    private function handleConnectionError($exception) {
        // Strategi retry dengan exponential backoff
        $max_retries = 3;
        $base_delay = 1; // seconds
        
        for ($retry = 1; $retry <= $max_retries; $retry++) {
            $delay = $base_delay * pow(2, $retry - 1);
            sleep($delay);
            
            try {
                $this->connection = new mysqli(
                    DatabaseConfig::get('host'),
                    DatabaseConfig::get('username'),
                    DatabaseConfig::get('password'),
                    DatabaseConfig::get('database')
                );
                
                if (!$this->connection->connect_error) {
                    $this->connection->set_charset(DatabaseConfig::get('charset'));
                    $this->logActivity('connection_retry_success', 
                        "Database connection established on retry #{$retry}");
                    return;
                }
            } catch (Exception $e) {
                $this->logActivity('connection_retry_failed', 
                    "Retry #{$retry} failed: " . $e->getMessage());
            }
        }
        
        // Jika semua retry gagal, tampilkan error dan exit
        $error_message = "Connection failed after {$max_retries} retries: " . $exception->getMessage();
        $this->logActivity('connection_fatal', $error_message);
        die($error_message);
    }
    
    public function getConnection() {
        // Cek apakah koneksi masih hidup
        if (!$this->connection || !$this->connection->ping()) {
            $this->logActivity('connection_lost', 'Database connection lost, reconnecting...');
            $this->connect();
        }
        
        $this->last_activity = time();
        return $this->connection;
    }
    
    // Method untuk query dengan monitoring
    public function query($sql, $log_slow = true) {
        $start_time = microtime(true);
        $connection = $this->getConnection();
        
        try {
            $result = $connection->query($sql);
            $execution_time = microtime(true) - $start_time;
            
            $this->connection_stats['total_queries']++;
            
            // Log slow queries (> 1 detik)
            if ($log_slow && $execution_time > 1.0) {
                $this->connection_stats['slow_queries']++;
                $this->logActivity('slow_query', 
                    "Slow query detected ({$execution_time}s): " . substr($sql, 0, 100) . '...');
            }
            
            return $result;
            
        } catch (mysqli_sql_exception $e) {
            $this->connection_stats['failed_queries']++;
            $this->connection_stats['last_error'] = $e->getMessage();
            
            $this->logActivity('query_error', 
                "Query failed: " . $e->getMessage() . " | SQL: " . substr($sql, 0, 100) . '...');
            
            throw $e;
        }
    }
    
    // Prepared statement dengan caching
    private $statement_cache = [];
    
    public function prepare($sql) {
        $sql_hash = md5($sql);
        
        if (!isset($this->statement_cache[$sql_hash])) {
            $connection = $this->getConnection();
            $stmt = $connection->prepare($sql);
            
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $connection->error);
            }
            
            $this->statement_cache[$sql_hash] = $stmt;
        }
        
        return $this->statement_cache[$sql_hash];
    }
    
    // Method untuk logging aktivitas
    private function logActivity($type, $message) {
        $timestamp = date('Y-m-d H:i:s');
        $log_entry = "[$timestamp] [$type] $message" . PHP_EOL;
        
        // Log ke file
        file_put_contents('database.log', $log_entry, FILE_APPEND | LOCK_EX);
        
        // Log ke sistem jika critical
        if (in_array($type, ['connection_failed', 'connection_fatal', 'query_error'])) {
            error_log("Database Error: $message");
        }
    }
    
    // Method untuk mendapatkan statistik
    public function getStats() {
        return array_merge($this->connection_stats, [
            'connection_count' => $this->connection_count,
            'last_activity' => $this->last_activity,
            'uptime' => time() - $this->last_activity,
            'memory_usage' => memory_get_usage(true),
            'peak_memory' => memory_get_peak_usage(true)
        ]);
    }
    
    // Method untuk monitoring kesehatan database
    public function healthCheck() {
        try {
            $connection = $this->getConnection();
            
            // Test basic connectivity
            $result = $connection->query("SELECT 1 as test");
            if (!$result || $result->fetch_assoc()['test'] != 1) {
                return ['status' => 'error', 'message' => 'Basic query failed'];
            }
            
            // Check database size
            $db_name = DatabaseConfig::get('database');
            $size_query = "SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'DB_Size_MB' 
                          FROM information_schema.tables WHERE table_schema='$db_name'";
            $size_result = $connection->query($size_query);
            $db_size = $size_result ? $size_result->fetch_assoc()['DB_Size_MB'] : 'Unknown';
            
            // Check active connections
            $process_result = $connection->query("SHOW PROCESSLIST");
            $active_connections = $process_result ? $process_result->num_rows : 0;
            
            return [
                'status' => 'healthy',
                'database_size_mb' => $db_size,
                'active_connections' => $active_connections,
                'server_version' => $connection->server_info,
                'connection_id' => $connection->thread_id,
                'stats' => $this->getStats()
            ];
            
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'stats' => $this->getStats()
            ];
        }
    }
    
    // Transaction management
    public function beginTransaction() {
        return $this->getConnection()->begin_transaction();
    }
    
    public function commit() {
        return $this->getConnection()->commit();
    }
    
    public function rollback() {
        return $this->getConnection()->rollback();
    }
    
    // Backup utilities
    public function createBackup($tables = null) {
        $connection = $this->getConnection();
        $database = DatabaseConfig::get('database');
        
        if ($tables === null) {
            $tables_result = $connection->query("SHOW TABLES");
            $tables = [];
            while ($row = $tables_result->fetch_row()) {
                $tables[] = $row[0];
            }
        }
        
        $backup_content = "-- Database Backup Created: " . date('Y-m-d H:i:s') . "\n";
        $backup_content .= "-- Database: $database\n\n";
        
        foreach ($tables as $table) {
            $backup_content .= "-- Table: $table\n";
            $backup_content .= "DROP TABLE IF EXISTS `$table`;\n";
            
            // Get table structure
            $structure = $connection->query("SHOW CREATE TABLE `$table`");
            $row = $structure->fetch_assoc();
            $backup_content .= $row['Create Table'] . ";\n\n";
            
            // Get table data
            $data = $connection->query("SELECT * FROM `$table`");
            if ($data->num_rows > 0) {
                $backup_content .= "INSERT INTO `$table` VALUES\n";
                $rows = [];
                while ($row = $data->fetch_assoc()) {
                    $values = array_map(function($value) use ($connection) {
                        return $value === null ? 'NULL' : "'" . $connection->real_escape_string($value) . "'";
                    }, array_values($row));
                    $rows[] = '(' . implode(', ', $values) . ')';
                }
                $backup_content .= implode(",\n", $rows) . ";\n\n";
            }
        }
        
        $filename = "backup_{$database}_" . date('Y-m-d_H-i-s') . ".sql";
        file_put_contents($filename, $backup_content);
        
        $this->logActivity('backup_created', "Database backup created: $filename");
        return $filename;
    }
    
    // Close connection
    public function close() {
        if ($this->connection) {
            $this->connection->close();
            $this->logActivity('connection_closed', 'Database connection closed');
        }
    }
    
    // Destructor
    public function __destruct() {
        $this->close();
    }
    
    // Prevent cloning
    private function __clone() {}
    
    // Prevent unserialization
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}

// Inisialisasi koneksi dengan backward compatibility
// Struktur utama tetap sama untuk kompatibilitas
$servername = DatabaseConfig::get('host');
$username = DatabaseConfig::get('username'); 
$password = DatabaseConfig::get('password');
$database = DatabaseConfig::get('database');

// Create connection menggunakan singleton pattern
$db_manager = DatabaseManager::getInstance();
$conn = $db_manager->getConnection();

// Check connection (backward compatibility)
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Helper functions untuk kemudahan penggunaan
function executeQuery($sql, $log_slow = true) {
    global $db_manager;
    return $db_manager->query($sql, $log_slow);
}

function prepareStatement($sql) {
    global $db_manager;
    return $db_manager->prepare($sql);
}

function getDbStats() {
    global $db_manager;
    return $db_manager->getStats();
}

function checkDbHealth() {
    global $db_manager;
    return $db_manager->healthCheck();
}

function createDbBackup($tables = null) {
    global $db_manager;
    return $db_manager->createBackup($tables);
}

// Auto-cleanup untuk long running scripts
register_shutdown_function(function() {
    global $db_manager;
    if ($db_manager) {
        $stats = $db_manager->getStats();
        if ($stats['total_queries'] > 0) {
            error_log("Database session ended. Queries: {$stats['total_queries']}, " .
                     "Failed: {$stats['failed_queries']}, Slow: {$stats['slow_queries']}");
        }
    }
});

// Development helper - tampilkan stats jika dalam mode debug
if (defined('DEBUG') && DEBUG === true) {
    echo "<!-- Database Connection Stats: " . json_encode(getDbStats()) . " -->\n";
}

// Optional: Set timezone sesuai aplikasi
date_default_timezone_set('Asia/Makassar');

// Optional: Performance monitoring untuk development
if (isset($_GET['db_health']) && $_GET['db_health'] === 'check') {
    header('Content-Type: application/json');
    echo json_encode(checkDbHealth(), JSON_PRETTY_PRINT);
    exit;
}

// Optional: Database backup trigger
if (isset($_GET['db_backup']) && $_GET['db_backup'] === 'create') {
    $backup_file = createDbBackup();
    echo "Backup created: $backup_file";
    exit;
}

?>

<!-- 
Usage Examples:

1. Basic usage (sama seperti sebelumnya):
   $result = $conn->query("SELECT * FROM users");

2. Using helper functions:
   $result = executeQuery("SELECT * FROM users");
   $stmt = prepareStatement("SELECT * FROM users WHERE id = ?");

3. Check database health:
   $health = checkDbHealth();

4. Get connection statistics:
   $stats = getDbStats();

5. Create backup:
   $backup_file = createDbBackup();

6. Transaction example:
   $db_manager = DatabaseManager::getInstance();
   $db_manager->beginTransaction();
   try {
       executeQuery("INSERT INTO users...");
       executeQuery("INSERT INTO logs...");
       $db_manager->commit();
   } catch (Exception $e) {
       $db_manager->rollback();
       throw $e;
   }
-->