<?php
session_start();
if ($_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit;
}

$conn = new mysqli('localhost', 'root', 'root', 'management university');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success_message = 'sucessfully';
$error_message = 'failed';


if (isset($_POST['add_course'])) {
    $course_name = $_POST['course_name'];
    $credit = $_POST['credit'];
    $dept_id = $_POST['dept_id'];
    $instructor_id = $_POST['instructor_id'];

    $query = "INSERT INTO Courses (course_name, credit, dept_id, instructor_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('siii', $course_name, $credit, $dept_id, $instructor_id);

    if ($stmt->execute()) {
        $success_message = "Course added successfully!";
    } else {
        $error_message = "Error adding course. Please try again.";
    }
}

// إضافة معلم جديد
if (isset($_POST['add_instructor'])) {
    $instructor_name = $_POST['instructor_name'];
    $instructor_email = $_POST['instructor_email'];
    $instructor_phone = $_POST['instructor_phone'];
    $dept_id = $_POST['dept_id'];

    $query = "INSERT INTO Instructor (name, email, phone, dept_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssi', $instructor_name, $instructor_email, $instructor_phone, $dept_id);
    $stmt->execute();

    $instructor_id = $stmt->insert_id; 

  
    $username = $_POST['instructor_username'];
    $password = $_POST['instructor_password'];
    $role = 'Instructor';

    $query2 = "INSERT INTO Login (username, password, role, instructor_id) VALUES (?, ?, ?, ?)";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param('sssi', $username, $password, $role, $instructor_id);
    
    if ($stmt2->execute()) {
        $success_message = "Instructor added successfully!";
    } else {
        $error_message = "Error adding instructor. Please try again.";
    }
}


if (isset($_POST['add_student'])) {
    $student_name = $_POST['student_name'];
    $student_age = $_POST['student_age'];
    $student_email = $_POST['student_email'];
    $student_phone = $_POST['student_phone'];


    $query = "INSERT INTO Student (name, age, email, phone) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('siss', $student_name, $student_age, $student_email, $student_phone);
    $stmt->execute();

    $student_id = $stmt->insert_id; 

    
    $username = $_POST['student_username'];
    $password = $_POST['student_password'];
    $role = 'Student';

    $query2 = "INSERT INTO Login (username, password, role, student_id) VALUES (?, ?, ?, ?)";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param('sssi', $username, $password, $role, $student_id);
    
    if ($stmt2->execute()) {
        $success_message = "Student added successfully!";
    } else {
        $error_message = "Error adding student. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style_admin_dashboard.css">
</head>
<body>
<div class="header">
        <a href="login.php" class="login-link">Go to Login</a>
    </div>
    <h2>Admin Dashboard</h2>

    <?php if ($success_message): ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <?php if ($error_message): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <h3>Add New Course</h3>
    <form method="POST">
        <label>Course Name:</label>
        <input type="text" name="course_name" required><br>
        <label>Credit:</label>
        <input type="number" name="credit" required><br>
        <label>Department ID:</label>
        <input type="number" name="dept_id" required><br>
        <label>Instructor ID:</label>
        <input type="number" name="instructor_id" required><br>
        <button type="submit" name="add_course">Add Course</button>
    </form>

    <h3>Add New Instructor</h3>
    <form method="POST">
        <label>Instructor Name:</label>
        <input type="text" name="instructor_name" required><br>
        <label>Instructor Email:</label>
        <input type="email" name="instructor_email" required><br>
        <label>Instructor Phone:</label>
        <input type="text" name="instructor_phone" required><br>
        <label>Department ID:</label>
        <input type="number" name="dept_id" required><br>
        <label>Username:</label>
        <input type="text" name="instructor_username" required><br>
        <label>Password:</label>
        <input type="password" name="instructor_password" required><br>
        <button type="submit" name="add_instructor">Add Instructor</button>
    </form>

    <h3>Add New Student</h3>
    <form method="POST">
        <label>Student Name:</label>
        <input type="text" name="student_name" required><br>
        <label>Student Age:</label>
        <input type="number" name="student_age" required><br>
        <label>Student Email:</label>
        <input type="email" name="student_email" required><br>
        <label>Student Phone:</label>
        <input type="text" name="student_phone" required><br>
        <label>Username:</label>
        <input type="text" name="student_username" required><br>
        <label>Password:</label>
        <input type="password" name="student_password" required><br>
        <button type="submit" name="add_student">Add Student</button>
    </form>

</body>
</html>
