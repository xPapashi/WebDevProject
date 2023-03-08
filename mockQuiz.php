<?php
  session_start();
//connection

// CODE THAT WORKS
//   if (isset($_SESSION["user_id"])) {
//     $mysqli = require __DIR__ . "/db.php";
//     $sql = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";

//     $result = $mysqli->query($sql);

//     $user = $result->fetch_assoc();

//     $letter_forename = substr($user["forename"], 0, 1);
//     $letter_surname = substr($user["surname"], 0, 1);
//     $initials = $letter_forename . $letter_surname;
//     $userType = $user["user"];

//     $_SESSION["user_initials"] = $initials;
//     $_SESSION["userType"] = $userType;
    
//     $quiz =  (int) $_GET['q']; 
//     $sql = "SELECT * FROM quiz WHERE id = {$quiz}";
//     $result = $mysqli->query($sql);

//     $number = (int) $_GET['n'];

//     while ($row = $result->fetch_assoc()) { 
//         extract($row);
        
//     }
    
//     $lines = file("./quizzes/$fileName");
//     function readQuizFromFile($fileName) {
//         $quizFile = file_get_contents('./quizzes/'.$fileName);
    
//         $quizzes = explode("\n\n", $quizFile);
    
//             foreach ($quizzes as $quiz) {
//                 $lines = explode("\n", $quiz);
    
//                 $title = array_shift($lines);
    
//                 echo "<div class='question'>\n";
    
//                 $questionNum = 1;
//                 foreach ($lines as $line) {
//                     if (preg_match('/^\d+.\s/', $line)) {
//                         $question = preg_replace('/^\d+.\s/', '', $line);
    
//                         echo "<div class='question'>\n";
//                         echo "<h3>Question $questionNum</h3>\n";
//                         echo "<p>$question</p>\n";
//                         $questionNum++;
//                     } elseif (preg_match('/^\s/', $line)) {
//                         $answer = preg_replace('/^\s/', '', $line);
//                         echo "<div class='answer correct'>$answer</div>\n";
//                     } elseif (preg_match('/^-\s/', $line)) {
//                         $answer = preg_replace('/^-\s/', '', $line);
//                         echo "<div class='answer'>$answer</div>\n";
//                     }
//                 }
//                 echo "</div>\n";
//             }
//         }
//   }


//TESTING SHIT OUT
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
    
    $quiz =  (int) $_GET['q']; 
    $sql = "SELECT * FROM quiz WHERE id = {$quiz}";
    $result = $mysqli->query($sql);

    $number = (int) $_GET['n'];

    while ($row = $result->fetch_assoc()) { 
        extract($row);
        
    }
    
    $lines = file("quizzes/$fileName");
    function readQuizFromFile($fileName, $currentQuestion = 1) {
        $quizFile = file_get_contents('./quizzes/'.$fileName);
        $quizzes = preg_split('/(?<=Quiz\d)\n/', $quizFile, -1, PREG_SPLIT_NO_EMPTY);
    
        foreach ($quizzes as $quiz) {
            $lines = explode("\n", $quiz);
            $title = array_shift($lines);
    
            echo "<div class='questions'>\n";
    
            $questionNum = 1;
            foreach ($lines as $line) {
                if (preg_match('/^(\d+)\.\s(.+)/', $line, $matches)) {
                    if ($questionNum != 1) {
                        echo "</div>\n"; // close previous question div
                    }
                    $question = $matches[2];
                    echo "<div class='question'>\n";
                    echo "<h3>Question $questionNum</h3>\n";
                    echo "<p>$question</p>\n";
                    $questionNum++;
                } elseif (preg_match('/^\*/', $line)) {
                    $answer = preg_replace('/^\*/', '', $line);
                    echo "<div class='answer correct'>$answer</div>\n";
                } elseif (preg_match('/^-\s/', $line)) {
                    $answer = preg_replace('/^-\s/', '', $line);
                    echo "<div class='answer'>$answer</div>\n";
                } elseif (preg_match('/^Quiz(\d+)/', $line, $matches)) {
                    // Stop reading the file when the next quiz is encountered
                    break;
                }
            }
            echo "</div>\n"; // close last question div
            // Add a button to move to the next question when the quiz ends
            $nextQuestionNum = $currentQuestion + 1;
            $nextUrl = "mockQuiz.php?q=Quiz2&n=1"; // change the quiz and question number
            echo "<button class='next-btn' onclick='window.location.href=\"$nextUrl\"'>Next Question</button>\n";
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

  </head>
  <body onclick="closeNav(); closequizbox();">  
          <?php include 'includes/header.php'; ?>
    </div>
    <div class="main" id="">
        <div class="container">
            <div class="container">
                <div class="box">
                    <div class="heading"><span id='main_heading'>Quiz <?= htmlspecialchars($id) ?> </span></div>
                    <br></br>
                    <?php readQuizFromFile($fileName, 1); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>
