<?php
    function showUserCourse($userEmail) {
        $mysqli = require __DIR__ . "../../db.php";

        $escapedUserEmail = $mysqli->real_escape_string($userEmail);
        $sql = "SELECT courseId FROM enroledStudents WHERE studentUsername = '{$escapedUserEmail}'";
    
        $result = $mysqli->query($sql);

        echo "<p>Courses:</p>";

        while ($row = $result->fetch_assoc()) {
            $courseId = $row['courseId'];
            $sql = "SELECT title FROM courses WHERE id = {$courseId}";
            $result = $mysqli->query($sql);

            $course = $result->fetch_assoc();
            $courseTitle = $course['title'];

            echo $courseTitle;
        }
    }
?>