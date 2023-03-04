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

    $_SESSION['user_id'] = $user['id'];

  }

  if (isset($_SESSION['score'])){
    $_SESSION['score'] = 0;
  }
  ?>
<?php

  if ($_POST){
    $number = $_POST['number'];
    $selected_choice = $_POST['choice'];
    $next = $number+1;

    $query ="SELECT * FROM `scores`";
    $R_scores= $mysqli->query($query) or die ($mysqli->error.__LINE__); 

    /* gets the total amount of question that are stored in the database */
    $query = "SELECT * FROM `questions`";
    $results = $mysqli->query($query) or die ($mysqli->error.__LINE__);
    $total = $results->num_rows;

    $query = "SELECT 'quiz_ID' FROM `quiz` ";

    /* this will make sure that the choice that the user selects in the quiz is the 
    correct answer and if it is then it will store it in the database under score */
    $query = "SELECT * FROM `choices` WHERE question_no = $number AND correct = 1";

    $result = $mysqli->query($query) or die($mysqli->error.__LINE__);

    $row=$result-> fetch_assoc();

    $correct_choice= $row['choice_ID'];

    var_dump($_SESSION['user_id']);

    if($correct_choice == $selected_choice){
        $sql = "INSERT INTO scores(Student_id,Quiz_id) VALUES ('{$_SESSION['user_id']}','') ";
        $result = $mysqli->query($sql) or die($mysqli->error.__LINE__);
    }

    /* this will check for the total number against the question number that the user 
    is on so that the quiz ends when it runs out of questions in the database */
    if ($number == $total){
        header("Location: final.php");
        exit();
    } else{
        header("Location: quiz_questions.php?n=".$next);
    }
  }
?>
