<?php include 'db.php';?>
<?php
$number = (int) $_GET['n'];
 $query =  "SELECT * FROM questions
               WHERE question_no = $number";
 $result = $mysqli->query($query) or die($mysqli->error.__LINE__);
 $question = $result->fetch_assoc();
 
  $query = "SELECT * FROM `questions`";
  $results = $mysqli->query($query) or die ($mysqli->error.__LINE__);
  $total = $results->num_rows;
?>
<?php
 $query =  "SELECT * FROM  choices WHERE question_no = $number";
 $choices = $mysqli->query($query) or die($mysqli->error.__LINE__);
?>
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
  <body>  
          <?php include 'includes/header.php'; ?>
    <div class="main" id=""> 
      <div class="container">
        <div class="content">
        <div class="heading" id='main_heading'><span>Computer Science Quiz 1</span></div>
        <div class="content-grid">
            <div id="quiz1" class="Quiz_Q_box" >
              <div class="question" > <?php echo $question["Question"]; ?> </div>
              <bk></bk>
              <form method="post" action="Qprocess.php">
                <ul class="inside-container">
                  <?php while ($row = $choices->fetch_assoc()): ?>
                    <input type="radio" name="choice" value="<?php echo $row["choice_ID"]; ?>"id="1" class="myinput large"/> <?php echo $row["Text"];?>
                    <br></br>
                  <?php endwhile; ?>
                  </ul>
              <input style="float:right;" type="submit" value="Next"/>
              <input type="hidden" name="number" value="<?php echo $number; ?>" />
            </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </body>
</html>
