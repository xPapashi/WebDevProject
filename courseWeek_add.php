<?php
session_start();

    require_once("./includes/userCourse.php");
    $initials = $_SESSION['initials'];
    function generateCourses() {
        $mysqli = require __DIR__ . "/db.php";
        
        $user_id = $_SESSION['user_id'];

        $sql = "SELECT courses.* FROM courses JOIN enroledStudents ON courses.id = enroledStudents.courseId 
            WHERE enroledStudents.studentUsername = (SELECT email FROM users WHERE id = $user_id) 
            AND enroledStudents.authorised = 1";

        $result = $mysqli->query($sql);

        echo "<select name='course' id='course'>";
        while ($row = $result->fetch_assoc()) {
            $title = $row['title'];
            $id = $row['id'];
            echo "<option value='$id'>$title</option>";
        }
        echo "</select>";
    }

    if (isset($_SESSION["user_id"]) && ($_SESSION["userType"] === "Admin" || $_SESSION["userType"] === "Tutor")) {
        $mysqli = require __DIR__ . "/db.php";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $courseId = $_POST["course"];
            $weekHeading = $_POST["weekHeading"];
            $weekDescription = $_POST["weekDescription"];

            // Insert data into database
            $sql = "INSERT INTO weeks (courseId, heading, description) VALUES ('$courseId', '$weekHeading', '$weekDescription')";

            if ($mysqli->query($sql) === TRUE) {
                $answer = "Week added successfully!";
            } else {
                $answer = "Error adding week: " . $mysqli->error;
            }
        }
    } else {
        header("Location: index.php");
        die();
    }
?>

<script>
    document.getElementById("status").innerHTML = "<?php echo $answer; ?>";
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/course_resources_style.css" />
    <title>Add Course Week</title>
</head>
<body>
<?php include('./includes/header.php'); ?>
    <div class="main">
      <div class="container">
        <div class="content" id="content">
          <div class="heading"><span>Course Resources</span></div>
          <h1>Add Week</h1>
          <div id="status" class="status">
            <form id="weekForm" method="post">
                <div>
                    <label for="course">Course:</label>
                    <?php generateCourses(); ?>
                    <br><br>
                </div>
                <div>
                    <label for="weekHeading">Week Heading:</label>
                    <input type="text" name="weekHeading" id="weekHeading" required>
                    <br><br>
                </div>
                <div>
                    <label for="weekDescription">Week Description:</label>
                    <textarea name="weekDescription" id="weekDescription" required></textarea>
                    <br><br>
                </div>
                <script type = "text/javascript">  
                var form = document.getElementById('weekForm');
                function Alert() {
                if (form.checkValidity()) {
                alert("Adding Succesful!");
                }   
                }  
                </script>   
                <button type="submit" onclick="Alert()">Add Week</button>
                
            </form>
          </div>
        </div>
      </div>
    </div>
</body>
</html>