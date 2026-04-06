<?php
session_start();
include "connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: /site-proiect/login_user.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nume = trim($_POST['nume'] ?? '');
    $telefon = trim($_POST['telefon'] ?? '');
    $data = trim($_POST['data'] ?? '');
    $ora = trim($_POST['ora'] ?? '');
    $mesaj = trim($_POST['mesaj'] ?? '');
    $user_id = $_SESSION['user_id'];

    if ($nume === '' || $telefon === '' || $data === '' || $ora === '' || $mesaj === '') {
        header("Location: /site-proiect/contact.php?status=gol");
        exit();
    }

    if (!preg_match('/^(\\+373|0)[0-9]{8}$/', $telefon)) {
        header("Location: /site-proiect/contact.php?status=telefon");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO rezervari (nume, telefon, data, ora, mesaj, user_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $nume, $telefon, $data, $ora, $mesaj, $user_id);

    if ($stmt->execute()) {
        header("Location: /site-proiect/contact.php?status=succes");
        exit();
    } else {
        header("Location: /site-proiect/contact.php?status=eroare");
        exit();
    }

    $stmt->close();
} else {
    echo "Acces invalid.";
}

$conn->close();
?>