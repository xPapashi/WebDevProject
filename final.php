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
    <script src="./js/quizapp.js" defer></script>
    <script
			  src="https://code.jquery.com/jquery-3.6.3.js"
			  integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
			  crossorigin="anonymous"></script>
              
  </head>
  <body onclick="closeNav(); closequizbox();">  
          <?php include 'includes/header.php'; ?>
    <div class="main" id=""> 
      <div class="container">
        <div class="content">
            <h1 class="heading" ><span id='main_heading'>Quiz Submitted!</span> </h1>
            <p class='quiz-header'> Your Quiz has been submitted. You can find your score below. </p>
            <div class="progress-container">
            <div class="bar" >01%</div>
            </div>
            <p> Score: 3 </p>
            <a class='button' href= "quiz.php"> Finish </a>
        </div>
      </div>
    </div>
  </body>
</html>
