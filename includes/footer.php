    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to confirm task deletion
        function confirmDelete(taskId) {
            if (confirm('Are you sure you want to delete this task?')) {
                window.location.href = 'delete_task.php?id=' + taskId;
            }
        }
    </script>
</body>
</html> 