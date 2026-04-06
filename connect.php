<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "il_gusto_divino";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}
?>
