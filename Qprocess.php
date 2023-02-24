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
        <div class="heading" id='main_heading'><span>Computer Science Quiz 1</span></div>
        <div class="content-grid">
            <div id="quiz1" class="Quiz_Q_box" >
              <div class="question" >Q1) What is Computational Thinking? </div>
              <bk></bk>
              <form method="post" action="Qprocess.php">
                <ul class="inside-container">
                  <label><input type="radio" name="choice" id="1" class="myinput large"> Answer 1 <br></label>
                  <br>
                  <label><input type="radio" name="choice" id="2" class="myinput large"> Answer 2 <br></label>
                  <br>
                  <label><input type="radio" name="choice" id="3" class="myinput large"> Answer 3 <br></label>
                  <br>
                  <label><input type="radio" name="choice" id="4" class="myinput large"> Answer 4 <br></label>
                </ul>
              </form>
              <div class="button" ><a>Next</div></a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </body>
</html>
