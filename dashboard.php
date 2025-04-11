<?php
require_once "includes/config.php";
require_once "includes/header.php";

// Check if user is logged in
if(!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit;
}

// Pagination
$records_per_page = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Get total number of tasks
$total_tasks_sql = "SELECT COUNT(*) as total FROM tasks WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $total_tasks_sql);
mysqli_stmt_bind_param($stmt, "i", $_SESSION["user_id"]);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$total_tasks = mysqli_fetch_assoc($result)['total'];
$total_pages = ceil($total_tasks / $records_per_page);

// Get tasks for current page
$sql = "SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "iii", $_SESSION["user_id"], $records_per_page, $offset);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Your Tasks</h2>
            <a href="create_task.php" class="btn btn-primary">Create New Task</a>
        </div>
        
        <?php if(mysqli_num_rows($result) > 0): ?>
            <?php while($task = mysqli_fetch_assoc($result)): ?>
                <div class="card task-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title"><?php echo htmlspecialchars($task['title']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($task['description']); ?></p>
                                <p class="card-text"><small class="text-muted">Due: <?php echo date('F j, Y', strtotime($task['due_date'])); ?></small></p>
                                <span class="badge bg-<?php echo $task['status'] == 'completed' ? 'success' : ($task['status'] == 'in_progress' ? 'warning' : 'secondary'); ?>">
                                    <?php echo ucfirst(str_replace('_', ' ', $task['status'])); ?>
                                </span>
                            </div>
                            <div>
                                <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <button onclick="confirmDelete(<?php echo $task['id']; ?>)" class="btn btn-sm btn-outline-danger">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            
            <!-- Pagination -->
            <?php if($total_pages > 1): ?>
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php if($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php for($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>
            
        <?php else: ?>
            <div class="alert alert-info">
                You don't have any tasks yet. <a href="create_task.php">Create your first task</a>!
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once "includes/footer.php"; ?>