<?php
session_start();
if (!isset($_SESSION['role']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli('localhost', 'root', 'root', 'management university');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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


$query2 = "SELECT * FROM `student` WHERE student_id = ?";
$stmt2 = $conn->prepare($query2);
if (!$stmt2) {
    die("Query preparation failed: " . $conn->error);
}
$student_id = $user['student_id'];
$_SESSION['student_id'] = $student_id; 
$stmt2->bind_param('i', $student_id);
$stmt2->execute();
$result2 = $stmt2->get_result();
if ($result2->num_rows === 0) {
    die("No student found with the provided student ID.");
}
$user2 = $result2->fetch_assoc();


$courses = $conn->query("SELECT * FROM Courses");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="style_dashboard.css"> <!-- ربط ملف CSS -->
</head>
<body>
<div class="header">
        <a href="login.php" class="login-link">Go to Login</a>
    </div>
    <h2>Welcome, <?php echo htmlspecialchars($user2['name']); ?>!</h2>
    <p>Role: <?php echo htmlspecialchars($role); ?></p>
    <p>Email: <?php echo htmlspecialchars($user2['email']); ?></p>
    <p>Phone: <?php echo htmlspecialchars($user2['phone']); ?></p>

    <h2>Enroll in a Course</h2>
    <table>
        <thead>
            <tr>
                <th>Course Name</th>
                <th>Enroll</th>
                <th>Unenroll</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($course = $courses->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $course['course_name']; ?></td>
                    <td><button class="enroll-btn" data-course-id="<?php echo $course['course_id']; ?>">+</button></td>
                    <td><button class="unenroll-btn" data-course-id="<?php echo $course['course_id']; ?>">-</button></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <button id="view-enrolled-courses">View Enrolled Courses</button>

    <div id="enrolled-courses"></div> 

    <div id="message"></div> 

    <script>
        $(document).ready(function() {
        
            $('.enroll-btn').click(function() {
                var course_id = $(this).data('course-id');
                $.ajax({
                    type: 'POST',
                    url: 'enroll_handler.php',
                    data: { course_id: course_id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#message').html("<p style='color:green;'>" + response.message + "</p>");
                        } else {
                            $('#message').html("<p style='color:red;'>" + response.message + "</p>");
                        }
                    },
                    error: function() {
                        $('#message').html("<p style='color:red;'>You are already enrolled in this course</p>");
                    }
                });
            });


            $('.unenroll-btn').click(function() {
                var course_id = $(this).data('course-id');
                $.ajax({
                    type: 'POST',
                    url: 'unenroll_handler.php',
                    data: { course_id: course_id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#message').html("<p style='color:green;'>" + response.message + "</p>");
                        } else {
                            $('#message').html("<p style='color:red;'>" + response.message + "</p>");
                        }
                    },
                    error: function() {
                        $('#message').html("<p style='color:red;'>You are already enrolled in this course</p>");
                    }
                });
            });

            $('#view-enrolled-courses').click(function() {
                $.ajax({
                    type: 'GET',
                    url: 'view_enrolled_courses.php',
                    dataType: 'html',
                    success: function(response) {
                        $('#enrolled-courses').html(response);
                    },
                    error: function() {
                        $('#enrolled-courses').html("<p style='color:red;'>Failed to load enrolled courses.</p>");
                    }
                });
            });
        });
    </script>
</body>
</html>
