<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Il Gusto Divino | Coș</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="menu-page">
<header class="header">
  <div class="logo">🍽️ Il Gusto Divino</div>
  <nav class="nav">
    <a href="index.php">Acasă</a>
    <a href="menu.php">Meniu</a>
    <a href="about.php">Despre</a>
    <a href="contact.php">Contact</a>
    <?php if(isset($_SESSION['user'])): ?>
      <a href="rezervarile_mele.php">Rezervările mele</a>
      <a href="logout_user.php">Logout (<?php echo $_SESSION['user']; ?>)</a>
    <?php else: ?>
      <a href="login_user.php">Login</a>
      <a href="register.php">Register</a>
    <?php endif; ?>
    <a id="cartLink" href="cart.php" class="cart-link">Coș <span id="cartCount">0</span></a>
  </nav>
</header>

<section class="cart-page" id="cartPage">
  <h2 class="cart-title">Coșul tău de cumpărături</h2>
  <div id="cartContent"></div>
</section>

<footer class="footer">
  <p>© 2026 Il Gusto Divino</p>
</footer>

<script src="script.js"></script>
</body>
</html>