<?php
session_start();

if (isset($_SESSION["user_id"]) and ($_SESSION["userType"] === "Admin") ||
    ($_SESSION["userType"] === "Tutor")) {
    if (empty($_POST["forename"])) {
        die("Forename is required!");
    } else if (empty($_POST["surname"])) {
        die("Surname is required!");
    }
    $mysqli = require __DIR__ . "/db.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $forename = mysqli_real_escape_string($mysqli, $_POST["forename"]);
        $surname = mysqli_real_escape_string($mysqli, $_POST["surname"]);
    }

    $sql = "INSERT INTO users (forename, surname) VALUES ('$forename','$surname')";

    if (mysqli_query($mysqli, $sql)) {
        // echo "New user created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
    }

    $user_id = mysqli_insert_id($mysqli);
    $letter_forename = substr($_POST["forename"], 0, 1);
    $email = $letter_forename . $surname . $user_id . '@system.edu';
    $password = $letter_forename . $surname . $user_id;
    $userType = $_POST["userType"];
    list($userCourseId, $userCourse) = explode(',', $_POST['course']);
    $auth = "0";

    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET email='$email', password='$password_hash', user='$userType', course='$userCourse', authorisation='$auth' WHERE id='$user_id'";

    if (mysqli_query($mysqli, $sql)) {
        // session_start();

        // session_regenerate_id();

        // $_SESSION["user_id"] = $user_id;
        // var_dump($_SESSION);

    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
    }

    $sql = "INSERT INTO enroledStudents (studentUsername, courseId, authorised) VALUES ('$email', '$userCourseId', '0')";

    if (mysqli_query($mysqli, $sql)) {

        if ($_SESSION['userType'] === "Admin") {
            header("Location: admin_page_info.php");
        } else if ($_SESSION['userType'] === "Tutor") {
            header("Location: teacher_page_info.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
    }
} else {
    header("Location: index.php");
    exit();
}
?>