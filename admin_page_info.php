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

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $email = $_POST["email"];
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Error: Invalid email!";
      } else {
        var_dump($_POST["email"]);
        $sql = "UPDATE users SET email='{$_POST["email"]}' WHERE id={$user["id"]}";
        if ($mysqli->query($sql) === TRUE) {
            echo "Logs: Updated email!";
        } else {
            echo "Error: " . $mysqli->error;
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
    <script src="./app.js" defer></script>
    <script src="./modalPopup.js" defer></script>
    <script src="https://kit.fontawesome.com/031c7b0341.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <div class="modal">
        <div class="modal-container">
            <div class="modal-heading">
                <h1>Change user email</h1>
                <span class="close-button">&times;</span>
            </div>
            <div class="modal-content">
                <form method="post">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" placeholder="<?php echo $user["email"]?>" required>
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>
    <div class="header">
      <div class="linksLeft">
        <div class="logo"><a href="index.php">AceTraining</a></div>
        <div class="logo-separator"></div>
        <ul class="links">
          <li><a href="index.php" class="active">Home</a></li>
          <li><a href="#">Timeline</a></li>
          <li><a href="./course_list.html">Courses</a></li>
          <li><a href="Quiz_course.html">Quizez</a></li>
          <li><a href="#">Sample Text</a></li>
        </ul>
      </div>
      <div class="linksRight">
      <?php if (isset($user)) : ?>
                <div class="profile-image">
                    <div class="profile-initials">
                        <p><?= htmlspecialchars($initials) ?></p>
                    </div>
                </div>
                <div class="profile-tick">
                    <a href="./admin_page_info.php">&#9660</a>
                </div>
            <?php endif; ?>
      </div>
    </div>
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
                    <?php if(isset($user)): ?>
                    <?="<h3>" . htmlspecialchars("Welcome back, " . $user["forename"]) . "!</h3>" ?>
                    <?php endif; ?>
                    <ul>
                        <li><a href="#test1">Change Username</a></li>
                        <li><button class="trigger">Change Email</button></li>
                        <li><a href="#test2">Change Password</a></li>
                    </ul>
                </div>
              </div>
            </div>
            <div class="right-content">
              <div class="container-user">
                <div class="title-underline">
                    <span>User Details</span>
                </div>
                <div class="user-information">
                    <ul>
                        <li><a href="./register_page.php">Add User</a></li>
                        <li><a href="#">Select User</a></li>
                        <li><a href="#">Delete User</a></li>
                    </ul>
                </div>
              </div>
              <div class="container-course">
                <div class="title-underline">
                    <span>Course Details</span>
                </div>
                <div class="course-information">
                    <ul>
                        <li><a href="#">Add Course</a></li>
                        <li><a href="#">Select Course</a></li>
                        <li><a href="#">Delete Course</a></li>
                    </ul>
                </div>
              </div>
            </div>
          </div>
          <h3>Sample Text</h3>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
            ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip ex ea commodo consequat. Duis aute irure dolor in
            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
            pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
            culpa qui officia deserunt mollit anim id est laborum.
          </p>   
        </div>
      </div>
    </div>
  </body>
</html>
