<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blogger</title>
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
            padding: 30px;
            color: white;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            position: relative;
            overflow: hidden;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
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
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .blog-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            opacity: 0;
            animation: fadeUp 0.5s ease forwards;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .blog-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            object-position: center;
            transition: transform 0.3s ease;
        }

        .blog-image:hover {
            transform: scale(1.05);
        }

        .blog-content {
            padding: 20px;
        }

        .blog-title {
            color: #1f2937;
            font-size: 1.5rem;
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .blog-excerpt {
            color: #6b7280;
            margin-bottom: 15px;
            line-height: 1.6;
            font-size: 0.95rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .read-more {
            display: inline-block;
            padding: 8px 20px;
            background: #6366f1;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(99,102,241,0.3);
        }

        .read-more:hover {
            background: #4f46e5;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(99,102,241,0.4);
        }

        .no-blogs {
            grid-column: 1 / -1;
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            color: #6b7280;
            font-size: 1.1rem;
        }

        .date-info {
            font-size: 0.85rem;
            color: #6b7280;
            margin-bottom: 10px;
        }

        .form-group input[type="file"] {
            padding: 10px;
            border: 2px dashed #6366f1;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
        }

        .form-group input[type="file"]:hover {
            border-color: #4f46e5;
            background: #f3f4f6;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Welcome to My Blogger</h1>
    </header>
    
    <nav class="nav-bar">
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
    </nav>

    <div class="blog-container">
        <?php
            include 'config.php';
            
            $sql = "SELECT * FROM blogs ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $delay = 0;
                while($row = $result->fetch_assoc()) {
                    echo '<div class="blog-card" style="animation-delay: '.$delay.'s">';
                    if($row['image']) {
                        $image_path = 'uploads/' . $row['image'];
                        if(file_exists($image_path)) {
                            echo '<img src="'.$image_path.'" class="blog-image" alt="Blog Image" 
                                  onerror="this.src=\'default-image.jpg\'; this.onerror=null;">';
                        }
                    }
                    echo '<div class="blog-content">';
                    echo '<div class="date-info">'.date('F j, Y', strtotime($row['created_at'])).'</div>';
                    echo '<h2 class="blog-title">'.htmlspecialchars($row['title']).'</h2>';
                    echo '<p class="blog-excerpt">'.htmlspecialchars(substr(strip_tags($row['content']), 0, 150)).'...</p>';
                    echo '<a href="view_blog.php?id='.$row['id'].'" class="read-more">Read More</a>';
                    echo '</div></div>';
                    $delay += 0.1;
                }
            } else {
                echo '<div class="no-blogs">No blogs found. Be the first to create one!</div>';
            }
        ?>
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

        // Add animation to blog cards as they appear in viewport
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.blog-card').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>
</html> 
