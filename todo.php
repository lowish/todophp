<?php
session_start();
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$error = '';
$success = '';

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}

// Handle task operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        try {
            $conn = getConnection();
            
            switch ($_POST['action']) {
                case 'add':
                    $task = trim($_POST['task']);
                    if (!empty($task)) {
                        $sql = "INSERT INTO todos (user_id, task, status, created_at) VALUES (?, ?, 'pending', NOW())";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([$user_id, $task]);
                        $success = 'Task added successfully!';
                    }
                    break;
                    
                case 'update':
                    $todo_id = $_POST['todo_id'];
                    $task = trim($_POST['task']);
                    if (!empty($task)) {
                        $sql = "UPDATE todos SET task = ? WHERE id = ? AND user_id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([$task, $todo_id, $user_id]);
                        $success = 'Task updated successfully!';
                    }
                    break;
                    
                case 'delete':
                    $todo_id = $_POST['todo_id'];
                    $sql = "DELETE FROM todos WHERE id = ? AND user_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$todo_id, $user_id]);
                    $success = 'Task deleted successfully!';
                    break;
                    
                case 'toggle':
                    $todo_id = $_POST['todo_id'];
                    $status = $_POST['status'] == 'completed' ? 'pending' : 'completed';
                    $sql = "UPDATE todos SET status = ? WHERE id = ? AND user_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$status, $todo_id, $user_id]);
                    $success = 'Task status updated!';
                    break;
            }
        } catch(PDOException $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    }
}

// Fetch todos
try {
    $conn = getConnection();
    $sql = "SELECT * FROM todos WHERE user_id = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);
    $todos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $error = 'Error fetching todos: ' . $e->getMessage();
    $todos = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do Dashboard</title>
    <style>
        /* Apply a black background for everything */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html, body {
            background: black;
            color: white;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* White container with contrasting text */
        .todo-container {
            background: white !important;
            color: black !important;
            padding: 30px;
            border-radius: 10px;
            max-width: 800px;
            width: 90%;
            margin: 40px auto;
            /* Optional subtle shadow */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }
        
        .header {
            background: linear-gradient(135deg, #ffffffff 0%, #ffffffff 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: black;
        }
        
        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
            color: black;
        }
        
        .user-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .logout-btn {
            background: rgba(0, 0, 0, 1);
            color: white;
            border: 1px solid rgba(0, 0, 0, 0.3);
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
 
        
        .content {
            padding: 30px;
        }
        
        .add-task-form {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            border: 2px solid #e9ecef;
        }
        
        .form-group {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .form-group input[type="text"] {
            flex: 1;
            padding: 12px 20px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .form-group input[type="text"]:focus {
            border-color: #ffffffff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #000000ff 0%, #000000ff 100%);
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-success {
            background: #28a745;
            color: white;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-warning {
            background:rgb(62, 155, 232);
            color: #212529;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .todos-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .todo-item {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
        }
        
        .todo-item:hover {
            border-color: #667eea;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
        }
        
        .todo-item.completed {
            background: #f8f9fa;
            border-color: #28a745;
        }
        
        .todo-item.completed .todo-text {
            text-decoration: line-through;
            color: #6c757d;
        }
        
        .todo-checkbox {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        
        .todo-text {
            flex: 1;
            font-size: 16px;
            color: #333;
        }
        
        .todo-actions {
            display: flex;
            gap: 10px;
        }
        
        .todo-actions .btn {
            padding: 8px 12px;
            font-size: 14px;
        }
        
        .edit-form {
            display: flex;
            gap: 10px;
            align-items: center;
            flex: 1;
        }
        
        .edit-form input[type="text"] {
            flex: 1;
            padding: 8px 15px;
            border: 2px solid #667eea;
            border-radius: 8px;
            font-size: 14px;
        }
        
        .message {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }
        
        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        
        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }
        
        .empty-state p {
            font-size: 1.1rem;
        }
        
        @media (max-width: 768px) {
            .container {
                margin: 10px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .content {
                padding: 20px;
            }
            
            .form-group {
                flex-direction: column;
                align-items: stretch;
            }
            
            .todo-item {
                flex-direction: column;
                align-items: stretch;
                gap: 15px;
            }
            
            .todo-actions {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="todo-container">
        <div class="header">
            <div class="user-info">
                <div>
                    <h1>To Do List</h1>
                    <p>Welcome back, <?php echo htmlspecialchars($username); ?>!</p>
                </div>
                <a href="?logout=1" class="logout-btn">Log Out</a>
            </div>
        </div>
        
        <div class="content">
            <?php if ($error): ?>
                <div class="message error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="message success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <div class="add-task-form">
                <form method="POST">
                    <input type="hidden" name="action" value="add">
                    <div class="form-group">
                        <input type="text" name="task" placeholder="Enter your task here..." required>
                        <button type="submit" class="btn btn-primary">Add Task</button>
                    </div>
                </form>
            </div>
            
            <div class="todos-list">
                <?php if (empty($todos)): ?>
                    <div class="empty-state">
                        <h3>No tasks yet!</h3>
                        <p>Add your first task above to get started.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($todos as $todo): ?>
                        <div class="todo-item <?php echo $todo['status'] == 'completed' ? 'completed' : ''; ?>">
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="toggle">
                                <input type="hidden" name="todo_id" value="<?php echo $todo['id']; ?>">
                                <input type="hidden" name="status" value="<?php echo $todo['status']; ?>">
                                <input type="checkbox" class="todo-checkbox" <?php echo $todo['status'] == 'completed' ? 'checked' : ''; ?> 
                                       onchange="this.form.submit()">
                            </form>
                            
                            <?php if (isset($_POST['edit_id']) && $_POST['edit_id'] == $todo['id']): ?>
                                <form method="POST" class="edit-form">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="todo_id" value="<?php echo $todo['id']; ?>">
                                    <input type="text" name="task" value="<?php echo htmlspecialchars($todo['task']); ?>" required>
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-warning" onclick="location.reload()">Cancel</button>
                                </form>
                            <?php else: ?>
                                <div class="todo-text"><?php echo htmlspecialchars($todo['task']); ?></div>
                                <div class="todo-actions">
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="edit_id" value="<?php echo $todo['id']; ?>">
                                        <button type="submit" class="btn btn-warning">Edit</button>
                                    </form>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('Delete this task?')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="todo_id" value="<?php echo $todo['id']; ?>">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        </div>
    </div>
</body>

</html>