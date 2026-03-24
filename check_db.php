<?php
$conn = new mysqli("localhost", "root", "", "student_system1");

if ($conn->connect_error) {
  die("<div style='background: #f8d7da; color: #721c24; padding: 20px; border-radius: 5px; margin: 20px;'><strong>❌ Database Connection Error:</strong> " . $conn->connect_error . "</div>");
}

echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 5px; margin: 20px;'><strong>✓ Connected to: student_system1</strong></div>";

// Check existing tables
$tables = $conn->query("SHOW TABLES");
echo "<div style='padding: 20px; margin: 20px;'><strong>Existing Tables:</strong>";
if ($tables->num_rows > 0) {
  echo "<ul>";
  while ($table = $tables->fetch_assoc()) {
    echo "<li>" . array_values($table)[0] . "</li>";
  }
  echo "</ul>";
} else {
  echo "<p style='color: red;'>❌ No tables found! Creating now...</p>";
}
echo "</div>";

// Create students table if not exists
$sql1 = "CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    course VARCHAR(100),
    role VARCHAR(20) DEFAULT 'student',
    profile_pic VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql1) === TRUE) {
  echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px;'>✓ Students table ready</div>";
} else {
  echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 10px;'>✗ Error with students table: " . $conn->error . "</div>";
}

// Create grades table if not exists
$sql2 = "CREATE TABLE IF NOT EXISTS grades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    subject VARCHAR(100) NOT NULL,
    grade VARCHAR(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
)";

if ($conn->query($sql2) === TRUE) {
  echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px;'>✓ Grades table ready</div>";
} else {
  echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 10px;'>✗ Error with grades table: " . $conn->error . "</div>";
}

// Check for test users
$check = $conn->query("SELECT COUNT(*) as count FROM students");
$result = $check->fetch_assoc();
echo "<div style='padding: 20px; margin: 20px;'><strong>Students in database: " . $result['count'] . "</strong></div>";

// Create sample users if empty
if ($result['count'] == 0) {
  $admin_pass = password_hash("admin123", PASSWORD_DEFAULT);
  $student_pass = password_hash("student123", PASSWORD_DEFAULT);

  $sql3 = "INSERT INTO students(name, email, password, course, role) VALUES 
            ('Admin User', 'admin@sms.com', '$admin_pass', 'Administration', 'admin'),
            ('Test Student', 'student@sms.com', '$student_pass', 'Computer Science', 'student')";

  if ($conn->query($sql3) === TRUE) {
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px;'>✓ Sample users created</div>";
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
  <title>SMS - Database Check</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f5f7fa;
      padding: 20px;
    }

    div {
      font-family: Arial, sans-serif;
    }
  </style>
</head>

<body>
  <div class="container" style="max-width: 800px; margin-top: 30px;">
    <h2 style="color: #667eea; margin-bottom: 30px;">Database Status</h2>
    <p style="background: #e7f3ff; padding: 15px; border-radius: 5px; border-left: 4px solid #667eea;">
      ✓ Database initialized successfully!<br><br>
      <strong>Test Credentials:</strong><br>
      Admin: <code>admin@sms.com</code> / <code>admin123</code><br>
      Student: <code>student@sms.com</code> / <code>student123</code>
    </p>
    <a href="auth1/login.php" class="btn btn-primary" style="margin-top: 20px;">Go to Login</a>
  </div>
</body>

</html>