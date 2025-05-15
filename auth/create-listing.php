<?php
session_start();
require __DIR__ . '/../includes/db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $user_id = $_SESSION['user_id'];
    
    // Handle image upload
    $image = 'images/placeholder.jpg';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../images/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        $target_file = $upload_dir . $filename;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = 'images/uploads/' . $filename;
        }
    }

    // Basic validation
    if (empty($name) || empty($description) || empty($price)) {
        $error = 'Please fill in all fields';
    } else {
        $stmt = $pdo->prepare("INSERT INTO items (user_id, name, description, price, image, is_published) VALUES (?, ?, ?, ?, ?, 1)");
        try {
            $stmt->execute([$user_id, $name, $description, $price, $image]);
            header("Location: dashboard.php?success=1");
            exit;
        } catch (PDOException $e) {
            $error = "Error creating listing: " . $e->getMessage();
        }
    }
}

include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Listing - Student Marketplace</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <main class="form-container">
        <h1>Create New Listing</h1>
        
        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Item Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" id="price" name="price" required>
            </div>
            
            <div class="form-group">
                <label for="image">Image (optional)</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            
            <button type="submit" class="btn btn-primary">Create Listing</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </main>

    <footer>
        <p>&copy; 2025 Student Marketplace. All rights reserved.</p>
    </footer>
</body>
</html>
