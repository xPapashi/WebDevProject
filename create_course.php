<?php

    session_start();

    $mysqli = require __DIR__ . "/db.php";

    if (isset($_SESSION['user_id']) && ($_SESSION['userType'] === "Admin")) {
        $courseName = $_POST['course-name'];
        $owner = $_SESSION['email'];

        if (!empty($courseName)) {
            $sql = "INSERT INTO courses (title, owner) VALUES 
            ('$courseName', '$owner')";

            if ($mysqli->query($sql) === TRUE) {
                echo "Course created Successfully!";
            } else {
                echo "Error creating course " . $mysqli->error;
            }
        } else {
            echo "Please enter a course name!";
        }
    }
?>