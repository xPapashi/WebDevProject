<?php
  session_start();

//Code that has to work
if (isset($_SESSION["user_id"]) && ($_SESSION['userType'] === "Student")) {
    $mysqli = require __DIR__ . "/db.php";
    $sql = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    $letter_forename = substr($user["forename"], 0, 1);
    $letter_surname = substr($user["surname"], 0, 1);
    $initials = $letter_forename . $letter_surname;
    $userType = $user["user"];

    $quiz =  (int) $_GET['q']; 

    $_SESSION['email'] = $user['email'];
    $_SESSION["user_initials"] = $initials;
    $_SESSION["userType"] = $userType;
    $_SESSION['quizID'] = $quiz;
    

    $sql = "SELECT * FROM quiz WHERE id = {$quiz}";
        $result = $mysqli->query($sql);
        $file = null;

        while ($row = $result->fetch_assoc()) { 
            extract($row);
            $file = $fileName;
        }

    

    function processQuiz($questionNum) {
        extract($_POST);
        $numQuestions = $questionNum;

        for ($i=1 ; $i<=$numQuestions ; $i++) {
            @$temp1 = "q" + $i;
            @$temp2 = "correct" + $i;
            echo "<p>You answered $temp1 to question 1.  The correct answer was $temp2.</p>";
        }

    }

    function displayQuiz($file) {

        $lines = file("quizzes/$file");
        $lineNum = 0;
        $questionNum = 0;
    
        echo "<form method='post' action='final.php'>";
    
        foreach ($lines as $line) {
            if (preg_match('/^(\d+)\.\s(.+)/', $line, $matches)) {
                $questionNum++;
                echo "<h4 style='color: blue; font-size: 17px;'>$line</h4>";
            } else if (preg_match('/^-\s/', $line)) {
                $answerNum = $lineNum % 5;
                $line = preg_replace('/^-\s/', '', $line);
                $line = preg_replace('/[^a-zA-Z0-9\s]/', '', $line); // remove special characters
                echo "<p><input type='radio' name='q$questionNum' value='$answerNum'/>";
                echo "$line</p>";
            } else if (preg_match('/^\*/', $line)){
                $line = preg_replace('/^\*/', '', $line);
                $line = preg_replace('/[^a-zA-Z0-9\s]/', '', $line); // remove special characters
                echo "<p><input type='radio' name='correct$questionNum' value='$line'/>";
                echo "$line</p>";
                echo "<input type='hidden' name='$line'/>";
            }
    
            $lineNum++;
        }
        $_SESSION['questionNum'] = $questionNum;
        echo "<input type='hidden' name='$questionNum'/>";
        echo "<input type='submit' value='SUBMIT YOUR ANSWERS'/>";
        echo "</form>";
        
    }

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

  </head>
  <body>  
          <?php include 'includes/header.php'; ?>
    </div>
    <div class="main" id="">
        <div class="container">
            <div class="container">
                <div class="box">
                    <div class="heading"><span id='main_heading'>Quiz <?= htmlspecialchars($id) ?> </span></div>
                    <?php displayQuiz($fileName);?>
                    <br></br>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>
