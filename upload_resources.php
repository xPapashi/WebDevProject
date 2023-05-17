<?php
	if(!isset($_SESSION)){ 
        session_start(); 
    }
    $mysqli = require __DIR__ . "/db.php";

$verifyMsg = [];

if (isset($_POST['submit'])){
    if(isset($_FILES['uploadFile'])) {
        extract($_FILES['uploadFile']);
        
        $target = "./resources/$name";
        $uploader = $_SESSION['email'];
        $uploadDate = $_POST['uploadDate'];
        list($userCourseId, $userCourse) = explode(',', $_POST['course']);
        $week = $_POST['week'];

        $extension = substr($name, -3);

        
        if ($size <= 5000000) {
            if (move_uploaded_file($tmp_name, $target)) {
                $verifyMsg = "<p style='color: green'>File $name has been successfully uploaded!</p>";
                echo "<script>showMessage('$verifyMsg')</script>";
                $sql = "INSERT INTO resources(filename, uploader, uploadDate, courseId) VALUE ('$name', '$uploader', DATE('$uploadDate'), '$userCourseId')";
                $result = $mysqli->query($sql);

                $sql = "SELECT id FROM resources WHERE fileName = '$name'";
                $result = $mysqli->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $resourceId = $row['id'];
                }
                $sql = "INSERT INTO weeksresources(weekId, resourceId) VALUES ('$week', '$resourceId')";
                $result = $mysqli->query($sql);

            } else {
                $verifyMsg = "<p style='color: red;'>File $name failed to upload. Please try again.</p>";
                echo "<script>showMessage('$verifyMsg')</script>";
            }
        } else {
            $verifyMsg = "<p style='color: red;'>File $name is too large!!!</p>";
            echo "<script>showMessage('$verifyMsg')</script>";
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


if ($verifyMsg){
    var_dump($verifyMsg);
}

if (isset($_POST['submit'])) {
  echo "<script>showMessage('$verifyMsg')</script>";
}

?>