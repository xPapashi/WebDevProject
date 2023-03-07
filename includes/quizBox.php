<?php
    function generateQuizBox() {
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
                      <div class='progress-container'>
                      <div class='bar' > 01%</div>
                      </div>
                      <div class='button' ><a href='mockQuiz.php?q=$id&n=1'>Start</div></a>
                      ";
            echo "</div>";
        }
    }
?>
