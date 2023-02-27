<?php
    session_start();

    $mysqli = require __DIR__ . "/db.php";

    
    if (isset($_SESSION["user_id"]) and ($_SESSION["userType"] === "Admin")) {
        $sql = "SELECT * FROM courses";
        $result = $mysqli->query($sql);

        $courses = array();
        $selection = $_POST['selection'];

        if ($selection === 'courseAdd') {
            echo "<form class='course-form'>";
            echo    "<label for='course-name'>Course name:</label>";
            echo    "<input type='text' id='course-name' name='course-name'/>";
            echo    "<input type='button' value='CREATE COURSE' onclick='addCourse()'/>";
            echo "</form>";
        }

        echo "<h3>Courses Table:</h3>";
        echo "<table>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Title</th>";
        echo "<th>Owner</th>";
        if ($selection === "courseDelete") {
            echo "<th>Delete</th>";
        }
        echo "</tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["title"] . "</td>";
            echo "<td>" . $row["owner"] . "</td>";
            if ($selection === "courseDelete") {
                echo "<td>" . "<button class='course-del-btn' data-course-id='".$row["id"]. "'onclick='courseDel()'>Delete</button>" . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }
?>