<?php
session_start();

    require_once("./includes/userCourse.php");

    if (isset($_SESSION["user_id"]) and ($_SESSION["userType"] === "Admin") 
    || ($_SESSION["userType"] === "Tutor")) {
    $mysqli = require __DIR__ . "/db.php";

    $sql = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    $letter_forename = substr($user["forename"], 0, 1);
    $letter_surname = substr($user["surname"], 0, 1);
    $initials = $letter_forename . $letter_surname;
    $fullname = $user["forename"] . " " . $user["surname"];
    $email = strtolower($user["email"]);

    //Get Course
    $escapedUserEmail = $mysqli->real_escape_string($user['email']);
    $sql = "SELECT courseId FROM enroledStudents WHERE studentUsername = '{$escapedUserEmail}'";
    $result = $mysqli->query($sql);

    while ($row = $result->fetch_assoc()) {
        $courseId = $row['courseId'];
        $sql = "SELECT title FROM courses WHERE id = {$courseId}";
        $result = $mysqli->query($sql);

        $course = $result->fetch_assoc();
        $_SESSION['course'] = $course['title'];
    }

    $_SESSION["user_initials"] = $initials;
    $_SESSION["email"] = $email;

  } else {
    header("Location: index.php");
    die();
  }
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Course Resources</title>

    <link rel="stylesheet" href="./style/course_resources_style.css" />
  </head>
  <body>
    <?php include('./includes/header.php'); ?>
    <div class="main">
      <div class="container">
        <div class="content" id="content">
          <div class="heading"><span>Course Resources</span></div>
          <div class="topContents">
            <p>Course Progress: 0%</p>
            <button class="addContentButton">Add more Resources</button>
          </div>
          <div class="resourceContainer">
            <form
              action="./upload_resources.php"
              method="POST"
              enctype="multipart/form-data"
            >
              <input type="file" name="uploadFile" />
              <button type="submit" name="submit">Upload file</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script src="./js/rescources_functions.js"></script>
  </body>
</html>