<?php
  session_start();

  if (isset($_SESSION["user_id"]) && ($_SESSION["userType"] === "Tutor" || $_SESSION["userType"] === "Admin")) {
    $mysqli = require __DIR__ . "/db.php";

    if (isset($_SESSION["user_id"])) {
        $mysqli = require __DIR__ . "/db.php";
    
        $sql = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";
    
        $result = $mysqli->query($sql);
    
        $user = $result->fetch_assoc();
    
        $letter_forename = substr($user["forename"], 0, 1);
        $letter_surname = substr($user["surname"], 0, 1);
        $initials = $letter_forename . $letter_surname;
        $userType = $user["user"];
    }

    // If a quiz is selected, retrieve the quiz ID from the drop-down menu
    $quiz_id = isset($_POST['id']) ? $_POST['id'] : null;

    // If a quiz ID is specified, query the scores table for that quiz
    if ($quiz_id) {
      $sql = "SELECT * FROM scores WHERE `quizID` = $quiz_id";
      $result = $mysqli->query($sql);
      $scores = $result->fetch_all(MYSQLI_ASSOC);
    }

    $sql = "SELECT * FROM quiz";
    $result = $mysqli->query($sql);
    $quizzes = $result->fetch_all(MYSQLI_ASSOC);
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

  </head>
  <body onclick="closeNav(); closequizbox();">
    <?php include 'includes/header.php'; ?>
    </div>
    <div class="main" id="">
      <div class='container'>
        <div class='container'>
          <div class='box'>
            <form method="POST">
              <label for="id">Select Quiz:</label>
              <select name="id" id="id">
                <?php foreach ($quizzes as $quiz): ?>
                  <option value="<?= $quiz['id'] ?>"><?= $quiz['fileName'] ?></option>
                <?php endforeach; ?>
              </select>
              <button type="submit">Show Scores</button>
              <br></br>
            </form>
            <?php if ($scores): ?>
              <table>
                <thead>
                  <tr>
                    <th>Student ID</th>
                    <th>Quiz ID</th>
                    <th>Score</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($scores as $score): ?>
                    <tr>
                      <td><?= $score['studentUsername'] ?></td>
                      <td><?= $score['quizID'] ?></td>
                      <td><?= $score['score'] ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>