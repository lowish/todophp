# To Do List Application

A simple and modern to-do list application built with PHP, MySQL, and modern CSS.

## Features

- **Clean Homepage**: Centered "To Do List" title with a login button
- **User Authentication**: Secure login system with user registration
- **Task Management**: Add, edit, delete, and mark tasks as complete
- **Responsive Design**: Works on desktop and mobile devices
- **Session Management**: Secure user sessions with logout functionality

## Setup Instructions

### 1. Database Setup
First, run the database setup script to create the necessary tables:
```
http://localhost/PHP/setup_database.php
```

This will create:
- `users_db` database
- `users` table for user authentication
- `todos` table for storing tasks

### 2. Create Test User
Create a test user to login to the application:
```
http://localhost/PHP/create_test_user.php
```

**Default Test Credentials:**
- Username: `testuser`
- Password: `test123`

### 3. Access the Application
- **Homepage**: `http://localhost/PHP/index.php`
- **Login**: `http://localhost/PHP/login.php`
- **To-Do Dashboard**: `http://localhost/PHP/todo.php` (after login)

## How to Use

### First Page (Homepage)
- Displays "To Do List" in the center
- Has "Log In" and "Create Account" buttons at the bottom
- Clean, modern design with gradient background

### Login Page
- Enter email and password
- Link to registration page for new users
- Redirects to to-do list after successful login

### Registration Page
- Create new account with: full name, username, email, password, and password confirmation
- Password requirements and validation
- Redirects to login page after successful registration

### To-Do List Dashboard
- **Add Tasks**: Use the input field at the top
- **Mark Complete**: Click the checkbox to toggle task status
- **Edit Tasks**: Click the "Edit" button to modify task text
- **Delete Tasks**: Click the "Delete" button to remove tasks
- **Logout**: Click "Log Out" button in the top-right corner

## File Structure

- `index.php` - Homepage with "To Do List" title, login and registration buttons
- `login.php` - User login page
- `register.php` - User registration page
- `todo.php` - Main to-do list dashboard (requires login)
- `config/database.php` - Database connection configuration
- `setup_database.php` - Database and tables setup script
- `create_test_user.php` - Creates a test user for login

## Security Features

- Password hashing using PHP's built-in `password_hash()`
- SQL injection prevention with prepared statements
- Session-based authentication
- User-specific task isolation (users can only see their own tasks)
- CSRF protection through form tokens

## Database Schema

### Users Table
- `id` - Primary key
- `username` - Unique username
- `email` - Unique email address
- `password` - Hashed password
- `full_name` - User's full name
- `created_at` - Account creation timestamp
- `updated_at` - Last update timestamp

### Todos Table
- `id` - Primary key
- `user_id` - Foreign key to users table
- `task` - Task description text
- `status` - Task status (pending/completed)
- `created_at` - Task creation timestamp
- `updated_at` - Last update timestamp

## Requirements

- XAMPP (Apache + MySQL + PHP)
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Modern web browser

## Troubleshooting

1. **Database Connection Error**: Make sure XAMPP is running and MySQL service is started
2. **Table Not Found**: Run `setup_database.php` first
3. **Login Issues**: Create a test user using `create_test_user.php`
4. **Permission Errors**: Ensure proper file permissions and XAMPP configuration

## Customization

The application uses modern CSS with:
- Gradient backgrounds
- Glassmorphism effects
- Responsive design
- Hover animations
- Modern color scheme

You can customize the appearance by modifying the CSS in each PHP file.
