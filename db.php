<?php
    $host = 'localhost';
    $dbname = 'acetraining';
    $mainTable = 'users';
    $coursesTable = 'courses';
    $enroledUsers = 'enroledStudents';
    $username = 'root';
    $password = '';
    
    $resources = 'resources';
    $weeks = 'weeks';
    $weeksResources = "weeksResources";

    $Questiontable = 'questions';
    $qTable = 'quiz';
    $quizScore= 'scores';
    $Qtable = 'choices';


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

    $query = "CREATE TABLE IF NOT EXISTS $mainTable (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        forename varchar(100) NOT NULL,
        surname varchar(100) NOT NULL,
        email varchar(255) NOT NULL UNIQUE,
        password varchar(100) NOT NULL,
        user varchar(100) NOT NULL,
        authorisation boolean NOT NULL
    )";

    if ($mysqli->query($query) === TRUE) {
        // echo "Table Created";
    } else {
        echo "Error while creating table: " . $mysqli->error;
    }

    $query = "CREATE TABLE IF NOT EXISTS $coursesTable (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        owner CHAR(255))";

    if ($mysqli->query($query) === TRUE) {
        // echo "Table Created";
    } else {
        echo "Error while creating table: " . $mysqli->error;
    }

    $query = "CREATE TABLE IF NOT EXISTS $enroledUsers (
        studentUsername VARCHAR(255) NOT NULL,
        courseId INT UNSIGNED NOT NULL,
        authorised TINYINT,
        FOREIGN KEY (studentUsername)
            REFERENCES users(email)
            ON UPDATE CASCADE
            ON DELETE CASCADE,
        FOREIGN KEY (courseId)
            REFERENCES courses(id)
            ON UPDATE CASCADE
            ON DELETE CASCADE
    )";

    if ($mysqli->query($query) === TRUE) {
        // echo "Table Created";
    } else {
        echo "Error while creating table: " . $mysqli->error;
    }

    $query = "CREATE TABLE IF NOT EXISTS $resources (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        fileName VARCHAR(255) NOT NULL,
        uploader VARCHAR(255) NOT NULL,
        uploadDate DATE NOT NULL,
        courseId INT UNSIGNED NOT NULL,
        FOREIGN KEY (courseId)
            REFERENCES courses(id)
            ON UPDATE CASCADE
            ON DELETE CASCADE
    )";

    if ($mysqli->query($query) === TRUE) {
        // echo "Table Created";
    } else {
        echo "Error while creating table: " . $mysqli->error;
    }

    $query = "CREATE TABLE IF NOT EXISTS $weeks (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        courseId INT UNSIGNED NOT NULL,
        heading VARCHAR(255) NOT NULL,
        description text NOT NULL,
        FOREIGN KEY (courseId)
            REFERENCES courses(id)
            ON UPDATE CASCADE
            ON DELETE CASCADE
    )";

    if ($mysqli->query($query) === TRUE) {
        // echo "Table Created";
    } else {
        echo "Error while creating table: " . $mysqli->error;
    }

    $query = "CREATE TABLE IF NOT EXISTS $weeksResources (
        weekId INT UNSIGNED NOT NULL,
        resourceId INT UNSIGNED NOT NULL,
        FOREIGN KEY (weekId)
            REFERENCES weeks(id)
            ON UPDATE CASCADE
            ON DELETE CASCADE,
        FOREIGN KEY (resourceId)
            REFERENCES resources(id)
            ON UPDATE CASCADE
            ON DELETE CASCADE
    )";

    if ($mysqli->query($query) === TRUE) {
        // echo "Table Created";
    } else {
        echo "Error while creating table: " . $mysqli->error;
    }

    $query = "CREATE TABLE IF NOT EXISTS $qTable (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        fileName VARCHAR(255) NOT NULL,
		uploader VARCHAR(255) NOT NULL,
        FOREIGN KEY (uploader)
            REFERENCES users(email)
            ON UPDATE CASCADE
            ON DELETE CASCADE
    )";

    if ($mysqli->query($query) === TRUE) {
        // echo "Table Created";
    } else {
        echo "Error while creating table: " . $mysqli->error;
    }

    $query = "CREATE TABLE IF NOT EXISTS $quizScore (
        studentUsername VARCHAR(255) NOT NULL,
        score INT NOT NULL,
        quizID INT UNSIGNED NOT NULL,
        questionNum INT NOT NULL,
        FOREIGN KEY (studentUsername)
            REFERENCES users(email)
            ON UPDATE CASCADE,
        FOREIGN KEY (quizID)
            REFERENCES quiz(id)
            ON UPDATE CASCADE
            ON DELETE CASCADE
    )";

    if ($mysqli->query($query) === TRUE) {
        // echo "Table Created";
    } else {
        echo "Error while creating table: " . $mysqli->error;
    }


    return $mysqli;
?>