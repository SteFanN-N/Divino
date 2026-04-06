<?php session_start(); 
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'ro';
}
include 'languages/' . $_SESSION['lang'] . '.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Il Gusto Divino | <?php echo $lang['home']; ?></title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
  <div class="logo">🍽️ Il Gusto Divino</div>
  <nav class="nav">
  <a href="index.php"><?php echo $lang['home']; ?></a>
  <a href="menu.php"><?php echo $lang['menu']; ?></a>
  <a href="about.php"><?php echo $lang['about']; ?></a>
  <a href="contact.php"><?php echo $lang['contact']; ?></a>

  <?php if(isset($_SESSION['user'])): ?>
    <a href="rezervarile_mele.php">Rezervările mele</a>
    <a href="logout_user.php"><?php echo $lang['logout']; ?> (<?php echo $_SESSION['user']; ?>)</a>
  <?php else: ?>
    <a href="login_user.php"><?php echo $lang['login']; ?></a>
    <a href="register.php"><?php echo $lang['register']; ?></a>
  <?php endif; ?>

  <div class="lang-buttons">
    <form method="post" action="change_lang.php">
      <button type="submit" name="lang" value="ro" class="lang-btn <?php echo $_SESSION['lang']=='ro' ? 'active' : ''; ?>">RO</button>
      <button type="submit" name="lang" value="en" class="lang-btn <?php echo $_SESSION['lang']=='en' ? 'active' : ''; ?>">EN</button>
      <button type="submit" name="lang" value="ru" class="lang-btn <?php echo $_SESSION['lang']=='ru' ? 'active' : ''; ?>">RU</button>
    </form>
  </div>
</nav>
</header>

<section class="hero">
  <h1><?php echo $lang['hero_title']; ?></h1>
  <p><?php echo $lang['hero_text']; ?></p>
  <a class="btn" href="contact.php"><?php echo $lang['reserve_table']; ?></a>
</section>

<footer class="footer">
  <p><?php echo $lang['footer_text']; ?></p>
</footer>

</body>
</html>
