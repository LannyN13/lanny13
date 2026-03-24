<?php
session_start();
include("../config1/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') die("Access denied");

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM students WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: dashboard.php");
