<?php
$conn = new mysqli("localhost", "root", "", "student_system1");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Create students table
$students_table = "CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    course VARCHAR(100),
    role VARCHAR(20) DEFAULT 'student',
    profile_pic VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($students_table) === TRUE) {
  echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px;'>✓ Students table created successfully</div>";
} else {
  echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 10px;'>✗ Error creating students table: " . $conn->error . "</div>";
}

// Create grades table
$grades_table = "CREATE TABLE IF NOT EXISTS grades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    subject VARCHAR(100) NOT NULL,
    grade VARCHAR(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
)";

if ($conn->query($grades_table) === TRUE) {
  echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px;'>✓ Grades table created successfully</div>";
} else {
  echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 10px;'>✗ Error creating grades table: " . $conn->error . "</div>";
}

// Insert sample admin user if not exists
$admin_check = $conn->query("SELECT * FROM students WHERE email='admin@sms.com'");
if ($admin_check->num_rows == 0) {
  $admin_password = password_hash("admin123", PASSWORD_DEFAULT);
  $admin_insert = "INSERT INTO students(name, email, password, course, role) 
                    VALUES('Admin User', 'admin@sms.com', '$admin_password', 'Administration', 'admin')";
  if ($conn->query($admin_insert) === TRUE) {
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px;'>✓ Admin user created (Email: admin@sms.com, Password: admin123)</div>";
  }
}

// Insert sample student user if not exists
$student_check = $conn->query("SELECT * FROM students WHERE email='student@example.com'");
if ($student_check->num_rows == 0) {
  $student_password = password_hash("student123", PASSWORD_DEFAULT);
  $student_insert = "INSERT INTO students(name, email, password, course, role) 
                      VALUES('Sample Student', 'student@example.com', '$student_password', 'Computer Science', 'student')";
  if ($conn->query($student_insert) === TRUE) {
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px;'>✓ Sample student created (Email: student@example.com, Password: student123)</div>";
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
  <title>SMS - Database Setup</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
    }

    .setup-box {
      background: white;
      border-radius: 10px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      padding: 40px;
      max-width: 600px;
    }

    .setup-box h2 {
      color: #667eea;
      margin-bottom: 30px;
      text-align: center;
    }

    .btn {
      border-radius: 5px;
      padding: 10px 20px;
      font-weight: 600;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="setup-box mx-auto">
      <h2>✅ Database Setup Complete</h2>

      <div style="margin: 20px 0;">
        <h5>Sample Credentials:</h5>

        <div style="background: #f0f0f0; padding: 15px; border-radius: 5px; margin: 15px 0;">
          <strong>Admin Account:</strong><br>
          Email: <code>admin@sms.com</code><br>
          Password: <code>admin123</code>
        </div>

        <div style="background: #f0f0f0; padding: 15px; border-radius: 5px; margin: 15px 0;">
          <strong>Student Account:</strong><br>
          Email: <code>student@example.com</code><br>
          Password: <code>student123</code>
        </div>
      </div>

      <a href="auth1/login.php" class="btn btn-primary w-100" style="margin-top: 20px;">Go to Login Page</a>
    </div>
  </div>
</body>

</html>