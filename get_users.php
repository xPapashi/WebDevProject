<?php
    session_start();


    $mysqli = require __DIR__ . "/db.php";
    // while ($row = $result->fetch_assoc()) {
    //     $users[] = $row;
    // }

    
    if (isset($_SESSION["user_id"]) and ($_SESSION["userType"] === "Admin")) {
        $selection = $_POST['selection'];
        
        if ($selection === "userAuth" || 
        $selection === "userDelete" || 
        $selection === "userEnrol" || 
        $selection === "userEnrolAuth") {
            if ($selection === "userEnrol") {
            $sql = "SELECT users.id, users.forename, users.surname, users.email, users.user, courses.title, 
            users.authorisation, enroledStudents.authorised FROM users
            INNER JOIN enroledStudents ON users.email = enroledStudents.studentUsername
            INNER JOIN courses ON enroledStudents.courseId = courses.id";
            } else if ($selection === "userEnrolAuth") {
                $sql = "SELECT users.id, users.forename, users.surname, users.email, users.user, courses.title, 
                users.authorisation, enroledStudents.authorised FROM users
                INNER JOIN enroledStudents ON users.email = enroledStudents.studentUsername
                INNER JOIN courses ON enroledStudents.courseId = courses.id
                WHERE enroledStudents.authorised = 0";
            }else {
                $sql = "SELECT * FROM users";
            }

            $result = $mysqli->query($sql);

            $users = array();

            echo "<h3>Users Table:</h3>";
            echo "<table>
            <tr>
            <th>ID</th>
            <th>Forename</th>
            <th>Surname</th>
            <th>E-mail</th>
            <th>User Type</th>";
            if ($selection === "userEnrol" ||
                $selection === "userEnrolAuth") {
            echo "<th>Course</th>";
            }
            echo "<th>Authorisation</th>
            </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["forename"] . "</td>";
                echo "<td>" . $row["surname"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["user"] . "</td>";
                if ($selection === "userEnrol" ||
                    $selection === "userEnrolAuth") {
                echo "<td>" . $row["title"] . "</td>";
                }
                if ($selection === "userEnrolAuth") {
                    echo "<td>" . $row["authorised"];
                } else if ($selection != "userEnrol" ||
                        $selection != "userEnrolAuth"){
                    echo "<td>" . $row["authorisation"] ;
                }
                if ($selection === "userAuth") {
                    echo "<button class='auth-btn' data-user-id='".$row["id"]. "'onclick='userAuth()'>Authorize</button></td>";
                } else if ($selection === "userDelete") {
                    echo "<button class='del-btn' data-user-id='".$row["id"]. "'onclick='userDel()'>Delete User</button></td>";
                } else if ($selection === "userEnrol") {
                    echo "<button class='select-btn' data-user-email='".$row["email"]."' onclick='showCourses()'>Select</button></td>";
                } else if ($selection === "userEnrolAuth") {
                    echo "<button class='courseAuth-btn' data-user-email='".$row["email"]."' onclick='userCourseAuth()'>Authorise</button></td>";
                }
                echo "</tr>";

            }
            echo "</table>";

            if ($selection === "userEnrol") {
                // Fetch all available courses
                $sql = "SELECT * FROM courses";
                $result = $mysqli->query($sql);
    
                $courses = array();
    
                
    
                // Display the list of courses in a hidden div
                echo "<div id='courses-list' style='display:none'>";
                echo "<h3>Available Courses</h3>";
                echo "<table>";
                echo "<tr>";
                echo "<th>Course ID</th>";
                echo "<th>Course Name</th>";
                echo "<th>Course Leader</th>";
                echo "<th>Enrol</th>";
                echo "</tr>";

                while ($row = $result->fetch_assoc()) {
                    extract($row);
                    echo "<tr>";
                    echo "<td>$id</td>";
                    echo "<td>$title</td>";
                    echo "<td>$owner</td>";
                    echo "<td>";
                    echo "<form id='enroll-form'>";
                    // echo "<input type='hidden' name='enrolCourseId' value='$id'/>";
                    echo "<input type='button' class='enrol-btn' data-course-id='$id' value='Enrol' onclick='userEnrol()'/>";
                    echo "</form>";
                    echo "</div>";
                }
            }
        }
    } else if (isset($_SESSION["user_id"]) and ($_SESSION["userType"] === "Tutor")) {
        $course = $_SESSION["course"];
        $sql = "SELECT * FROM users WHERE course='{$course}' AND 
        user='Student' AND 
        authorisation='0'";
        $result = $mysqli->query($sql);

        $users = array();
        echo "<h3>Unauthorised Users Table:</h3>";
        echo "<table>
        <tr>
        <th>ID</th>
        <th>Forename</th>
        <th>Surname</th>
        <th>E-mail</th>
        <th>Course</th>
        <th>Authorisation</th>
        </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["forename"] . "</td>";
            echo "<td>" . $row["surname"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["course"] . "</td>";
            echo "<td>" . $row["authorisation"] .
                "<button class='auth-btn' data-user-id='".$row["id"]."' onclick='userAuth()'>Authorize</button></td>";
            echo "</tr>";

        }
        echo "</table>";
    }
?>