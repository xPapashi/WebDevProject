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
    
    $questionNum = $_SESSION['questionNum'];

    function count_correct_answers($arr) {
      $count = 0;
      foreach ($arr as $key => $value) {
        if (strpos($key, 'correct') === 0 && !empty(trim($value))) {
          $count++;
        }
      }
      return $count;
    }

    extract($_POST);
    $score = count_correct_answers($_POST);

    function processQuiz($questionNum, $score) {
      $numQuestions = $questionNum;

      echo $score;

    }
    function percentage($score,$questionNum){
      $percentage = ($score/$questionNum)*100;
      echo $percentage;
      return $percentage; 
    }

    function saveQuizScore($score) {
      $mysqli = require __DIR__ . "/db.php";
      $qnum = $_SESSION['questionNum'];

      if (isset($_SESSION["user_id"])) {

          $email = $_SESSION['email'];
          $quizID = $_SESSION['quizID'];
          $_SESSION['finalScore'] = $score;
          
          $sql = "INSERT INTO scores (studentUsername, score, quizID, questionNum) VALUES ('$email', '$score', '$quizID', '$qnum')";
          $result = $mysqli->query($sql);

          if ($mysqli->affected_rows == 1) {
              echo "<span style='color: green;'>You have successfully deleted user id:</span>";
          } else {
              echo "<span style='color: red;'>Error: ". $mysqli->error . "</span>";
          }
      } else {
          echo "<span style='color: red;'>Something went wrong! Error: ". $mysqli->error . "</span>";
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
            <div class="bar" style='width: <?php percentage($score, $questionNum);?>%;'><?php percentage($score, $questionNum);?>%</div>
            </div>
            <p> Score: <?php processQuiz($questionNum, $score) ?></p>
            <a class='button' onclick="<?php saveQuizScore($score); ?>" href='quiz.php?'> Finish </a>
        </div>
      </div>
    </div>
  </body>
</html>
