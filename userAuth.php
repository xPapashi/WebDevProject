<?php
    session_start();

    $mysqli = require __DIR__ . "/db.php";

    if (isset($_SESSION["user_id"]) and ($_SESSION["userType"] === "Admin") || ($_SESSION['userType'] === "Tutor")) {
        $id = $_POST['userId'];
        $sql = "UPDATE users SET authorisation='1' WHERE id='$id' AND authorisation='0'";
        $result = $mysqli->query($sql);

        if ($mysqli->affected_rows == 1) {
            echo "Success";
        } else {
            echo "Error";
        }
    } else {
        echo "Unauthorized";
    }
?>