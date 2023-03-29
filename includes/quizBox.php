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

      function takeQuiz($userEmail, $quizID, $score, $questionNum) {
        $mysqli = require __DIR__ . "../../db.php";
    
        // Check if the user has already taken this quiz
        $sql = "SELECT * FROM scores WHERE studentUsername = '$userEmail' AND quizID = '$quizID'";
        $result = $mysqli->query($sql);
    
        if ($result->num_rows > 0) {
            // User has already taken this quiz, update their score
            $sql = "UPDATE scores SET score = $score, questionNum = $questionNum WHERE studentUsername = '$userEmail' AND quizID = '$quizID'";
            if ($mysqli->query($sql) === TRUE) {
                echo "Quiz score updated successfully";
            } else {
                echo "Error updating quiz score: " . $mysqli->error;
            }
        } else {
            // User has not taken this quiz, insert their score
            $sql = "INSERT INTO scores (studentUsername, quizID, score, questionNum) VALUES ('$userEmail', '$quizID', $score, $questionNum)";
            if ($mysqli->query($sql) === TRUE) {
                echo "Quiz score inserted successfully";
            } else {
                echo "Error inserting quiz score: " . $mysqli->error;
            }
        }
    }
?>
