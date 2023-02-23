<?php
    session_start();


    $mysqli = require __DIR__ . "/db.php";
    // while ($row = $result->fetch_assoc()) {
    //     $users[] = $row;
    // }

    if (isset($_SESSION["user_id"]) and ($_SESSION["userType"] === "Admin")) {
        $sql = "SELECT * FROM users";
        $result = $mysqli->query($sql);

        $users = array();

        echo "<h3>Users Table:</h3>";
        echo "<table>
        <tr>
        <th>ID</th>
        <th>Forename</th>
        <th>Surname</th>
        <th>E-mail</th>
        <th>User Type</th>
        <th>Course</th>
        <th>Authorisation</th>
        </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["forename"] . "</td>";
            echo "<td>" . $row["surname"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["user"] . "</td>";
            echo "<td>" . $row["course"] . "</td>";
            echo "<td>" . $row["authorisation"] . "</td>";
            echo "</tr>";

        }
        echo "</table>";
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