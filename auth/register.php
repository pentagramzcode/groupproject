<?php
session_start();

require '../includes/db.php';

// Redirect logged-in users
if (isset($_SESSION['user_id'])) {
  header("Location: ../index.html");
  exit;
}

// Form processing
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = $_POST['password'];
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  $stmt = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");

  try {
    $stmt->execute([$username, $hashedPassword]);
    header("Location: login.php?success=1");
    exit;
  } catch (PDOException $e) {
    $error = "Username may already be taken.";
  }
}
?>

<?php include '../includes/header.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Student Marketplace</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <main>
    <section class="auth-form">
      <h2>Create Account</h2>
      <form method="POST">
        <div class="form-input">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required>
        </div>

        <div class="form-input">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </div>

        <div class="form-input">
          <label for="confirm-password">Confirm Password</label>
          <input type="password" id="confirm-password" name="confirm-password" required>
        </div>

        <button class="btn btn-primary" type="submit">Register</button>
      </form>
      <?php if (!empty($error))
        echo "<p style='color:red;'>$error</p>"; ?>
      <p class="text-center">Already have an account? <a href="login.php">Login here</a></p>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 Student Marketplace. All rights reserved.</p>
  </footer>
</body>

</html>