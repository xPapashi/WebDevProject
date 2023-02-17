<?php
    session_start();

    if (isset($_SESSION["user_id"]) and ($_SESSION["userType"]) != "Admin") {
      header("Location: index.php");
      die();
    } else if (!isset($_SESSION["user_id"])) {
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
    <title>Main Page</title>
    <link rel="stylesheet" href="./style/register_user_ style.css" />
    <script src="./app.js" defer></script>
    <script
      src="https://kit.fontawesome.com/031c7b0341.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <div class="registerContainer">
      <h1><u>Register User</u></h1>
      <div class="contents">
        <form action="./process_reg.php" method="post" novalidate>
            <div class="contents1">
                <div class="forename">
                <div class="forenameLabel">
                <label for="forename"><h2>Forename:</h2></label>
                </div>
                <input
                    type="text"
                    id="forename"
                    name="forename"
                    placeholder="John"
                />
                </div>
                <div class="surname">
                <div class="surnameLabel">
                    <label for="surname"><h2>Surname:</h2></label>
                </div>
                <input
                    type="text"
                    id="surname"
                    name="surname"
                    placeholder="Smith"
                />
                </div>
            </div>
            <br>
            <div class="contents2">
                <div class="userType">
                <div class="userTypeLabel">
                    <label for="userType"><h2>User Type:</h2></label>
                </div>
                <select name="userType" id="userType">
                    <option value="Tutor">Tutor</option>
                    <option value="Student">Student</option>
                </select>
                </div>
                <div class="course">
                <div class="courseLabel">
                    <label for="course"><h2>Course:</h2></label>
                </div>
                <select name="course" id="course">
                    <option value="Computer Science">Computer Science</option>
                    <option value="Networks">Networks</option>
                    <option value="Robotics">Robotics</option>
                    <option value="AI">AI</option>
                </select>
                </div>
            </div>
            <br />
            <input class="submitButton" type="submit" name="submit" id="submit" />
        </form>
      </div>
    </div>
  </body>
</html>