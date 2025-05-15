<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

require '../includes/db.php';

// Fetch user's listings
$stmt = $pdo->prepare("SELECT * FROM items WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$listings = $stmt->fetchAll();

include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard - Student Marketplace</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <main class="dashboard-container">
        <h1>My Dashboard</h1>
        
        <div class="dashboard-actions">
            <a href="create-listing.php" class="btn btn-primary">Create New Listing</a>
        </div>
        
        <section class="my-listings">
            <h2>My Listings</h2>
            
            <?php if (empty($listings)): ?>
                <p>You haven't created any listings yet.</p>
            <?php else: ?>
                <div class="listings-grid">
                    <?php foreach ($listings as $listing): ?>
                        <div class="listing-card">
                            <img src="<?php echo htmlspecialchars($listing['image']); ?>" alt="<?php echo htmlspecialchars($listing['name']); ?>">
                            <div class="listing-info">
                                <h3><?php echo htmlspecialchars($listing['name']); ?></h3>
                                <p class="price"><?php echo htmlspecialchars($listing['price']); ?></p>
                                <p><?php echo htmlspecialchars($listing['description']); ?></p>
                                <div class="listing-actions">
                                    <a href="edit-listing.php?id=<?php echo $listing['id']; ?>" class="btn btn-edit">Edit</a>
                                    <form action="delete-listing.php" method="POST" class="delete-form">
                                        <input type="hidden" name="id" value="<?php echo $listing['id']; ?>">
                                        <button type="submit" class="btn btn-delete">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Student Marketplace. All rights reserved.</p>
    </footer>
</body>
</html>