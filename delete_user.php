<?php
session_start();
include "connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit();
}

if (isset($_GET['id'])) {

    $id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];

    // șterge DOAR dacă rezervarea aparține userului
    $stmt = $conn->prepare("DELETE FROM rezervari WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);

    $stmt->execute();
    $stmt->close();
}

header("Location: /site-proiect/rezervarile_mele.php");
exit();
?>