<?php
session_start();

require '../includes/db.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
  header("Location: ../index.php");
  exit;
}

$error = '';
$success = isset($_GET['success']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = $_POST['password'];

  $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->execute([$username]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password_hash'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    header("Location: ../index.php");
    exit;
  } else {
    $error = "Invalid username or password.";
  }
}
?>

<?php include '../includes/header.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Student Marketplace</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>

  <main>
    <section class="auth-form">
      <h2>Welcome Back</h2>
      <form method="POST">
        <div class="form-input">
          <label for="username">Username</label>
          <input type="username" id="username" name="username" required>
        </div>

        <div class="form-input">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </div>

        <button class="btn btn-primary" type="submit">Login</button>
      </form>
      <?php if ($success)
        echo "<p style='color:green;'>Registration successful. Please log in.</p>"; ?>
      <?php if (!empty($error))
        echo "<p style='color:red;'>$error</p>"; ?>
      <p class="text-center">Don't have an account? <a href="register.php">Register here</a></p>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 Student Marketplace. All rights reserved.</p>
  </footer>
</body>

</html>