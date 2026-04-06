<?php
include "protect.php";
include "connect.php";

$sql = "SELECT id, nume, telefon, data, ora, mesaj FROM rezervari ORDER BY id DESC";
$result = $conn->query($sql);
?>

<div style="text-align:right; margin-bottom:20px;">
  <a href="logout.php" class="btn">Logout</a>
</div>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Rezervări</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .admin-container {
      max-width: 1200px;
      margin: 40px auto;
      background: white;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    }

    .admin-container h1 {
      margin-bottom: 20px;
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table th, table td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: left;
      vertical-align: top;
    }

    table th {
      background: #111;
      color: white;
    }

    table tr:nth-child(even) {
      background: #f8f8f8;
    }

    .delete-btn {
  display: inline-block;
  padding: 8px 14px;
  background: #e74c3c;
  color: white;
  border-radius: 8px;
  text-decoration: none;
  font-weight: bold;
  transition: 0.3s;ł
}

.delete-btn:hover {
  background: #c0392b;
  transform: scale(1.05);
}
  </style>
</head>
<body>

<div class="admin-container">
  <h1>Rezervări primite</h1>

  <table>
    <tr>
      <th>ID</th>
      <th>Nume</th>
      <th>Telefon</th>
      <th>Data</th>
      <th>Ora</th>
      <th>Mesaj</th>
      <th>Acțiune</th>
    </tr>

    <?php if ($result && $result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo htmlspecialchars($row['id']); ?></td>
          <td><?php echo htmlspecialchars($row['nume']); ?></td>
          <td><?php echo htmlspecialchars($row['telefon']); ?></td>

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

          <td><?php echo htmlspecialchars($row['mesaj']); ?></td>
          <td>
            <a class="delete-btn"
               href="delete.php?id=<?php echo $row['id']; ?>"
               onclick="return confirm('Sigur vrei să ștergi această rezervare?')">
               Șterge
            </a>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr>
        <td colspan="7">Nu există rezervări încă.</td>
      </tr>
    <?php endif; ?>
  </table>
</div>

</body>
</html>

<?php
$conn->close();
?>