<?php
  session_start();

  if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/db.php";

    $sql = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    $letter_forename = substr($user["forename"], 0, 1);
    $letter_surname = substr($user["surname"], 0, 1);
    $initials = $letter_forename . $letter_surname;
    $userType = $user["user"];

    $_SESSION["user_initials"] = $initials;
    $_SESSION["userType"] = $userType;
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
    <title>Courses</title>
    <link rel="stylesheet" href="./style/course_list_style.css" />
    <script src="./js/app.js" defer></script>
  </head>
  <body>
  <?php include './includes/header.php'; ?>
    <div class="main">
      <div class="container">
        <div class="content">
          <div class="heading"><span>Courses</span></div>
          <div class="content-grid">
            <?php include './includes/courseListLoad.php'; ?>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>