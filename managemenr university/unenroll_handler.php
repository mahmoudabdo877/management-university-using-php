<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Student not logged in.']);
    exit;
}

$conn = new mysqli('localhost', 'root', 'root', 'management university');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_id = $_SESSION['student_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course_id'])) {
    $course_id = intval($_POST['course_id']);
    

    $query = "DELETE FROM Enrollment WHERE student_id = ? AND course_id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }
    $stmt->bind_param('ii', $student_id, $course_id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Course unenrolled successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to unenroll from the course.']);
    }
}

$conn->close();
?>
