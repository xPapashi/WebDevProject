<?php
session_start();

if (isset($_GET["courseId"])) {
  $courseId = $_GET["courseId"];

  // query the database for the weeks for the selected course
  $mysqli = require __DIR__ . "/db.php";
  $sql = "SELECT * FROM weeks WHERE courseId = $courseId";
  $result = $mysqli->query($sql);

  // generate HTML options for the weeks and return them
  $options = "";
  while ($row = $result->fetch_assoc()) {
    $heading = $row["heading"];
    $id = $row["id"];
    $options .= "<option value='$id'>$heading</option>";
  }
  echo $options;
}
?>