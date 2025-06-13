<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database_name = "tubes_pw2025";

$conn = mysqli_connect($hostname, $username, $password, $database_name);

if ($conn->connect_error) {
    echo "koneksi database gagal!";
    die("error!");
}