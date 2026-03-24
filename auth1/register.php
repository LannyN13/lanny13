<?php
include("../config1/db.php");

$message = "";
$error = "";

if (isset($_POST['register'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);
    $password = $_POST['password'];

    // Validation
    if (empty($name) || empty($email) || empty($password)) {
        $error = "All fields required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email!";
    } elseif (strlen($password) < 6) {
        $error = "Password must be 6+ characters";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO students(name,email,password,course) VALUES(?,?,?,?)");
        $stmt->bind_param("ssss", $name, $email, $hashed, $course);

        if ($stmt->execute()) {
            $message = "Registered Successfully! <a href='login.php' style='color: white; font-weight: bold;'>Login here</a>";
        } else {
            $error = "Email already exists!";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>SMS - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .register-box {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 450px;
        }

        .register-box h2 {
            color: #667eea;
            margin-bottom: 30px;
            text-align: center;
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
            padding: 10px 15px;
        }

        .btn {
            border-radius: 5px;
            padding: 10px 20px;
            font-weight: 600;
        }

        .error {
            color: #dc3545;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .success {
            background-color: #28a745;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="register-box mx-auto">
            <h2>📚 Student Management System</h2>
            <h5 style="text-align: center; color: #666; margin-bottom: 25px;">Create Account</h5>

            <?php if ($message): ?>
                <div class="success"><?= $message; ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <input type="text" name="name" class="form-control mb-3" placeholder="Full Name" required>
                <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
                <input type="text" name="course" class="form-control mb-3" placeholder="Course" required>
                <input type="password" name="password" class="form-control mb-3" placeholder="Password (6+ chars)" required>
                <button type="submit" name="register" class="btn btn-success w-100">Register</button>
            </form>

            <div class="login-link">
                Already have an account? <a href="login.php">Login here</a>
            </div>
        </div>
    </div>
</body>

</html>