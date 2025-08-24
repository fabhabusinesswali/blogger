<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $image = '';

    // Image upload handling
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $filename = $_FILES['image']['name'];
        $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if(in_array($filetype, $allowed)) {
            // Create unique filename
            $new_filename = uniqid() . '.' . $filetype;
            $upload_path = 'uploads/' . $new_filename;
            
            if(move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                $image = $new_filename;
                
                // Set proper permissions
                chmod($upload_path, 0644);
                
                echo "<script>console.log('Image uploaded successfully: " . $upload_path . "');</script>";
            } else {
                echo "<script>console.log('Failed to move uploaded file');</script>";
            }
        } else {
            echo "<script>alert('Invalid file type. Allowed types: jpg, jpeg, png, gif, webp');</script>";
        }
    }

    $sql = "INSERT INTO blogs (title, content, image) VALUES ('$title', '$content', '$image')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Blog added successfully!');
            window.location.href = 'dashboard.php';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?> 
