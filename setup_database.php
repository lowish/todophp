<?php
// Database setup script for users_db
require_once 'config/database.php';

try {
    // Connect without specifying database
    $conn = getConnectionWithoutDB();
    
    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $conn->exec($sql);
    echo "Database '" . DB_NAME . "' created successfully or already exists.<br>";
    
    // Select the database
    $conn->exec("USE " . DB_NAME);    <?php
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>To-Do Dashboard</title>
        <style>
            body {
                background: black; /* Overall page is black */
                margin: 0;
                padding: 0;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                color: white;
            }
            
            .todo-container {
                background: black; /* Container background matches the page */
                color: white;
                padding: 30px;
                border-radius: 10px;
                max-width: 800px;
                width: 90%;
                /* Optional: a subtle border or shadow for separation */
                border: 1px solid #333;
            }
        </style>
    </head>
    <body>
        <div class="todo-container">
            <!-- Your existing content for todo.php goes here -->
        </div>
    </body>
    </html>
    ```  
    
    Save your file and refresh [http://localhost/PHP/todo.php](http://localhost/PHP/todo.php) to see the matching black backgrounds.// filepath: c:\xampp\htdocs\PHP\todo.php
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>To-Do Dashboard</title>
        <style>
            body {
                background: black; /* Overall page is black */
                margin: 0;
                padding: 0;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                color: white;
            }
            
            .todo-container {
                background: black; /* Container background matches the page */
                color: white;
                padding: 30px;
                border-radius: 10px;
                max-width: 800px;
                width: 90%;
                /* Optional: a subtle border or shadow for separation */
                border: 1px solid #333;
            }
        </style>
    </head>
    <body>
        <div class="todo-container">
            <!-- Your existing content for todo.php goes here -->
        </div>
    </body>
    </html>
    ```  
    
    Save your file and refresh [http://localhost/PHP/todo.php](http://localhost/PHP/todo.php)    <?php
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>To-Do Dashboard</title>
        <style>
            body {
                background: black; /* Overall page is black */
                margin: 0;
                padding: 0;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                color: white;
            }
            
            .todo-container {
                background: black; /* Container background matches the page */
                color: white;
                padding: 30px;
                border-radius: 10px;
                max-width: 800px;
                width: 90%;
                /* Optional: a subtle border or shadow for separation */
                border: 1px solid #333;
            }
        </style>
    </head>
    <body>
        <div class="todo-container">
            <!-- Your existing content for todo.php goes here -->
        </div>
    </body>
    </html>
    ```  
    
    Save your file and refresh [http://localhost/PHP/todo.php](http://localhost/PHP/todo.php) to see the matching black backgrounds.// filepath: c:\xampp\htdocs\PHP\todo.php
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>To-Do Dashboard</title>
        <style>
            body {
                background: black; /* Overall page is black */
                margin: 0;
                padding: 0;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                color: white;
            }
            
            .todo-container {
                background: black; /* Container background matches the page */
                color: white;
                padding: 30px;
                border-radius: 10px;
                max-width: 800px;
                width: 90%;
                /* Optional: a subtle border or shadow for separation */
                border: 1px solid #333;
            }
        </style>
    </head>
    <body>
        <div class="todo-container">
            <!-- Your existing content for todo.php goes here -->
        </div>
    </body>
    </html>
    ```  
    
    Save your file and refresh [http://localhost/PHP/todo.php](http://localhost/PHP/todo.php)
    
    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        full_name VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->exec($sql);
    echo "Table 'users' created successfully or already exists.<br>";
    
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
    echo "Table 'todos' created successfully or already exists.<br>";
    
    // Table created successfully - no demo accounts
    echo "Table 'users' created successfully. You can now register with any email.<br>";
    
    echo "<br>Database setup completed successfully!<br>";
    echo "You can now access phpMyAdmin at: <a href='http://localhost/phpmyadmin' target='_blank'>http://localhost/phpmyadmin</a><br>";
    echo "Database name: " . DB_NAME . "<br>";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
