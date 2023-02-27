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

  if (isset($_SESSION['score'])){
    $_SESSION['score'] = 0;
  }

  if ($_POST){
    $number = $_POST['number'];
    $selected_choice = $_POST['choice'];
    $next = $number++;


    
    $query = "SELECT * FROM `CHOICE` WHERE question_number = $number AND is_correct = 1";

    $result = $mysqli->query($query) or die($mysqli->error.__LINE__);

    $row -$result-> fetch_assoc();

    $correct_choice= $row['id'];

    if($correct_choice == $selected_choice){
        $_SESSION['score']++
    }

    if ($number == $total){
        header("Location: final.php");
        exit();
    } else{
        header("Location: quiz_question.php?q=1&n=".$next);
    }
  }
?>
