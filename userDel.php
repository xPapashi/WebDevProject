<?php
    session_start();

    $mysqli = require __DIR__ . "/db.php";

    if (isset($_SESSION["user_id"]) and ($_SESSION["userType"] === "Admin") || ($_SESSION['userType'] === "Tutor")) {
        $id = $_POST['userId'];
        $sql = "DELETE FROM users WHERE id='$id'";
        $result = $mysqli->query($sql);

        if ($mysqli->affected_rows == 1) {
            echo "<span style='color: green;'>You have successfully deleted user id: $id!</span>";
        } else {
            echo "<span style='color: red;'>Error: ". $mysqli->error . "</span>";
        }
    } else {
        echo "<span style='color: red;'>Something went wrong! Error: ". $mysqli->error . "</span>";
    }
?>