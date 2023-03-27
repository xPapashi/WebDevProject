<?php
	session_start();
    $mysqli = require __DIR__ . "/db.php";


if (isset($_POST['submit'])){
    if(isset($_FILES['uploadFile'])) {
        extract($_FILES['uploadFile']);
        
        $target = "./resources/$name";
        $uploader = $_SESSION['email'];
        $uploadDate = $_POST['uploadDate'];
        list($userCourseId, $userCourse) = explode(',', $_POST['course']);

        $extension = substr($name, -3);

        if ($size <= 5000000) {
            if (move_uploaded_file($tmp_name, $target)) {
                echo "<p style='color: green'>File $name has been successfully uploaded!</p>";
                $sql = "INSERT INTO resources(filename, uploader, uploadDate, courseId) VALUE ('$name', '$uploader', DATE('$uploadDate'), '$userCourseId')";
                $result = $mysqli->query($sql);

            } else {
                echo "<p style='color: red;'>File $name failed to upload. Please try again.</p>";
            }
        } else {
            echo "<p style='color: red;'>File $name is too large!!!</p>";
        }
        
    }




    $sql = "SELECT * FROM resources;";
    $result = $mysqli->query($sql);

    echo "<h3>User Uploads</h3>";
    echo "<table>
    <tr>
    <th>ID</th>
    <th>FileName</th>
    <th>Uploader</th>
    </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['fileName'] . "</td>";
        echo "<td>" . $row['uploader'] . "</td>";
        echo "<td>" . $row['uploadDate'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>