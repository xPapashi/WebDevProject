<?php
    session_start();

    $mysqli = require __DIR__ . "/db.php";

    if (isset($_SESSION["user_id"]) and ($_SESSION["userType"] === "Admin") || ($_SESSION['userType'] === "Tutor")) {
        // var_dump($_POST);
        $email = $_POST['userEmail'];
        $sql = "UPDATE enroledStudents SET authorised='1' WHERE studentUsername='$email'";
        $result = $mysqli->query($sql);

        if ($mysqli->affected_rows == 1) {
            echo "<span style='color: green;'>You have successfully authorised user $email</span>";
        } else {
            echo "<span style='color: red;'>FAILED TO AUTHORISE USER $email" . $mysqli->error . "</span>";
        }
    } else {
        echo "Unauthorized";
    }
?>