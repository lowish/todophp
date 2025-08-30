<?php
require_once 'config/database.php';<?php
<!-- ...existing code... -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: black; /* Entire page background in black */
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            background: black; /* Set container background to black */
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 450px;
            position: relative;
            overflow: hidden;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .login-header h1 {
            color: white; /* White text for visibility */
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .login-header p {
            color: #ccc;
            font-size: 1.1rem;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #ddd;
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #444;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #222;
            color: white;
        }
        
        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #667eea;
            background: #000;
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .btn-login {
            width: 100%;
            padding: 15px;
            background-color: #333; /* Dark button background */
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .error {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 500;
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
        }
        
        .register-link {
            text-align: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid #444;
        }
        
        .register-link p {
            color: #ccc;
            margin-bottom: 15px;
        }
        
        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .register-link a:hover {
            color: #764ba2;
        }
        
        .home-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .home-link a {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .home-link a:hover {
            color: #764ba2;
        }
        
        .input-icon {
            position: absolute;
            right: 15px;
            top: 15px;
            color: #999;
            font-size: 18px;
        }
        
        @media (max-width: 768px) {
            .login-container {
                margin: 20px;
                padding: 40px 30px;
            }
            
            .login-header h1 {
                font-size: 2rem;
            }
        }
    </style>
<!-- ...existing code... -->

try {
    $conn = getConnection();
    
    // Check if test user already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = 'testuser'");
    $stmt->execute();
    
    if ($stmt->fetch()) {
        echo "Test user already exists!<br>";
        echo "Username: testuser<br>";
        echo "Password: test123<br>";
        echo "<br><a href='index.php'>Go to Home</a> | <a href='login.php'>Go to Login</a>";
    } else {
        // Create test user
        $sql = "INSERT INTO users (username, email, password, full_name) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $hashedPassword = password_hash('test123', PASSWORD_DEFAULT);
        $stmt->execute(['testuser', 'test@example.com', $hashedPassword, 'Test User']);
        
        echo "Test user created successfully!<br>";
        echo "Username: testuser<br>";
        echo "Password: test123<br>";
        echo "<br><a href='index.php'>Go to Home</a> | <a href='login.php'>Go to Login</a>";
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
