<?php
    session_start();

    $mysqli = require __DIR__ . "/db.php";

    if (isset($_SESSION["user_id"]) and ($_SESSION["userType"] === "Admin") || ($_SESSION['userType'] === "Tutor")) {
        $id = $_POST['userId'];
        $sql = "UPDATE users SET authorisation='1' WHERE id='$id' AND authorisation='0'";
        $result = $mysqli->query($sql);

        if ($mysqli->affected_rows == 1) {
            echo "<span style='color: green;'>You have successfully authorised user id: $id!</span>";
        } else {
            echo "<span style='color: red;'>Error while trying to authroise! Error: ". $mysqli->error. "</span>";
        }
    } else {
        echo "<span style='color: red;'>Something went wrong! Error". $mysqli->error. "</span>";
    }
?>