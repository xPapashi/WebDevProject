<?php
// check if file was uploaded
if (isset($_FILES["quizFile"]) && $_FILES["quizFile"]["error"] == 0) {
  // read contents of file
  $fileContents = file_get_contents($_FILES["quizFile"]["tmp_name"]);
  // split file contents into lines
  $lines = explode("\n", $fileContents);
  $questions = array(); // array to hold questions
  $answers = array(); // array to hold answers
  $correctAnswers = array(); // array to hold correct answers
  $currentQuestion = ""; // variable to hold current question
  foreach ($lines as $line) {
    if (substr($line, 0, 2) == "Q.") {
      // new question found, add previous question to questions array
      if ($currentQuestion != "") {
        $questions[] = $currentQuestion;
      }
      // start new question
      $currentQuestion = $line;
    } else if (substr($line, 0, 2) == "A.") {
      // answer found, add to answers array
      $answers[] = $line;
    } else if (substr($line, 0, 2) == "C.") {
      // correct answer found, add to correctAnswers array
      $correctAnswers[] = $line;
    } else if ($line == "") {
      // end of question found, add current question to questions array
      if ($currentQuestion != "") {
        $questions[] = $currentQuestion;
        $currentQuestion = "";
      }
    }
  }
  // connect to database
  $mysqli = new mysqli("localhost", "root", "", "acetraining");
  // insert questions into database
  foreach ($questions as $question) {
    $mysqli->query("INSERT INTO questions (Question) VALUES ('$question')");
    $questionId = $mysqli->insert_id;
    // insert answers into database
    for ($i = 0; $i < 4; $i++) {
      $answer = $answers[$i + ($questionId - 1) * 4];
      $isCorrect = $correctAnswers[$i + ($questionId - 1) * 4] == "C.1";
      $mysqli->query("INSERT INTO choices (question_no, Text, correct) VALUES ($questionId, '$answer', $isCorrect)");
    }
  }
  echo "Quiz uploaded successfully!";
} else {
  echo "Error uploading";
}