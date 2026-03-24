<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../auth1/login.php");
include("../config1/db.php");

$id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM students WHERE id=$id")->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
  <title>SMS - Student Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f5f7fa;
    }

    .navbar {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .navbar-brand {
      font-weight: bold;
      color: white !important;
    }

    .welcome-card {
      background: white;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      padding: 30px;
      margin-top: 30px;
      margin-bottom: 30px;
    }

    .welcome-card h2 {
      color: #667eea;
      margin-bottom: 10px;
    }

    .btn-group {
      gap: 10px;
      margin-top: 20px;
    }

    .btn {
      border-radius: 5px;
      padding: 10px 20px;
      font-weight: 600;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <span class="navbar-brand">📚 Student Management System</span>
      <div class="ms-auto">
        <span style="color: white; margin-right: 20px;">Welcome, <strong><?= htmlspecialchars($user['name']); ?></strong></span>
        <a href="../auth1/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="welcome-card">
      <h2>Welcome to Your Dashboard</h2>
      <p style="color: #666;">Manage your profile and view your grades</p>

      <div class="btn-group d-flex">
        <a href="profile.php" class="btn btn-primary">👤 My Profile</a>
        <a href="grade.php" class="btn btn-success">📊 My Grades</a>
      </div>
    </div>
  </div>
</body>

</html>