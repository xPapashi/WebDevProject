<?php
    session_start();

    $mysqli = require __DIR__ . "/db.php";

    if (isset($_SESSION["user_id"]) and ($_SESSION["userType"] === "Admin") || ($_SESSION['userType'] === "Tutor")) {
        $id = $_POST['courseId'];
        $sql = "DELETE FROM courses WHERE id='$id'";
        $result = $mysqli->query($sql);

        if ($mysqli->affected_rows == 1) {
            echo "<span style='color: green;'>Successfully deleted course id: $id</span>";
        } else {
            echo "<span style='color: red;'>Error: " . $mysqli->error . "</span>";
        }
    } else {
        echo "Something went wrong try again... " . $mysqli->error;
    }
?>