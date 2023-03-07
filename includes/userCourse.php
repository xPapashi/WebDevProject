<?php
    function showUserCourse($userEmail) {
        $mysqli = require __DIR__ . "../../db.php";
    
        $escapedUserEmail = $mysqli->real_escape_string($userEmail);
        $sql = "SELECT courseId FROM enroledStudents WHERE studentUsername = '{$escapedUserEmail}'";
        $result = $mysqli->query($sql);
    
        echo "<p>Courses:</p>";
    
        while ($row = $result->fetch_assoc()) {
            $courseId = $row['courseId'];
            $sql2 = "SELECT title FROM courses WHERE id = {$courseId}";
            $result2 = $mysqli->query($sql2);
    
            $course = $result2->fetch_assoc();
            $courseTitle = $course['title'];
            echo "<p>$courseTitle</p>";
        }
    }
?>