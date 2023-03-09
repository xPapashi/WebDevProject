<?php
    function displayUserScore($userEmail, $quizID) {
        $mysqli = require __DIR__ . "../../db.php";
      
        $sql = "SELECT * FROM scores WHERE studentUsername = '$userEmail' AND quizID = '$quizID'";
        $result = $mysqli->query($sql);
      
        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $score = $row['score'];
          $questionNum = $row['questionNum'];
          if ($score && $questionNum > 0) {
            $percentage = ($score / $questionNum) * 100;
          } else {
            $percentage = 0;
          }
          echo "<div class='bar' style='width: $percentage%;'>$percentage%</div>";
        } else {
          echo "<div class='bar' style='width: 0%'>0%</div>";
        }
      }
  

      function generateQuizBox($email) {
        $mysqli = require __DIR__ . "../../db.php";
      
        $sql = "SELECT * FROM quiz";
      
        $result = $mysqli->query($sql);
      
        while ($row = $result->fetch_assoc()) {
          $title = "Quiz ".$row['id'];
          $id =  $row['id'];
          echo "<div id='quiz$id' class='quiz' onclick='openquizbox()'>";
          echo"     <h1 class='quiz-header' id='Q$id'>$title</h1>
                      <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </div>
                      <bk></bk>
                      <div class='progress-container'>";
          echo        displayUserScore($email, $id);
          echo        "</div>
                      <div class='button' ><a href='Quiz_questions.php?q=$id'>Start</div></a>
                    ";
          echo "</div>";
        }
      }
?>
