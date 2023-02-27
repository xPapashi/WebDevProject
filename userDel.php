<?php
    session_start();

    $mysqli = require __DIR__ . "/db.php";

    if (isset($_SESSION["user_id"]) and ($_SESSION["userType"] === "Admin") || ($_SESSION['userType'] === "Tutor")) {
        $id = $_POST['userId'];
        $sql = "DELETE FROM users WHERE id='$id'";
        $result = $mysqli->query($sql);

        if ($mysqli->affected_rows == 1) {
            echo "Success";
        } else {
            echo "Error";
        }
    } else {
        echo "Something went wrong try again... " . $mysqli->error;
    }
?>