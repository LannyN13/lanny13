<?php
session_start();
include("../config1/db.php");

if (!isset($_SESSION['user_id'])) header("Location: ../auth1/login.php");

$id = $_SESSION['user_id'];
$message = "";

if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $course = $_POST['course'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    if ($image) {
        move_uploaded_file($tmp, "../uploads1/" . $image);
        $stmt = $conn->prepare("UPDATE students SET name=?, course=?, profile_pic=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $course, $image, $id);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("UPDATE students SET name=?, course=? WHERE id=?");
        $stmt->bind_param("ssi", $name, $course, $id);
        $stmt->execute();
    }

    $message = "Profile updated successfully!";
}

$user = $conn->query("SELECT * FROM students WHERE id=$id")->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
    <title>SMS - My Profile</title>
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

        .profile-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 30px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #667eea;
            margin-bottom: 20px;
        }

        .profile-card h2 {
            color: #667eea;
            margin-bottom: 20px;
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
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
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
        <div class="profile-card">
            <h2 style="text-align: center;">My Profile</h2>

            <?php if ($message): ?>
                <div class="message"><?= $message; ?></div>
            <?php endif; ?>

            <div style="text-align: center;">
                <?php if ($user['profile_pic']): ?>
                    <img src="../uploads1/<?= htmlspecialchars($user['profile_pic']); ?>" class="profile-pic" alt="Profile">
                <?php else: ?>
                    <div class="profile-pic" style="background: #ddd; display: flex; align-items: center; justify-content: center; font-size: 40px;">👤</div>
                <?php endif; ?>
            </div>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Course</label>
                    <input type="text" name="course" class="form-control" value="<?= htmlspecialchars($user['course']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Change Profile Picture</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <button type="submit" name="update" class="btn btn-primary w-100">Update Profile</button>
            </form>
        </div>
    </div>
</body>

</html>