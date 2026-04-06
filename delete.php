<?php
include "connect.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM rezervari WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Eroare la ștergere.";
    }

    $stmt->close();
} else {
    echo "ID invalid.";
}

$conn->close();
?>