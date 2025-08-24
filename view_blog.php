<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Blog - My Blogger</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f3f4f6;
            opacity: 0;
            animation: fadeIn 0.5s ease-in forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .header {
            background: linear-gradient(135deg, #6366f1, #a855f7);
            padding: 20px;
            color: white;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            to { left: 100%; }
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
            position: relative;
            overflow: hidden;
        }

        .nav-bar a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: #6366f1;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .nav-bar a:hover::after {
            transform: scaleX(1);
        }

        .blog-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transform: translateY(20px);
            animation: slideUp 0.5s ease forwards 0.3s;
        }

        @keyframes slideUp {
            to { transform: translateY(0); }
        }

        .blog-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transform: scale(0.98);
            transition: transform 0.3s ease;
        }

        .blog-image:hover {
            transform: scale(1);
        }

        .blog-title {
            color: #1f2937;
            font-size: 2.5rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .blog-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: #6366f1;
            border-radius: 3px;
        }

        .blog-content {
            color: #4b5563;
            line-height: 1.8;
            font-size: 1.1rem;
        }

        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background: #6366f1;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(99,102,241,0.3);
        }

        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(99,102,241,0.4);
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>My Blogger</h1>
    </header>

    <nav class="nav-bar">
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
    </nav>

    <div class="blog-container">
        <?php
        include 'config.php';
        
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM blogs WHERE id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if($row['image']) {
                    echo '<img src="uploads/'.$row['image'].'" class="blog-image" alt="Blog Image">';
                }
                echo '<h1 class="blog-title">'.$row['title'].'</h1>';
                echo '<div class="blog-content">'.nl2br($row['content']).'</div>';
            } else {
                echo "<p>Blog not found</p>";
            }
        }
        ?>
        <a href="index.php" class="back-btn">Back to Home</a>
    </div>

    <script>
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
    </script>
</body>
</html> 
