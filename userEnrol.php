<?php
    session_start();

    $mysqli = require __DIR__ . "/db.php";

    if (isset($_SESSION["user_id"]) and ($_SESSION["userType"] === "Admin") || ($_SESSION['userType'] === "Tutor")) {
        // var_dump($_POST);
        $email = $_POST['userEmail'];
        $courseId = $_POST['courseID'];

        // Check if the user is already enrolled in the course
        $checkSql = "SELECT * FROM enroledStudents WHERE studentUsername = '{$email}' AND courseId = '{$courseId}'";
        $checkResult = $mysqli->query($checkSql);

        if ($checkResult->num_rows > 0) {
            echo "<span style='color: orange;'>$email is already enrolled in course id: $courseId</span>";
        } else {
            // Insert a new enrollment record
            $insertSql = "INSERT INTO enroledStudents(studentUsername, courseId, authorised) VALUES ('{$email}', '{$courseId}', '1')";
            $insertResult = $mysqli->query($insertSql);

            if ($mysqli->affected_rows == 1) {
                echo "<span style='color: green;'>You have successfully enrolled $email onto course id: $courseId</span>";
            } else {
                echo "<span style='color: red;'>Failed to enroll $email onto course id $courseId." . mysqli_error($mysqli) . "</span>";
            }
        }
    } else if (isset($_SESSION["user_id"]) and ($_SESSION["userType"] === "Student")) {
        $email = $_SESSION['email'];
        $courseId = $_POST['courseID'];

        // Check if the user is already enrolled in the course
        $checkSql = "SELECT * FROM enroledStudents WHERE studentUsername = '{$email}' AND courseId = '{$courseId}'";
        $checkResult = $mysqli->query($checkSql);

        if ($checkResult->num_rows > 0) {
            echo "<span style='color: orange;'>You are already enrolled in course id: $courseId</span>";
        } else {
            // Insert a new enrollment record
            $insertSql = "INSERT INTO enroledStudents(studentUsername, courseId, authorised) VALUES ('{$email}', '{$courseId}', '0')";
            $insertResult = $mysqli->query($insertSql);

            if ($mysqli->affected_rows == 1) {
                echo "<span style='color: green;'>You have successfully enrolled onto course id: $courseId</span>";
            } else {
                echo "<span style='color: red;'>Failed to enroll onto course id $courseId." . mysqli_error($mysqli) . "</span>";
            }
        }
    } else {
        echo "Unauthorized";
    }
?>