<?php
session_start();

    require_once("./includes/userCourse.php");

    if (isset($_SESSION["user_id"])) {
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

  function displayResources() {
    if (isset($_SESSION["user_id"])) {
      $mysqli = require __DIR__ . "/db.php";
      $escapedCourseTitle = $mysqli->real_escape_string($_SESSION['course']);

      $sql = "SELECT * FROM weeks WHERE courseId = (SELECT id FROM courses WHERE title = '$escapedCourseTitle')";
      $weeksResult = $mysqli->query($sql);
    
      // // Retrieve resources for the current course
    
      while ($week = $weeksResult->fetch_assoc()) {
      $weekId = $week['id'];
      $weekHeading = $week['heading'];
      $weekDescription = $week['description'];

      // Display week heading and description
      echo "<div class='resourceContainer'>";
      echo "<div class='resourceHeading'>$weekHeading</div>";
      echo "<div class='resourceDescription'>$weekDescription</div>";

      // Retrieve resources for the current week

      $sql = "SELECT resources.fileName, resources.id FROM resources
            INNER JOIN weeksresources ON resources.id = weeksresources.resourceId
            WHERE weekId = '$weekId'";

      $resourcesResult = $mysqli->query($sql);

      while ($resource = $resourcesResult->fetch_assoc()) {
        $fileName = $resource['fileName'];

        // Display resource information
        echo "<div class='resources'>";
        echo "<a href='resources/$fileName'>$fileName</a>";
        echo "</div>";
      }

      echo "</div>";
    }
  }
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
            </div>
            <?php echo displayResources(); ?>
        </div>
      </div>
    </div>
    <script src="./js/rescources_functions.js"></script>
  </body>
</html>