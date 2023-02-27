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
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Main Page</title>
    <link rel="stylesheet" href="./style/index_style.css" />
    <script src="./js/app.js" defer></script>
    <script src="https://kit.fontawesome.com/031c7b0341.js" crossorigin="anonymous"></script>
  </head>
  <body onclick="closeNav()">
    <?php include './includes/header.php'; ?>
    <div class="main" id="">
      <!-- <?php include './includes/sidebar.php'; ?> -->
      <div class="container">
        <div class="content">
          <div class="heading"><span>Welcome to AceTraining</span></div>
          <div class="container-inner">
            <div class="container-updates">
              <div class="update-title"><span>Update 01/01/2002</span></div>
              <div class="description">
                <ul>
                  <li>Improved navigation bar</li>
                  <li>Faster load time</li>
                  <li>Database migration</li>
                  <li>Improved UI/Ux</li>
                  <li>Website policy update</li>
                </ul>
              </div>
            </div>
            <div class="container-updates">
              <div class="update-title"><span>Update 15/08/2001</span></div>
              <div class="description">
                <ul>
                  <li>Introduced dynamic courses</li>
                  <li>Responsive UI</li>
                  <li>Minor bug fixes related to sidebar</li>
                  <li>Blah Blah Blah</li>
                </ul>
              </div>
            </div>
          </div>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
            ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip ex ea commodo consequat. Duis aute irure dolor in
            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
            pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
            culpa qui officia deserunt mollit anim id est laborum.
          </p>
          <h3>This is just a sample text.</h3>
        </div>
      </div>
  </body>
</html>
