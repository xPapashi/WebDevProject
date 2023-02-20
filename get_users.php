<?php

    $mysqli = require __DIR__ . "/db.php";

    $sql = "SELECT * FROM users";
    $result = $mysqli->query($sql);

    $users = array();
    // while ($row = $result->fetch_assoc()) {
    //     $users[] = $row;
    // }

    echo "<table>
    <tr>
    <th>ID</th>
    <th>Forename</th>
    <th>Surname</th>
    <th>E-mail</th>
    <th>Password</th>
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
        echo "<td>" . $row["password"] . "</td>";
        echo "<td>" . $row["user"] . "</td>";
        echo "<td>" . $row["course"] . "</td>";
        echo "<td>" . $row["authorisation"] . "</td>";
        echo "</tr>";

    }
    echo "</table>";

?>