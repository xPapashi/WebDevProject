<?php
  session_start();

  require_once("./includes/quizBox.php");

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
    @$quizID = $_SESSION['quizID'];
    @$score = $_SESSION['finalScore'];
    
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
    <title>Quiz Page</title>
    <link rel="stylesheet" href="./style/quiz_style.css" />
    <script src="./js/quizapp.js" defer></script>
    <script
			  src="https://code.jquery.com/jquery-3.6.3.js"
			  integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
			  crossorigin="anonymous"></script>
    
    <script type = "text/javascript">
         $(document).ready(function() {
			 $("#CS").click(function(){
				document.getElementById("main_heading").innerHTML='Computer Science';
			});
			 $("#Net").click(function(){
				document.getElementById("main_heading").innerHTML='Networks';
			});
			 $("#Rob").click(function(){
				document.getElementById("main_heading").innerHTML='Robotics';
			});
       $("#SE").click(function(){
				document.getElementById("main_heading").innerHTML='Software Engineering';
			});
         });		 
      </script>

  </head>
  <body onclick="closeNav(); closequizbox();">  
          <?php include 'includes/header.php'; ?>
    </div>
    <div class="main" id="">
      <div class="container">
      <div class="container">
    <div class="content">
              <div class="heading"><span id='main_heading'>Quizzes</span></div>
              <div class="content-grid">
                  <?php generateQuizBox($user['email']);?>
                  <?php takeQuiz($user['email'], $quizID, $score, $questionNum); ?>
              </div>
              </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
