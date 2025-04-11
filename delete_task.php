<?php
require_once "includes/config.php";

// Check if user is logged in
if(!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit;
}

// Check if task ID is provided
if(!isset($_GET["id"]) || empty($_GET["id"])) {
    header("location: dashboard.php");
    exit;
}

// Prepare a delete statement
$sql = "DELETE FROM tasks WHERE id = ? AND user_id = ?";

if($stmt = mysqli_prepare($conn, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ii", $param_id, $param_user_id);
    
    // Set parameters
    $param_id = $_GET["id"];
    $param_user_id = $_SESSION["user_id"];
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)) {
        // Task deleted successfully
        header("location: dashboard.php");
        exit();
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
    
    // Close statement
    mysqli_stmt_close($stmt);
}

// Close connection
mysqli_close($conn);
?>