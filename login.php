<?php
session_start();
require_once 'config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    try {
        $conn = getConnection();
        
        // Check if user exists
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            header('Location: todo.php');
            exit();
        } else {
            $error = 'Invalid email or password';
        }
    } catch(PDOException $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - To Do List</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: black; /* changed background to black */
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
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
            color: #333;
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .login-header p {
            color: #666;
            font-size: 1.1rem;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #667eea;
            background: white;
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .btn-login {
            width: 100%;
            padding: 15px;
            background-color: black; 
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
            border-top: 1px solid #e1e5e9;
        }
        
        .register-link p {
            color: #666;
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
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Welcome Back!</h1>
           
        </div>
        
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <input type="email" id="email" name="email" required placeholder="Email">
                <div class="input-icon"></div>
            </div>
            
            <div class="form-group">
                <input type="password" id="password" name="password" required placeholder="Password">
                <div class="input-icon"></div>
            </div>
            
            <button type="submit" class="btn-login">Sign In</button>
        </form>
        
        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Create one here</a></p>
        </div>
        
        <div class="home-link">
            <a href="index.php">Back to Home</a>
        </div>
    </div>
</body>
</html>
