<?php
session_start();

$isLoggedIn = isset($_SESSION['user_id']); // true if user is logged in
$username = $_SESSION['username'] ?? 'User'; // fallback if username isn't set
?>

<link rel="stylesheet" href="/css/style.css"> <!-- Optional: Your CSS -->

<header class="header">
    <div class="logo">
        Student Marketplace - Brighton
    </div>
    <nav class="nav-links">
        <a href="/studentstore/index.php">Home</a>
        <a href="/studentstore/item-listing.php">Browse</a>

        <?php if ($isLoggedIn): ?>
            <div class="user-menu" id="userMenu">
                <button id="userMenuButton"><?php echo htmlspecialchars($username); ?> ▼</button>
                <div class="user-dropdown" id="userDropdown">
                    <a href="auth/logout.php">Logout</a>
                </div>
            </div>
        <?php else: ?>
            <a href="/studentstore/auth/login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>

<style>
    /* Header layout */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 30px;
        background-color: #fff;
        border-bottom: 1px solid #ddd;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .logo {
        font-size: 1.5em;
        font-weight: bold;
        color: #3366ff;
    }

    .nav-links {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .nav-links a {
        text-decoration: none;
        color: #444;
        font-weight: 500;
    }

    .user-menu {
        position: relative;
    }

    .user-menu button {
        background: none;
        border: none;
        font-weight: bold;
        color: #3366ff;
        cursor: pointer;
    }

    .user-dropdown {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        background-color: white;
        border: 1px solid #ccc;
        min-width: 120px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        z-index: 100;
    }

    .user-dropdown a {
        display: block;
        padding: 10px;
        color: #444;
        text-decoration: none;
    }

    .user-dropdown a:hover {
        background-color: #f2f2f2;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const menuBtn = document.getElementById("userMenuButton");
        const dropdown = document.getElementById("userDropdown");

        if (menuBtn) {
            menuBtn.addEventListener("click", function (e) {
                e.stopPropagation();
                dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
            });

            document.addEventListener("click", function () {
                dropdown.style.display = "none";
            });
        }
    });
</script>