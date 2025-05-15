<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require '../includes/db.php';

// Get listing ID from URL
$id = $_GET['id'] ?? 0;

// Fetch the listing
$stmt = $pdo->prepare("SELECT * FROM items WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$listing = $stmt->fetch();

// If listing doesn't exist or doesn't belong to user, redirect
if (!$listing) {
    header("Location: dashboard.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    
    // Basic validation
    if (empty($name) || empty($description) || empty($price)) {
        $error = 'Please fill in all fields';
    } else {
        $stmt = $pdo->prepare("UPDATE items SET name = ?, description = ?, price = ? WHERE id = ? AND user_id = ?");
        try {
            $stmt->execute([$name, $description, $price, $id, $_SESSION['user_id']]);
            header("Location: dashboard.php");
            exit;
        } catch (PDOException $e) {
            $error = "Error updating listing: " . $e->getMessage();
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
    <title>Edit Listing - Student Marketplace</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <main class="form-container">
        <h1>Edit Listing</h1>
        
        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="name">Item Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($listing['name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($listing['description']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($listing['price']); ?>" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Update Listing</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </main>

    <footer>
        <p>&copy; 2025 Student Marketplace. All rights reserved.</p>
    </footer>
</body>
</html>