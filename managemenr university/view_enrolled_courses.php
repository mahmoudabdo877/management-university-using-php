<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    echo "<p style='color:red;'>Student not logged in.</p>";
    exit;
}

$conn = new mysqli('localhost', 'root', 'root', 'management university');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_id = $_SESSION['student_id'];

$query = "
    SELECT c.course_name, 
        COALESCE(g.grade_gpa, 'Not Found') AS grade
    FROM Enrollment e
    JOIN Courses c ON e.course_id = c.course_id
    LEFT JOIN Grade g ON e.student_id = g.student_id AND e.course_id = g.course_id
    WHERE e.student_id = ?
";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}
$stmt->bind_param('i', $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Grade (GPA)</th>
                </tr>
            </thead>
            <tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['course_name']) . "</td>
                <td>" . htmlspecialchars($row['grade']) . "</td>
            </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<p style='color:red;'>No courses enrolled yet.</p>";
}

$conn->close();
?>
