<?php
session_start();

$eroare = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $admin_user = "admin";
    $admin_pass = "1234";

    if ($username === $admin_user && $password === $admin_pass) {
        $_SESSION['admin'] = $username;
        header("Location: admin.php");
        exit();
    } else {
        $eroare = "Utilizator sau parolă greșită!";
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .login-container {
      max-width: 420px;
      margin: 80px auto;
      background: white;
      padding: 35px;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.12);
      text-align: center;
    }

    .login-container h2 {
      margin-bottom: 20px;
      color: #111;
    }

    .login-container input {
      width: 100%;
      padding: 14px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 16px;
    }

    .error {
      color: red;
      margin-bottom: 15px;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="login-container">
  <h2>Login Admin</h2>

  <?php if (!empty($eroare)): ?>
    <p class="error"><?php echo $eroare; ?></p>
  <?php endif; ?>

  <form method="POST" action="">
    <input type="text" name="username" placeholder="Utilizator" required>
    <input type="password" name="password" placeholder="Parolă" required>
    <button type="submit" class="btn">Conectare</button>
  </form>
</div>

</body>
</html>