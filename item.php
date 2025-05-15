<?php
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/db.php';

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM items WHERE id = ? AND is_published = 1");
$stmt->execute([$id]);
$item = $stmt->fetch();

if (!$item) {
    header("Location: index.php");
    exit;
}
?>

<main>
    <section class="item-detail">
        <div class="item-detail-container">
            <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
            <div class="item-info">
                <h2><?= htmlspecialchars($item['name']) ?></h2>
                <p class="price"><?= htmlspecialchars($item['price']) ?></p>
                <p><?= htmlspecialchars($item['description']) ?></p>
                
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $item['user_id']): ?>
                    <div class="item-actions">
                        <a href="auth/edit-listing.php?id=<?= $item['id'] ?>" class="btn btn-edit">Edit</a>
                        <form action="auth/delete-listing.php" method="POST">
                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                            <button type="submit" class="btn btn-delete">Delete</button>
                        </form>
                    </div>
                <?php else: ?>
                    <button class="btn btn-primary">Contact Seller</button>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>