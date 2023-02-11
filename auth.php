<?php 

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        die("Email is required!");
    }

    if (empty($_POST["password"])) {
        die("Password is required");
    }
    print_r($_POST);

    $mysqli = require __DIR__ . "/db.php";
?>