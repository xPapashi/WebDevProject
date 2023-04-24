<?php
  session_start();

  if (isset($_SESSION["user_id"]) && ($_SESSION["userType"] === "Tutor")
    || ($_SESSION["userType"] === "Admin")) {
    $mysqli = require __DIR__ . "/db.php";

    $sql = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    $letter_forename = substr($user["forename"], 0, 1);
    $letter_surname = substr($user["surname"], 0, 1);
    $initials = $letter_forename . $letter_surname;
    $userType = $user["user"];
    $email = $user["email"];

    $_SESSION["user_initials"] = $initials;
    $_SESSION["userType"] = $userType;

    $_SESSION["email"]= $email;
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
        <div class="container">
            <div class="container">
                <div class="box">
                    <div class="heading"><span id='main_heading'>Add a Quiz</span></div>
                    <br></br>
                    <?php
                        if (isset($_FILES["uploadFile"])) {
                          //print_r($_FILES["uploadFile"]);

                          extract($_FILES["uploadFile"]);
                          //echo $tmp_name;
                          $targetFile = "quizzes/$name";

                          $extension = substr($name, -3);
                          //if ($extension == "jpg") {....}

                          if ($size <= 5000000) {
                            if (move_uploaded_file($tmp_name, $targetFile)) {
                              echo "<p style='color: green;'>File $name succesfully uploaded.</p>";

                              $uploader = $_SESSION["email"];
                              $sql = "INSERT INTO quiz(fileName, uploader) VALUE('$name', '$uploader')";
                              if ($mysqli->query($sql) === TRUE) {
                                // echo "Table Created";
                              } else {
                                  echo "Error while creating table: " . $mysqli->error;
                              }
                            }
                            else {
                              echo "<p style='color: red;'>File $name failed to upload. Please try again.</p>";
                            }
                          }
                          else {
                              echo "<p style='color: red;'>File $name is too large!!</p>";
                          }

                        }


                        //$uploads = scandir("resources/");
                        //print_r($uploads);
                      ?>

                      <form method="post" action="Q_add.php" enctype="multipart/form-data">
                        <label for="uploadFile">Select a file: </label>
                        <input type="file" name="uploadFile"/>
                        <br/>
                        <input style=align:right; type="submit" value="UPLOAD FILE"/>
                      </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>
