<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

require '../includes/db.php';

$id = $_GET['id'] ?? 0;

// Confirm ownership and delete
$stmt = $pdo->prepare("DELETE FROM items WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);

// Redirect back to dashboard
header("Location: dashboard.php");
exit;
