<?php
session_start();
include("../config1/db.php");

$error = "";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM students WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header("Location: ../admin1/dashboard.php");
            } else {
                header("Location: ../dash1/home.php");
            }
            exit();
        } else {
            $error = "Wrong password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>SMS - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-box {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 400px;
        }

        .login-box h2 {
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

        .register-link {
            text-align: center;
            margin-top: 20px;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-box mx-auto">
            <h2>📚 Student Management System</h2>
            <h5 style="text-align: center; color: #666; margin-bottom: 25px;">Login</h5>

            <?php if ($error): ?>
                <div class="alert alert-danger error"><?= $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
                <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            </form>

            <div class="register-link">
                Don't have an account? <a href="register.php">Register here</a>
            </div>
        </div>
    </div>
</body>

</html>