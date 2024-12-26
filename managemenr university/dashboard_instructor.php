<?php
session_start();
if ($_SESSION['role'] !== 'Instructor') {
    header("Location: login.php");
    exit;
}

$conn = new mysqli('localhost', 'root', 'root', 'management university'); // عدل إعدادات الاتصال بقاعدة البيانات
$role = $_SESSION['role'];
$username = $_SESSION['username'];


$query = "SELECT * FROM `login` WHERE username = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("No user found with the provided username.");
}
$user = $result->fetch_assoc();


$query2 = "SELECT * FROM `instructor` WHERE instructor_id = ?";
$stmt2 = $conn->prepare($query2);
if (!$stmt2) {
    die("Query preparation failed: " . $conn->error);
}
$stmt2->bind_param('i', $user['instructor_id']);
$stmt2->execute();
$result2 = $stmt2->get_result();
if ($result2->num_rows === 0) {
    die("No instructor found with the provided instructor ID.");
}
$user2 = $result2->fetch_assoc();


$query = "SELECT * FROM Courses WHERE instructor_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user['instructor_id']); 
$stmt->execute();
$courses = $stmt->get_result();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_student'])) {
        $student_id = $_POST['student_id'];
        $course_id = $_POST['course_id'];

        $query = "INSERT INTO Enrollment (student_id, course_id) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $student_id, $course_id);

        if ($stmt->execute()) {
            $success = "Student added successfully!";
        } else {
            $error = "Failed to add student.";
        }
    } elseif (isset($_POST['delete_student'])) {
        $student_id = $_POST['student_id'];
        $course_id = $_POST['course_id'];

        $conn->close(); 
        $conn = new mysqli('localhost', 'root', 'root', 'management university'); // إعادة الاتصال
        $query = "DELETE FROM Enrollment WHERE student_id = ? AND course_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $student_id, $course_id);

        if ($stmt->execute()) {
            $success = "Student removed successfully!";
        } else {
            $error = "Failed to remove student.";
        }
    } elseif (isset($_POST['add_grade'])) {
        $student_id = $_POST['student_id'];
        $course_id = $_POST['course_id'];
        $grade_gpa = $_POST['grade_gpa'];

        $query = "INSERT INTO Grade (student_id, course_id, grade_gpa) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('iid', $student_id, $course_id, $grade_gpa);

        if ($stmt->execute()) {
            $success = "Grade added successfully!";
        } else {
            $error = "Failed to add grade.";
        }
    } elseif (isset($_POST['upload_assignment'])) {
        $title = $_POST['title'];
        $due_date = $_POST['due_date'];
        $course_id = $_POST['course_id'];

        $query = "INSERT INTO Assignment (title, due_date, course_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssi', $title, $due_date, $course_id);

        if ($stmt->execute()) {
            $success = "Assignment uploaded successfully!";
        } else {
            $error = "Failed to upload assignment.";
        }
    } elseif (isset($_POST['view_students'])) {
        $course_id = $_POST['course_id'];
        
    
        $query = "SELECT s.student_id, s.name, s.email FROM student s 
            JOIN Enrollment e ON s.student_id = e.student_id 
            WHERE e.course_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $course_id);
        $stmt->execute();
        $students_result = $stmt->get_result();
    } elseif (isset($_POST['view_assignments'])) {
        $course_id = $_POST['course_id'];
        
    
        $query = "SELECT * FROM Assignment WHERE course_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $course_id);
        $stmt->execute();
        $assignments_result = $stmt->get_result();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Instructor Dashboard</title>
    <link rel="stylesheet" href="style_instructor_dashboard.css">

</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($user2['name']); ?>!</h2>
    <p>Role: <?php echo htmlspecialchars($role); ?></p>
    <p>Email: <?php echo htmlspecialchars($user2['email']); ?></p>
    <p>Phone: <?php echo htmlspecialchars($user2['phone']); ?></p>

    <form method="POST">
    <div class="header">
        <a href="login.php" class="login-link">Go to Login</a>
    </div>
        <h3>Add Student to Course</h3>
        <label>Student ID:</label>
        <input type="number" name="student_id" required><br>
        <label>Course:</label>
        <select name="course_id" required>
            <?php while ($course = $courses->fetch_assoc()) { ?>
                <option value="<?php echo $course['course_id']; ?>">
                    <?php echo $course['course_name']; ?>
                </option>
            <?php } ?>
        </select><br>
        <button type="submit" name="add_student">Add Student</button>
    </form>

    <form method="POST">
        <h3>Remove Student from Course</h3>
        <label>Student ID:</label>
        <input type="number" name="student_id" required><br>
        <label>Course:</label>
        <select name="course_id" required>
            <?php $courses->data_seek(0);?>
            <?php while ($course = $courses->fetch_assoc()) { ?>
                <option value="<?php echo $course['course_id']; ?>">
                    <?php echo $course['course_name']; ?>
                </option>
            <?php } ?>
        </select><br>
        <button type="submit" name="delete_student">Remove Student</button>
    </form>

    <form method="POST">
        <h3>Add Grade for Student</h3>
        <label>Student ID:</label>
        <input type="number" name="student_id" required><br>
        <label>Course:</label>
        <select name="course_id" required>
            <?php $courses->data_seek(0); ?>
            <?php while ($course = $courses->fetch_assoc()) { ?>
                <option value="<?php echo $course['course_id']; ?>">
                    <?php echo $course['course_name']; ?>
                </option>
            <?php } ?>
        </select><br>
        <label>Grade (0.0 - 4.0):</label>
        <input type="number" step="0.1" name="grade_gpa" min="0" max="4" required><br>
        <button type="submit" name="add_grade">Add Grade</button>
    </form>

    <form method="POST">
        <h3>Upload Assignment</h3>
        <label>Title:</label>
        <input type="text" name="title" required><br>
        <label>Due Date:</label>
        <input type="date" name="due_date" required><br>
        <label>Course:</label>
        <select name="course_id" required>
            <?php $courses->data_seek(0); ?>
            <?php while ($course = $courses->fetch_assoc()) { ?>
                <option value="<?php echo $course['course_id']; ?>">
                    <?php echo $course['course_name']; ?>
                </option>
            <?php } ?>
        </select><br>
        <button type="submit" name="upload_assignment">Upload Assignment</button>
    </form>

    <form method="POST">
        <h3>View Students in Course</h3>
        <label>Course:</label>
        <select name="course_id" required>
            <?php $courses->data_seek(0); ?>
            <?php while ($course = $courses->fetch_assoc()) { ?>
                <option value="<?php echo $course['course_id']; ?>">
                    <?php echo $course['course_name']; ?>
                </option>
            <?php } ?>
        </select><br>
        <button type="submit" name="view_students">View Students</button>
    </form>

    <form method="POST">
        <h3>View Assignments in Course</h3>
        <label>Course:</label>
        <select name="course_id" required>
            <?php $courses->data_seek(0); ?>
            <?php while ($course = $courses->fetch_assoc()) { ?>
                <option value="<?php echo $course['course_id']; ?>">
                    <?php echo $course['course_name']; ?>
                </option>
            <?php } ?>
        </select><br>
        <button type="submit" name="view_assignments">View Assignments</button>
    </form>

    <?php if (isset($students_result)) { ?>
        <h3>Students in Selected Course</h3>
        <table>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
            <?php while ($student = $students_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $student['student_id']; ?></td>
                    <td><?php echo $student['name']; ?></td>
                    <td><?php echo $student['email']; ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>

    <?php if (isset($assignments_result)) { ?>
        <h3>Assignments in Selected Course</h3>
        <table>
            <tr>
                <th>Title</th>
                <th>Due Date</th>
            </tr>
            <?php while ($assignment = $assignments_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $assignment['title']; ?></td>
                    <td><?php echo $assignment['due_date']; ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>
</body>
</html>
