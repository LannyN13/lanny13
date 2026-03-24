<?php
session_start();
include("../config1/db.php");

if (!isset($_SESSION['user_id'])) header("Location: ../auth1/login.php");

$id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM students WHERE id=$id")->fetch_assoc();
$result = $conn->query("SELECT * FROM grades WHERE student_id=$id");
?>

<!DOCTYPE html>
<html>

<head>
    <title>SMS - My Grades</title>
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

        .grades-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .grades-card h2 {
            color: #667eea;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
        }

        th {
            background: #667eea;
            color: white;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background: #f9f9f9;
        }

        .no-grades {
            text-align: center;
            color: #999;
            padding: 40px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <span class="navbar-brand">📚 Student Management System</span>
            <div class="ms-auto">
                <a href="home.php" class="btn btn-outline-light btn-sm me-2">Back to Dashboard</a>
                <a href="../auth1/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="grades-card">
            <h2>📊 My Grades</h2>

            <?php if ($result->num_rows > 0): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['subject']); ?></td>
                                <td><strong><?= htmlspecialchars($row['grade']); ?></strong></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-grades">No grades available yet.</div>
            <?php endif; ?>

            <a href="home.php" class="btn btn-primary mt-3">Back to Dashboard</a>
        </div>
    </div>
</body>

</html>