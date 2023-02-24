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
    <title>Quiz Page</title>
    <link rel="stylesheet" href="./style/quiz_style.css" />
    <script src="./quizapp.js" defer></script>

  </head>
  <body onclick="closeNav(); closequizbox();">  
          <?php include 'includes/header.php'; ?>
    </div>
    <div class="main" id="">
        <div class="container">
            <div class="container">
                <div class="box">
                    <div class="heading"><span id='main_heading'>Add a Quiz</span></div>
                        <form>
                            <p>
                                <label> Quiz No. : </label>
                                <input type="number" name="Quiz_no."/>
                            </p>
                            <p>
                                <label> Question No. : </label>
                                <input type="number" name="Q_no."/>
                            </p>
                            <p>
                                <label> Question : </label>
                                <input type="text" name="Qt"/>
                            </p>
                            <p>
                                <label> Choice 1 : </label>
                                <input type="text" name="choice1"/>
                            </p>
                            <p>
                                <label> Choice 2 : </label>
                                <input type="text" name="choice2"/>
                            </p>
                            <p>
                                <label> Choice 3 : </label>
                                <input type="text" name="choice3"/>
                            </p>
                            <p>
                                <label> Choice 4 : </label>
                                <input type="text" name="choice4"/>
                            </p>
                            <p>
                                <label> Choice 5 : </label>
                                <input type="text" name="choice5"/>
                            </p>
                            <p>
                                <label> Correct Choice : </label>
                                <input type="number" name="cc"/>
                            </p>
                            <p>
                                <input type="submit" name="submit" value="Submit"/>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>
