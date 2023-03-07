<?php
session_start();

$mysqli = require __DIR__ . "/db.php";

if (isset($_SESSION['user_id']) && ($_SESSION['userType'] === "Admin" || 
    $_SESSION['userType'] === "Tutor")) {
    $courseName = $_POST['course-name'];
    $owner = $_SESSION['email'];

    if (!empty($courseName)) {
        $stmt = $mysqli->prepare("INSERT INTO courses (title, owner) 
            SELECT ?, ?
            FROM DUAL
            WHERE NOT EXISTS (SELECT 1 FROM courses WHERE title = ?)");
        $stmt->bind_param("sss", $courseName, $owner, $courseName);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "<span style='color: green;'>Successfully created course $courseName</span>";
            } else {
                echo "<span style='color: red;'>Error: Course $courseName already exists!" . $mysqli->error . "</span>";
            }
        } else {
            error_log("Error creating course: " . $mysqli->error);
            echo "<span style='color: red;'>Something went wrong! Error: " . $mysqli->error . "</span>";
        }
        $stmt->close();
    } else {
        echo "<span style='color: red;'>Please enter a course name!</span>";
    }
}
?>