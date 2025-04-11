# Task Management System

A web-based task management system built with PHP and MySQL.

## Features

- User authentication (login/register)
- Create, read, update, and delete tasks
- Task status tracking (pending, in progress, completed)
- Responsive design with Bootstrap
- Paginated task listing
- Secure database operations

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx) or PHP built-in server

## Installation

1. Clone the repository:
```bash
git clone https://github.com/vedantt-22/Task-Management-System.git
```

2. Create a MySQL database named `task_management`

3. Import the database schema:
```bash
mysql -u your_username -p task_management < database/schema.sql
```

4. Update database configuration in `includes/config.php`:
```php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'your_username');
define('DB_PASSWORD', 'your_password');
define('DB_NAME', 'task_management');
```

5. Start the development server:
```bash
php -S localhost:8000
```

6. Access the application at `http://localhost:8000`

## Usage

1. Register a new account or login with existing credentials
2. Create new tasks with title, description, and due date
3. View, edit, or delete tasks from the dashboard
4. Track task status and progress

## Security Features

- Prepared statements to prevent SQL injection
- Input validation
- Password hashing
- Session management
- CSRF protection

## License

This project is licensed under the MIT License - see the LICENSE file for details. 