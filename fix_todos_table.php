<?php
require_once 'config/database.php';

echo "<h2>Checking and Fixing Todos Table</h2>";

try {
    $conn = getConnection();
    echo "✅ Connected to database successfully<br>";
    
    // Check if todos table exists
    $stmt = $conn->query("SHOW TABLES LIKE 'todos'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Todos table already exists<br>";
    } else {
        echo "❌ Todos table does not exist. Creating it now...<br>";
        
        // Create todos table
        $sql = "CREATE TABLE IF NOT EXISTS todos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            task TEXT NOT NULL,
            status ENUM('pending', 'completed') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $conn->exec($sql);
        echo "✅ Todos table created successfully!<br>";
    }
    
    // Check table structure
    echo "<br><h3>Table Structure:</h3>";
    $stmt = $conn->query("DESCRIBE todos");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    foreach ($columns as $column) {
        echo "<tr>";
        echo "<td>" . $column['Field'] . "</td>";
        echo "<td>" . $column['Type'] . "</td>";
        echo "<td>" . $column['Null'] . "</td>";
        echo "<td>" . $column['Key'] . "</td>";
        echo "<td>" . $column['Default'] . "</td>";
        echo "<td>" . $column['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Check if there are any users
    $stmt = $conn->query("SELECT COUNT(*) as user_count FROM users");
    $userCount = $stmt->fetch(PDO::FETCH_ASSOC)['user_count'];
    echo "<br>👥 Total users in database: " . $userCount . "<br>";
    
    if ($userCount == 0) {
        echo "<br>⚠️ No users found. You may need to create a user first.<br>";
        echo "<a href='create_test_user.php'>Create Test User</a><br>";
    }
    
    echo "<br><h3>Next Steps:</h3>";
    echo "1. <a href='index.php'>Go to Homepage</a><br>";
    echo "2. <a href='register.php'>Create an Account</a><br>";
    echo "3. <a href='login.php'>Login</a><br>";
    
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "<br>Please check your database connection and try running <a href='setup_database.php'>setup_database.php</a> first.";
}
?>
