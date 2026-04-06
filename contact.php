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
  <title>Il Gusto Divino | <?php echo $lang['contact']; ?></title>
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

<section class="contact-page">
  <div class="contact-wrapper">

    <div class="contact-info">
      <p class="contact-small-title"><?php echo $lang['reservations_contact']; ?></p>
      <h2><?php echo $lang['get_in_touch']; ?></h2>
      <p class="contact-description"><?php echo $lang['contact_description']; ?></p>

      <div class="contact-details">
        <p><span>📍</span> <?php echo $lang['address']; ?></p>
        <p><span>📞</span> <?php echo $lang['phone']; ?></p>
        <p><span>🕒</span> <?php echo $lang['hours']; ?></p>
      </div>

      <form action="rezervare.php" method="POST" class="form" id="reservationForm">
        <input type="text" name="nume" placeholder="<?php echo $lang['name_placeholder']; ?>" required>
        <input type="text" name="telefon" placeholder="<?php echo $lang['phone_placeholder']; ?>" required>
        <input type="date" name="data" id="data" required>
        <input type="time" name="ora" id="ora" min="10:00" max="22:00" required>
        <textarea name="mesaj" placeholder="<?php echo $lang['message_placeholder']; ?>" required></textarea>
        <button type="submit" class="btn"><?php echo $lang['send']; ?></button>
      </form>

      <p id="msg"></p>
    </div>

    <div class="contact-image">
      <img src="https://images.unsplash.com/photo-1552566626-52f8b828add9?auto=format&fit=crop&w=1000&q=80" alt="Restaurant elegant">
    </div>

  </div>
</section>

<div class="popup" id="popup">
  <div class="popup-box">
    <p id="popup-text"><?php echo $lang['reservation_success']; ?></p>
    <button id="closePopup" class="btn">OK</button>
  </div>
</div>

<footer class="footer">
  <p><?php echo $lang['footer_text']; ?></p>
</footer>

<script src="script.js"></script>

</body>
</html>