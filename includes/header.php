<?php

    if (isset($_SESSION["user_id"])) {
        $mysqli = require __DIR__ . "../../db.php";

        $sql = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";

        $result = $mysqli->query($sql);

        $user = $result->fetch_assoc();

        $userType = $user["user"];
    }
    function getUserType($user)
    {
        if ($user === "Admin") {
            return "./admin_page_info.php";
        } else if ($user === "Tutor") {
            return "./teacher_page_info.php";
        } else if ($user === "Student") {
            return "./student_page_info.php";
        }
    }
?>

<div class="header">
    <div class="linksLeft">
        <div class="logo"><a href="./index.php">AceTraining</a></div>
        <div class="logo-separator"></div>
        <ul class="links">
            <li><a href="./index.php" class="active">Home</a></li>
            <li><a href="#">Timeline</a></li>
            <li><a href="./course_list.html">Courses</a></li>
            <li><a href="./Quiz_course.html">Quizez</a></li>
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
                <a href="<?php echo getUserType($userType); ?>">&#9660</a>
            </div>
        <?php else : ?>
            <p><a href="./login_page.php">Login <i class="fa-solid fa-user"></i></a></p>
        <?php endif; ?>
    </div>
</div>