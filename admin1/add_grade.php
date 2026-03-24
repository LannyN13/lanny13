<?php
session_start();
include("../config1/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') die("Access denied");

$message = "";

if (isset($_POST['add'])) {
    $student_id = $_POST['student_id'];
    $subject = $_POST['subject'];
    $grade = $_POST['grade'];

    if (empty($student_id) || empty($subject) || empty($grade)) {
        $message = "All fields are required!";
    } else {
        $stmt = $conn->prepare("INSERT INTO grades(student_id,subject,grade) VALUES(?,?,?)");
        $stmt->bind_param("iss", $student_id, $subject, $grade);
        if ($stmt->execute()) {
            $message = "Grade added successfully!";
        } else {
            $message = "Error adding grade. Invalid student ID?";
        }
    }
}

// Get list of students
$students = $conn->query("SELECT id, name FROM students WHERE role='student'");
?>

<!DOCTYPE html>
<html>

<head>
    <title>SMS - Add Grade</title>
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

        .form-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 30px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .form-card h2 {
            color: #667eea;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .btn {
            border-radius: 5px;
            padding: 10px 20px;
            font-weight: 600;
        }

        .message {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <span class="navbar-brand">📚 Student Management System - Admin Panel</span>
            <div class="ms-auto">
                <a href="dashboard.php" class="btn btn-outline-light btn-sm me-2">Back to Dashboard</a>
                <a href="../auth1/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="form-card">
            <h2>➕ Add Grade</h2>

            <?php if ($message): ?>
                <div class="message <?= strpos($message, 'successfully') !== false ? 'success' : 'error'; ?>">
                    <?= $message; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Student</label>
                    <select name="student_id" class="form-select" required>
                        <option value="">-- Select Student --</option>
                        <?php while ($student = $students->fetch_assoc()): ?>
                            <option value="<?= $student['id']; ?>"><?= htmlspecialchars($student['name']); ?> (ID: <?= $student['id']; ?>)</option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control" placeholder="e.g., Mathematics" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Grade</label>
                    <input type="text" name="grade" class="form-control" placeholder="e.g., A, B, 85, 90" required>
                </div>

                <button type="submit" name="add" class="btn btn-primary w-100">Add Grade</button>
            </form>

            <a href="dashboard.php" class="btn btn-secondary w-100 mt-3">Back to Dashboard</a>
        </div>
    </div>
</body>

</html>