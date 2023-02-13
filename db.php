<?php
    $host = 'localhost';
    $dbname = 'acetraining';
    $table = 'users';
    $username = 'root';
    $password = '';

    $mysqli = new mysqli($host, $username, $password);

    if ($mysqli->connect_error) {
        echo("Connection error: " . $mysqli->connect_error);
    }
    
    $query = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($mysqli->query($query) === TRUE) {
        // echo "Database Created";
        mysqli_select_db($mysqli, $dbname);
    } else {
        echo "Error while creating database: " . $mysqli->error;
    }

    $query = "CREATE TABLE IF NOT EXISTS $table (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        forename varchar(100) NOT NULL,
        surname varchar(100) NOT NULL,
        email varchar(255) NOT NULL UNIQUE,
        password varchar(100) NOT NULL,
        user varchar(100) NOT NULL,
        course varchar(100) NOT NULL,
        authorisation int NOT NULL
    )";

    if ($mysqli->query($query) === TRUE) {
        // echo "Table Created";
    } else {
        echo "Error while creating table: " . $mysqli->error;
    }

    return $mysqli;
?>