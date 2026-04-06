<?php
session_start();
include "connect.php";

if (!isset($_SESSION['user_id'])) {
    echo "Trebuie să fii logat!";
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM rezervari WHERE user_id = $user_id ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rezervările mele</title>
  <link rel="stylesheet" href="style.css">

  <style>
    .reservations-page {
      flex: 1;
      padding: 40px 20px 60px;
      background: linear-gradient(to right, #f8f6f3, #efebe5);
    }

    .title {
      text-align: center;
      margin-bottom: 30px;
      font-size: 40px;
      color: #111;
    }

    .table-container {
      max-width: 1100px;
      margin: 0 auto 40px auto;
      background: white;
      padding: 25px;
      border-radius: 18px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.12);
      overflow-x: auto;
    }

    .styled-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 17px;
    }

    .styled-table thead tr {
      background: #111;
      color: white;
    }

    .styled-table th,
    .styled-table td {
      padding: 14px 16px;
      text-align: left;
    }

    .styled-table tbody tr {
      border-bottom: 1px solid #eaeaea;
    }

    .styled-table tbody tr:nth-child(even) {
      background: #f9f9f9;
    }

    .styled-table tbody tr:hover {
      background: #f1ece4;
    }

    .delete-btn {
      color: red;
      font-weight: bold;
      text-decoration: none;
    }

    .delete-btn:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

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
  </nav>
</header>

<main class="reservations-page">
  <h2 class="title">Rezervările mele</h2>

  <div class="table-container">
    <table class="styled-table">
      <thead>
        <tr>
          <th>Nume</th>
          <th>Telefon</th>
          <th>Mesaj</th>
          <th>Data</th>
          <th>Ora</th>
          <th>Acțiune</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['nume']); ?></td>
              <td><?php echo htmlspecialchars($row['telefon']); ?></td>
              <td><?php echo htmlspecialchars($row['mesaj']); ?></td>
              <td>
<?php 
if (!empty($row['data'])) {
    $luni = [
        1 => "Ianuarie", 2 => "Februarie", 3 => "Martie",
        4 => "Aprilie", 5 => "Mai", 6 => "Iunie",
        7 => "Iulie", 8 => "August", 9 => "Septembrie",
        10 => "Octombrie", 11 => "Noiembrie", 12 => "Decembrie"
    ];

    $data_formatata = date_create($row['data']);
    $zi = date_format($data_formatata, "d");
    $luna = $luni[(int)date_format($data_formatata, "m")];
    $an = date_format($data_formatata, "Y");

    echo "$zi $luna $an";
} else {
    echo "-";
}
?>
</td>
              <td>
<?php 
if (!empty($row['ora'])) {
    echo date("H:i", strtotime($row['ora']));
} else {
    echo "-";
}
?>
</td>
              <td>
                <a href="delete_user.php?id=<?php echo $row['id']; ?>"
                   class="delete-btn"
                   onclick="return confirm('Sigur vrei să ștergi rezervarea?')">
                   Șterge
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="6">Nu ai rezervări încă.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</main>

<footer class="footer">
  <p>© 2026 Il Gusto Divino</p>
</footer>

</body>
</html>