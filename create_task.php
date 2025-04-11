<?php
require_once "includes/config.php";
require_once "includes/header.php";

// Check if user is logged in
if(!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit;
}

$title = $description = $due_date = "";
$title_err = $description_err = $due_date_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate title
    if(empty(trim($_POST["title"]))) {
        $title_err = "Please enter a title.";
    } else {
        $title = trim($_POST["title"]);
    }
    
    // Validate description
    if(empty(trim($_POST["description"]))) {
        $description_err = "Please enter a description.";
    } else {
        $description = trim($_POST["description"]);
    }
    
    // Validate due date
    if(empty(trim($_POST["due_date"]))) {
        $due_date_err = "Please enter a due date.";
    } else {
        $due_date = trim($_POST["due_date"]);
    }
    
    // Check input errors before inserting in database
    if(empty($title_err) && empty($description_err) && empty($due_date_err)) {
        $sql = "INSERT INTO tasks (user_id, title, description, due_date) VALUES (?, ?, ?, ?)";
        
        if($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "isss", $param_user_id, $param_title, $param_description, $param_due_date);
            
            $param_user_id = $_SESSION["user_id"];
            $param_title = $title;
            $param_description = $description;
            $param_due_date = $due_date;
            
            if(mysqli_stmt_execute($stmt)) {
                header("location: dashboard.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    mysqli_close($conn);
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">Create New Task</h3>
            </div>
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                        <span class="invalid-feedback"><?php echo $title_err; ?></span>
                    </div>
                    <div class="form-group mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>"><?php echo $description; ?></textarea>
                        <span class="invalid-feedback"><?php echo $description_err; ?></span>
                    </div>
                    <div class="form-group mb-3">
                        <label>Due Date</label>
                        <input type="date" name="due_date" class="form-control <?php echo (!empty($due_date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $due_date; ?>">
                        <span class="invalid-feedback"><?php echo $due_date_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Create Task">
                        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once "includes/footer.php"; ?>