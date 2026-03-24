<?php
session_start();
include("../config1/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') die("Access denied");

$search = $_GET['search'] ?? '';

$search = "%" . $conn->real_escape_string($search) . "%";
$stmt = $conn->prepare("SELECT * FROM students WHERE name LIKE ? OR email LIKE ?");
$stmt->bind_param("ss", $search, $search);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
        <title>SMS - Admin Dashboard</title>
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

                .admin-panel {
                        background: white;
                        border-radius: 10px;
                        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                        padding: 30px;
                        margin-top: 30px;
                }

                .search-box {
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

                .btn {
                        border-radius: 5px;
                        padding: 8px 15px;
                        font-weight: 600;
                        font-size: 14px;
                }

                .btn-delete {
                        background-color: #dc3545;
                        color: white;
                }

                .btn-delete:hover {
                        background-color: #c82333;
                        color: white;
                }
        </style>
</head>

<body>
        <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container">
                        <span class="navbar-brand">📚 Student Management System - Admin Panel</span>
                        <div class="ms-auto">
                                <a href="add_grade.php" class="btn btn-outline-light btn-sm me-2">Add Grade</a>
                                <a href="../auth1/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
                        </div>
                </div>
        </nav>

        <div class="container">
                <div class="admin-panel">
                        <h2 style="color: #667eea; margin-bottom: 30px;">👥 Manage Students</h2>

                        <div class="search-box">
                                <form method="GET" class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="<?= htmlspecialchars($search ?? ''); ?>">
                                        <button class="btn btn-primary" type="submit">Search</button>
                                </form>
                        </div>

                        <?php if ($result->num_rows > 0): ?>
                                <div class="table-responsive">
                                        <table class="table">
                                                <thead>
                                                        <tr>
                                                                <th>Name</th>
                                                                <th>Email</th>
                                                                <th>Course</th>
                                                                <th>Role</th>
                                                                <th>Action</th>
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                        <?php while ($row = $result->fetch_assoc()): ?>
                                                                <tr>
                                                                        <td><?= htmlspecialchars($row['name']); ?></td>
                                                                        <td><?= htmlspecialchars($row['email']); ?></td>
                                                                        <td><?= htmlspecialchars($row['course']); ?></td>
                                                                        <td><span class="badge bg-info"><?= htmlspecialchars($row['role']); ?></span></td>
                                                                        <td>
                                                                                <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-delete btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                                                        </td>
                                                                </tr>
                                                        <?php endwhile; ?>
                                                </tbody>
                                        </table>
                                </div>
                        <?php else: ?>
                                <div style="text-align: center; padding: 40px; color: #999;">
                                        No students found.
                                </div>
                        <?php endif; ?>
                </div>
        </div>
</body>

</html>