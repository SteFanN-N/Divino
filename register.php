<?php
include "connect.php";

$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $parola_text = trim($_POST['parola'] ?? '');

    if ($username === '' || $email === '' || $parola_text === '') {
        $mesaj = "Completează toate câmpurile.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mesaj = "Email invalid.";
    } else {

        $stmt = $conn->prepare("SELECT id FROM utilizatori WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $mesaj = "Username sau email deja există.";
        } else {

            $parola = password_hash($parola_text, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO utilizatori (username, email, parola) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $parola);

            if ($stmt->execute()) {
                $mesaj = "Cont creat cu succes!";
            } else {
                $mesaj = "Eroare la înregistrare.";
            }
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
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

    .msg-success {
      color: green;
      font-weight: bold;
      margin-bottom: 15px;
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
  <h2>Creare cont</h2>

  <?php if (!empty($mesaj)): ?>
    <p class="<?php echo str_contains($mesaj, 'succes') ? 'msg-success' : 'msg-error'; ?>">
      <?php echo $mesaj; ?>
    </p>
  <?php endif; ?>

  <form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>

    <div class="password-box">
      <input type="password" name="parola" id="registerParola" placeholder="Parola" required>
      <span class="toggle-password" onclick="togglePassword('registerParola', this)">👁️</span>
    </div>

    <button type="submit" class="btn">Register</button>
  </form>

  <a href="login_user.php">Ai deja cont? Login</a>
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