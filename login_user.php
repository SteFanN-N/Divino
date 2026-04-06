<?php
session_start();
include "connect.php";

$eroare = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['user'] ?? '');
    $parola = trim($_POST['parola'] ?? '');

    $stmt = $conn->prepare("SELECT * FROM utilizatori WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $user, $user);
    $stmt->execute();

    $result = $stmt->get_result();
    $user_db = $result->fetch_assoc();

    if ($user_db && password_verify($parola, $user_db['parola'])) {
        $_SESSION['user'] = $user_db['username'];
        $_SESSION['user_id'] = $user_db['id'];
        header("Location: index.php");
        exit();
    } else {
        $eroare = "Date greșite!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
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

    .login-container input:focus {
      outline: none;
      border-color: orange;
    }

    .msg-error {
      color: red;
      font-weight: bold;
      margin-bottom: 15px;
    }

    .login-container a {
      display: block;
      margin-top: 15px;
      color: #555;
      text-decoration: none;
    }

    .login-container a:hover {
      color: orange;
    }

    .password-box {
      position: relative;
      width: 100%;
      margin-bottom: 15px;
    }

    .password-box input {
      width: 100%;
      padding: 14px;
      padding-right: 50px;
      margin-bottom: 0;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 16px;
      box-sizing: border-box;
    }

    .toggle-password {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 18px;
      user-select: none;
    }
  </style>
</head>
<body>

<div class="login-container">
  <h2>Autentificare</h2>

  <?php if (!empty($eroare)): ?>
    <p class="msg-error"><?php echo $eroare; ?></p>
  <?php endif; ?>

  <form method="POST">
    <input type="text" name="user" placeholder="Username sau Email" required>

    <div class="password-box">
      <input type="password" name="parola" id="loginParola" placeholder="Parola" required>
      <span class="toggle-password" onclick="togglePassword('loginParola', this)">👁️</span>
    </div>

    <button type="submit" class="btn">Login</button>
  </form>

  <a href="register.php">Nu ai cont? Creează unul</a>
</div>

<script>
function togglePassword(inputId, element) {
  const input = document.getElementById(inputId);

  if (input.type === "password") {
    input.type = "text";
    element.textContent = "🙈";
  } else {
    input.type = "password";
    element.textContent = "👁️";
  }
}
</script>

</body>
</html>