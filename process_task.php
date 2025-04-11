<?php
require_once 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $due_date = $_POST['due_date'];
    
    // Validation
    if (empty($title) || empty($due_date)) {
        die('Title and due date are required');
    }
    
    try {
        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, description, due_date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $title, $description, $due_date]);
        header('Location: dashboard.php');
    } catch (PDOException $e) {
        die("Error creating task: " . $e->getMessage());
    }
}
?>