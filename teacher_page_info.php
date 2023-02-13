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
    <script src="./app.js" defer></script>
    <script src="https://kit.fontawesome.com/031c7b0341.js" crossorigin="anonymous"></script>
</head>

<body onclick="closeNav()">
    <div class="header">
        <div class="linksLeft">
            <div class="logo"><a href="index.php">AceTraining</a></div>
            <div class="logo-separator"></div>
            <ul class="links">
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="#">Timeline</a></li>
                <li><a href="./course_list.html">Courses</a></li>
                <li><a href="#">Sample Text</a></li>
                <li><a href="#">Sample Text</a></li>
            </ul>
        </div>
        <div class="linksRight">
            <?php if (isset($user)) : ?>
                <div class="profile-image">
                    <div class="profile-initials">
                        <p><?= htmlspecialchars($initials) ?></p>
                    </div>
                </div>
                <div class="profile-tick">
                    <a href="./teacher_page_info.php">&#9660</a>
                </div>
            <?php else : ?>
                <p><a href="./login_page.php">Login <i class="fa-solid fa-user"></i></a></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="main">
        <div id="sidebar-icon" onclick="openNav()">&#9776</div>
        <div class="sidebar" id="mySideNav">
            <div class="sidebar-content">
                <div class="sidebar-title">Courses</div>
                <ul>
                    <li><a href="#CS" class="active-course">Computer Science</a></li>
                    <li><a href="#NET">Networking</a></li>
                    <li><a href="#Robo">Robotics</a></li>
                    <li><a href="#SE">Software Engineering</a></li>
                </ul>
            </div>
        </div>
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
                                <?php if(isset($user)): ?>
                                <?="<h3>" . htmlspecialchars("Name: " . $fullname) . "</h3>" ?>
                                <?="<p>" . htmlspecialchars("E-mail: " . $email) . "</p>" ?>
                                <?="<p>" . htmlspecialchars("Course: " . $course) . "</p>" ?>
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
                                    <li><a href="#">Set Grades</a></li>
                                    <li><a href="#">Set Quiz</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
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