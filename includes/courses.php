<?php
    function generateCourses() {
        $mysqli = require __DIR__ . "../../db.php";

        $sql = "SELECT * FROM courses";
    
        $result = $mysqli->query($sql);

        echo "<select name='course' id='course'>";
        while ($row = $result->fetch_assoc()) {
            $title = $row['title'];
            $id = $row['id'];
            echo "<option value='$id,$title'>$title</option>";
        }
        echo "</select>";
    }
?>