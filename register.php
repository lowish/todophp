<?php
session_start();
require_once 'config/database.php';

// Redirect if user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: todo.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $full_name = trim($_POST['full_name']);
    
    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($full_name)) {
        $error = 'All fields are required';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long';
    } elseif (strlen($username) < 3) {
        $error = 'Username must be at least 3 characters long';
    } else {
        try {
            $conn = getConnection();
            
            // Check if username or email already exists
            $sql = "SELECT id FROM users WHERE username = ? OR email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username, $email]);
            
            if ($stmt->fetch()) {
                $error = 'Username or email already exists';
            } else {
                // Create new user
                $sql = "INSERT INTO users (username, email, password, full_name) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt->execute([$username, $email, $hashedPassword, $full_name]);
                
                $success = 'Account created successfully! You can now login.';
                
                // Clear form data after successful registration
                $username = $email = $full_name = '';
            }
        } catch(PDOException $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - To Do List</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg,rgb(5, 5, 5) 0%, #000000ff 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .register-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 10px 70px;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(183, 36, 36, 0.15);
            width: 100%;
            max-width: 500px;
            position: relative;
            overflow: hidden;
        }
        
      
        .register-header {
            text-align: center;
            margin-bottom: 30px;
            margin-top: 15px;
        }
        
        .register-header h1 {
            color: #333;
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .register-header p {
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
        
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
            border-color: #667eea;
            background: white;
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .btn-register {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #000000ff 0%, #000000ff 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }
        
        .btn-register:active {
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
        
        .message.success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 500;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }
        
        .login-link {
            text-align: center;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #e1e5e9;
        }
        
        .login-link p {
            color: #666;
            margin-bottom: 15px;
        }
        
        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .login-link a:hover {
            color: #764ba2;
        }
        
        .home-link {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 10px;
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
            .register-container {
                margin: 20px;
                padding: 40px 30px;
            }
            
            .register-header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1>Create Account</h1>
            <p>Sign up for your to-do list</p>
        </div>
        
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="message success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <input type="text" id="full_name" name="full_name" required placeholder="Name" 
                       value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>">
                <div class="input-icon"></div>
            </div>
            
            <div class="form-group">
                <input type="text" id="username" name="username" required placeholder="Username" 
                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                <div class="input-icon"></div>
            </div>
            
            <div class="form-group">
                <input type="email" id="email" name="email" required placeholder="Email" 
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                <div class="input-icon"></div>
            </div>
            
          
            
            <div class="form-group">
                <input type="password" id="password" name="password" required placeholder="Password">
                <div class="input-icon"></div>
            </div>
            
            <div class="form-group">
                <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirm Password">
                <div class="input-icon"></div>
            </div>
            
            <button type="submit" class="btn-register">Create Account</button>
        </form>
        
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Sign in</a></p>
        </div>
        
        <div class="home-link">
            <a href="index.php">Back to Home</a>
        </div>
    </div>
</body>
</html>
