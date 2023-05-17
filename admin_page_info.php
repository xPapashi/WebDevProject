<?php
session_start();

if (isset($_SESSION["user_id"]) and ($_SESSION["userType"] === "Admin")) {
  $mysqli = require __DIR__ . "/db.php";

  $sql = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";

  $result = $mysqli->query($sql);

  $user = $result->fetch_assoc();

  $letter_forename = substr($user["forename"], 0, 1);
  $letter_surname = substr($user["surname"], 0, 1);
  $initials = $letter_forename . $letter_surname;
  $_SESSION['email'] = $user['email'];
  $_SESSION['initials'] = $initials;

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
      $_SESSION['courseId'] = $courseId;
  }

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['email'])) {
      $email = $_POST["email"];
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Error: Invalid email!";
      } else if ($email == $user['email']) {
        echo "Error: Submitted email is the same as the previous one!";
      } else {
        var_dump($_POST["email"]);
        $sql = "UPDATE users SET email='{$_POST["email"]}' WHERE id={$user["id"]}";
        if ($mysqli->query($sql) === TRUE) {
          echo "Logs: Updated email!";
        } else {
          echo "Error: " . $mysqli->error;
        }
      }
    } else if (isset($_POST['password'])) {
      $password = $_POST['password'];
      $regex = '#^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[\W_]).{8,}$#';
      if (!filter_var(
        $password,
        FILTER_VALIDATE_REGEXP,
        array("options" => array("regexp" => $regex))
      )) {
        echo "Error: Make sure that password meets at least one of the requirements:\n";
        echo "Must be a minimum of 8 characters\n";
        echo "Must contain at least 1 number\n";
        echo "Must contain at least one uppercase character\n";
        echo "Must contain at least one lowercase character";
        echo "Must contain at least one special character";
      } else {
        var_dump($_POST['password']);
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password='{$password_hashed}' WHERE id={$user["id"]}";
        if ($mysqli->query($sql) === TRUE) {
          echo "Logs: Updated password!";
        } else {
          echo "Error: " . $mysqli->error;
        }
      }
    }
  }
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
  <title>Admin Portal Page</title>
  <link rel="stylesheet" href="./style/admin_page_style.css" />
  <script src="./js/app.js" defer></script>
  <script src="./js/modalPopup.js" defer></script>
  <script src="./js/handleUsers.js" defer></script>
  <script src="./js/handleCourses.js" defer></script>
  <script src="https://kit.fontawesome.com/031c7b0341.js" crossorigin="anonymous"></script>
</head>
<body>
  <?php include('./includes/header.php'); ?>
  <div class="main">
    <div class="container">
      <div class="content">
        <div class="heading"><span>Admin Portal</span></div>
        <div class="content-grid">
          <div class="left-content">
            <div class="container-admin">
              <div class="title-underline">
                <span>Admin Details</span>
              </div>
              <div class="profile-shape">
                <i class="fa-solid fa-user"></i>
              </div>
              <div class="admin-information">
                <?php if (isset($user)) : ?>
                  <?= "<h3>" . htmlspecialchars("Welcome back, " . $user["forename"]) . "!</h3>" ?>
                <?php endif; ?>
                <ul>
                  <li><a href="#test1">Change Username</a></li>
                  <li><button class="trigger emailTrigger">Change Email</button></li>
                  <li><button class="trigger passwordTrigger">Change Password</button></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="right-content">
            <div class="container-user">
              <div class="title-underline">
                <span>Users</span>
              </div>
              <div class="user-information">
                <ul>
                  <li><a href="./register_page.php">Add User</a></li>
                  <li><button class="trigger authTrigger">Auth User Login</button></li>
                  <li><button class="trigger enrolTrigger">Enrol User On Course</button></li>
                  <li><button class="trigger enrolAuthTrigger">Auth User on Course</button></li>
                  <li><button class="trigger deleteTrigger">Delete User</button></li>
                </ul>
              </div>
            </div>
            <div class="container-course">
              <div class="title-underline">
                <span>Course Details</span>
              </div>
              <div class="course-information">
                <ul>
                  <li><button class="trigger addCourseTrigger">Add Course</button></li>
                  <li><a href='./courseWeek_add.php'>Add Week for Course</a></li>
                  <li><a href='./course_resources.php'>Add Resource</a></li>
                  <li><button class="trigger delCourseTrigger">Delete Course</button></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <?php include('./includes/usersContainer.php'); ?>
        <div class="container-logout">
          <a href="./logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>