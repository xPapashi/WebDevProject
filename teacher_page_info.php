<?php
session_start();

if (isset($_SESSION["user_id"]) and ($_SESSION["userType"] === "Tutor")) {
    $mysqli = require __DIR__ . "/db.php";

    $sql = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    $letter_forename = substr($user["forename"], 0, 1);
    $letter_surname = substr($user["surname"], 0, 1);
    $initials = $letter_forename . $letter_surname;
    $fullname = $user["forename"] . " " . $user["surname"];
    $email = strtolower($user["email"]);
    $course = $user["course"];

    $_SESSION["user_initials"] = $initials;
    $_SESSION["course"] = $course;
} else {
    header("Location: index.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Teacher Portal Page</title>
    <link rel="stylesheet" href="./style/teacher_page_style.css" />
    <script src="./js/app.js" defer></script>
    <script src="./js/handleUsers.js" defer></script>
    <script src="https://kit.fontawesome.com/031c7b0341.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include('./includes/header.php'); ?>
    <div class="main">
        <!-- <?php include('./includes/sidebar.php'); ?> -->
        <div class="container">
            <div class="content">
                <div class="heading"><span>Teacher Portal</span></div>
                <div class="content-grid">
                    <div class="left-content">
                        <div class="container-teacher">
                            <div class="title-underline">
                                <span>Teacher Details</span>
                            </div>
                            <div class="profile-shape">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div class="teacher-information">
                                <?php if (isset($user)) : ?>
                                    <?= "<h3>" . htmlspecialchars("Name: " . $fullname) . "</h3>" ?>
                                    <?= "<p>" . htmlspecialchars("E-mail: " . $email) . "</p>" ?>
                                    <?= "<p>" . htmlspecialchars("Course: " . $course) . "</p>" ?>
                                    <p>Country: United Kingdom</p>
                                    <p>City: Liverpool</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="right-content">
                        <div class="container-course">
                            <div class="title-underline">
                                <span>Course Details</span>
                                <button>Edit</button>
                            </div>
                            <div class="course-information">
                                <ul>
                                    <li><a href="#">Study Skills</a></li>
                                    <li><a href="#">Library 2023</a></li>
                                    <li><a href="#">Exploration in Computer Science Core 1</a></li>
                                    <li><a href="#">Exploration in Computer Science Core 2</a></li>
                                    <li><a href="#">School of Mathematics, Computer Science and Engineering</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="container-report">
                            <div class="title-underline">
                                <span>Overview Reports</span>
                            </div>
                            <div class="report-information">
                                <ul>
                                    <li><button class="trigger selectTrigger">Authorise Student</button></li>
                                    <li><a href="#">Set Grades</a></li>
                                    <li><a href="#">Set Quiz</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include('./includes/usersContainer.php'); ?>
                <h3>Sample Text</h3>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
                <p><a href="./logout.php">Logout</a></p>
            </div>
        </div>
    </div>
</body>

</html>