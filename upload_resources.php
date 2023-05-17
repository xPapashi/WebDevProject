<?php
	session_start();
    $mysqli = require __DIR__ . "/db.php";


if (isset($_POST['submit'])){
    if(isset($_FILES['uploadFile'])) {
        extract($_FILES['uploadFile']);
        
        $target = "./resources/$name";
        $uploader = $_SESSION['email'];
        $uploadDate = $_POST['uploadDate'];
        list($userCourseId, $userCourse) = explode(',', $_POST['course']);
        $week = $_POST['week'];

        $extension = substr($name, -3);

        if ($size <= 5000000) {
            if (move_uploaded_file($tmp_name, $target)) {
                $sql = "INSERT INTO resources(filename, uploader, uploadDate, courseId) VALUE ('$name', '$uploader', DATE('$uploadDate'), '$userCourseId')";
                $result = $mysqli->query($sql);

                $sql = "SELECT id FROM resources WHERE fileName = '$name'";
                $result = $mysqli->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $resourceId = $row['id'];
                }
                $sql = "INSERT INTO weeksresources(weekId, resourceId) VALUES ('$week', '$resourceId')";
                $result = $mysqli->query($sql);
                $_SESSION['response'] = "<p style='color: green;'>File has been successfully uploaded!</p>";
                header("Location: course_resources.php");
            } else {
                $_SESSION['response'] = "<p style='color: red;'>Something went wrong!</p>";
                header("Location: course_resources.php");
            }
        } else {
             $_SESSION['response'] = "<p style='color: red;'>Your file is too big!</p>";
            header("Location: course_resources.php");
        }
        
    }
}
?>