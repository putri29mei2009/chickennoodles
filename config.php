<?php
session_start(); // Start the session for user management and cart

// Development error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$username = 'root';
$password = ''; // Usually empty for XAMPP/WAMP default root
$database = 'chicken_noodles';

// Establish database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error . " Pastikan database 'chicken_noodles' sudah dibuat dan server MySQL berjalan.");
}
?>