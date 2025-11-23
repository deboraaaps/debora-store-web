<?php
session_start(); 

$host = "localhost";
$user = "root";
$pass = "";
$db   = "debora_store";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}
?>