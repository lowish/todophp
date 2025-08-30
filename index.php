<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg,rgb(5, 5, 5) 0%, #000000ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .hero-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 60px 40px;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            max-width: 600px;
            width: 100%;
        }
        
        .hero-title {
            font-size: 3.5rem;
            color: #333;
            margin-bottom: 20px;
            font-weight: 700;
            background: linear-gradient(135deg, #000000ff 100%, #000000ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            color: #000000ff;
            margin-bottom: 60px;
            line-height: 1.6;
        }
        
        .login-section {
            margin-top: 60px;
            padding-top: 40px;
            border-top: 1px solid #eee;
        }
        
        .btn {
            padding: 15px 40px;
            border: none;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            min-width: 180px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg,rgb(6, 7, 10) 0%, #000000ff 100%);
            color: white;
        }
        
        .btn-secondary {
            background: transparent;
            color:  #000000ff ;
            border: 2px solid  #000000ff ;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        .btn-secondary:hover {
            background: linear-gradient(135deg,rgb(6, 7, 10) 0%, #000000ff 100%);
            color: white;x
        }
        
        @media (max-width: 768px) {
            .hero-container {
                padding: 40px 20px;
            }
            
            .hero-title {
                font-size: 2.8rem;
            }
            
            .btn {
                width: 100%;
                max-width: 250px;
            }
        }
    </style>
</head>
<body>
    <div class="hero-container">
        <h1 class="hero-title">TDL</h1>
        <p class="hero-subtitle">
            Organize your tasks and boost your productivity with our simple and efficient to-do list application.
        </p>
        
        <div class="login-section">
            <a href="login.php" class="btn btn-primary">Login</a>
            <a href="register.php" class="btn btn-secondary" style="margin-left: 20px;">Create Account</a>
        </div>
    </div>
</body>
</html>
