<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - My Blogger</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .header {
            background: linear-gradient(135deg, #6366f1, #a855f7);
            padding: 20px;
            color: white;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .nav-bar {
            background: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .nav-bar a {
            color: #6366f1;
            text-decoration: none;
            font-weight: 600;
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .nav-bar a:hover {
            background: #6366f1;
            color: white;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .add-blog-form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #1f2937;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-group textarea {
            height: 200px;
            resize: vertical;
        }

        .submit-btn {
            background: #6366f1;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s ease;
        }

        .submit-btn:hover {
            background: #4f46e5;
        }

        .blogs-list {
            display: grid;
            gap: 20px;
        }

        .blog-item {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .blog-actions {
            display: flex;
            gap: 10px;
        }

        .edit-btn, .delete-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .edit-btn {
            background: #10b981;
            color: white;
        }

        .delete-btn {
            background: #ef4444;
            color: white;
        }

        .edit-btn:hover {
            background: #059669;
        }

        .delete-btn:hover {
            background: #dc2626;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Dashboard</h1>
    </header>

    <nav class="nav-bar">
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
    </nav>

    <div class="dashboard-container">
        <form class="add-blog-form" action="add_blog.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Blog Title</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">Blog Content</label>
                <textarea id="content" name="content" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Blog Image (jpg, jpeg, png, gif, webp)</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <button type="submit" class="submit-btn">Add Blog</button>
        </form>

        <div class="blogs-list">
            <?php
                include 'config.php';
                
                $sql = "SELECT * FROM blogs ORDER BY created_at DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="blog-item">';
                        echo '<h3>'.$row['title'].'</h3>';
                        echo '<div class="blog-actions">';
                        echo '<button class="edit-btn" onclick="editBlog('.$row['id'].')">Edit</button>';
                        echo '<button class="delete-btn" onclick="deleteBlog('.$row['id'].')">Delete</button>';
                        echo '</div></div>';
                    }
                } else {
                    echo "<p>No blogs found</p>";
                }
            ?>
        </div>
    </div>

    <script>
        // JavaScript for smooth transitions and actions
        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                document.body.style.opacity = 0;
                setTimeout(() => {
                    window.location.href = href;
                }, 500);
            });
        });

        function editBlog(id) {
            window.location.href = `edit_blog.php?id=${id}`;
        }

        function deleteBlog(id) {
            if(confirm('Are you sure you want to delete this blog?')) {
                window.location.href = `delete_blog.php?id=${id}`;
            }
        }
    </script>
</body>
</html> 
