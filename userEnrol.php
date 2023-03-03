<?php
    session_start();

    $mysqli = require __DIR__ . "/db.php";

    if (isset($_SESSION["user_id"]) and ($_SESSION["userType"] === "Admin") || ($_SESSION['userType'] === "Tutor")) {
        // var_dump($_POST);
        $email = $_POST['userEmail'];
        $courseId = $_POST['courseID'];
        $sql = "INSERT INTO enroledStudents(studentUsername, courseId, authorised) VALUES ('{$email}', '{$courseId}', '0')";
        $result = $mysqli->query($sql);

        if ($mysqli->affected_rows == 1) {
            echo "<span style='color: green;'>You have successfully applied to enrol onto course id $courseId</span>";
        } else {
            echo "<span style='color: red;'>YOU FAILED TO ENROL ONTO COURSE ID $courseId." . mysqli_error($conn) . "</span>";
        }
    } else {
        echo "Unauthorized";
    }
?>