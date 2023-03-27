<?php
    if (isset($_SESSION["user_id"])) {
        $mysqli = require __DIR__ . "../../db.php";
        $user_id = $_SESSION["user_id"];
        $userType = $_SESSION['userType'];
        
        $sql = "SELECT courses.* FROM courses JOIN enroledStudents ON courses.id = enroledStudents.courseId 
        WHERE enroledStudents.studentUsername = (SELECT email FROM users WHERE id = $user_id) 
        AND enroledStudents.authorised = 1";

        $result = $mysqli->query($sql);
    }

    function getUserTypeCourse($user)
    {
        if ($user === "Admin") {
            return "./course_resources_display.php";
        } else if ($user === "Tutor") {
            return "./course_resources_display.php";
        } else if ($user === "Student") {
            return "./course_resources_display.php";
        }
    }
?>

<?php while ($course = $result->fetch_assoc()): ?>
    <div class="container-courses">
        <div class="course-img">
            <span>Insert IMG</span>
        </div>
        <div class="course-info">
            <a href="<?php echo getUserTypeCourse($userType); ?>"><?= $course["title"] ?></a>
        </div>
    </div>
<?php endwhile; ?>

<style>
    .alert {
        font-size: 24px;
        color: red;
    }
</style>

<?php 
    if ($result->num_rows == 0) {
        echo "<p class='alert'>No courses found!</p>";
    }
?>