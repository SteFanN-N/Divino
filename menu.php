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
  <title>Il Gusto Divino | <?php echo $lang['menu']; ?></title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="menu-page">

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
    <a id="cartLink" href="cart.php" class="cart-link"><?php echo $lang['cart']; ?> <span id="cartCount">0</span></a>

    <div class="lang-buttons">
      <form method="post" action="change_lang.php">
        <button type="submit" name="lang" value="ro" class="lang-btn <?php echo $_SESSION['lang']=='ro' ? 'active' : ''; ?>">RO</button>
        <button type="submit" name="lang" value="en" class="lang-btn <?php echo $_SESSION['lang']=='en' ? 'active' : ''; ?>">EN</button>
        <button type="submit" name="lang" value="ru" class="lang-btn <?php echo $_SESSION['lang']=='ru' ? 'active' : ''; ?>">RU</button>
      </form>
    </div>
  </nav>
</header>

<section class="section">
  <h2><?php echo $lang['our_menu']; ?></h2>

  <?php
    $cacheBuster = time();

    $menuItems = $lang['menu_items'];

    $carouselItems = array_slice($menuItems, 0, 2);
    $allMenuItems = $menuItems;
  ?>

  <div class="food-slider" id="foodSlider">
    <div class="slides-track" id="slidesTrack">
      <?php foreach ($carouselItems as $item): ?>
        <div class="slide">
          <img src="<?= htmlspecialchars($item['image']) ?>?v=<?= $cacheBuster ?>" alt="<?= htmlspecialchars($item['title']) ?>" onerror="this.onerror=null; this.src='https://via.placeholder.com/600x400?text=Imagine+nevalid%C4%83'; this.closest('.slide').classList.add('slide-error');">
        </div>
      <?php endforeach; ?>
    </div>

    <button id="prevSlide" class="slider-btn prev">‹</button>
    <button id="nextSlide" class="slider-btn next">›</button>
  </div>

  <script>
    window.foodSlides = [
      <?php foreach ($carouselItems as $item): ?>
        {
          image: "<?= htmlspecialchars($item['image']) ?>?v=<?= $cacheBuster ?>",
          title: "<?= htmlspecialchars($item['title']) ?>",
          short: "<?= htmlspecialchars($item['short']) ?>",
          price: "<?= $item['price'] ?>"
        },
      <?php endforeach; ?>
    ];
    console.log('Slider slides set:', window.foodSlides);
  </script>

  <div class="cards">
    <?php foreach ($allMenuItems as $item): ?>
      <div class="card menu-card"
           data-title="<?= htmlspecialchars($item['title']) ?>"
           data-short="<?= htmlspecialchars($item['short']) ?>"
           data-desc="<?= htmlspecialchars($item['description']) ?>"
           data-price="<?= $item['price'] ?>"
           data-image="<?= htmlspecialchars($item['image']) ?>"
           data-allergens="<?= htmlspecialchars($item['allergens']) ?>">
        <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" onerror="this.onerror=null;this.src='https://via.placeholder.com/400x280?text=Imagine+nevalidă'">
        <h3><?= htmlspecialchars($item['title']) ?></h3>
        <p><?= htmlspecialchars($item['short']) ?></p>
        <span><?= $item['price'] ?> lei</span>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<div id="menuModal" class="menu-modal">
  <div class="menu-modal-content">
    <button id="modalClose" class="modal-close">×</button>

    <div class="modal-left">
      <img id="modalImage" src="" alt="">
    </div>

    <div class="modal-right">
      <h2 id="modalTitle"></h2>
      <p id="modalShort" class="modal-subtitle"></p>
      <p id="modalDescription" class="modal-description"></p>
      <p id="modalAllergens" class="modal-allergens"></p>

      <div class="modal-quantity">
        <button id="qtyMinus">-</button>
        <input id="qtyInput" type="number" min="1" value="1">
        <button id="qtyPlus">+</button>
      </div>

      <div class="modal-footer">
        <button id="addToCartBtn" class="add-cart-btn"><?php echo $lang['add_to_cart']; ?></button>
        <span id="modalPrice" class="modal-price"></span>
      </div>

      <p id="cartStatus" class="cart-status"></p>
    </div>
  </div>
</div>

<div id="toast" class="toast"></div>

<footer class="footer">
  <p><?php echo $lang['footer_text']; ?></p>
</footer>

<script src="script.js"></script>
</body>
</html>