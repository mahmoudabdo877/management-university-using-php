<?php
session_start();

$conn = new mysqli('localhost', 'root', 'root', 'management university'); // إعدادات الاتصال بقاعدة البيانات
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['student_id'])) {
        echo json_encode(["status" => "error", "message" => "Student not logged in."]);
        exit;
    }

    $student_id = $_SESSION['student_id'];
    $course_id = $_POST['course_id'];

    $query = "INSERT INTO Enrollment (student_id, course_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Query preparation failed."]);
        exit;
    }

    $stmt->bind_param('ii', $student_id, $course_id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Enrollment successful!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to enroll."]);
    }
    exit;
}
?>
