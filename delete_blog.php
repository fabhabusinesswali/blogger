<?php
include 'config.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Get image name before deleting
    $sql = "SELECT image FROM blogs WHERE id = $id";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if($row['image']) {
            unlink('uploads/' . $row['image']);
        }
    }

    $sql = "DELETE FROM blogs WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Blog deleted successfully!');
            window.location.href = 'dashboard.php';
        </script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?> 
