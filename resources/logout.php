<?php
	$conn = mysqli_connect("localhost", "root", "root", "simplevle2023");
	$result = "";

	session_start();
	session_destroy();
?>

<?php $title = "Logout: Simple VLE"; include("includes/preamble.php");?>
<?php include("includes/header.php");?>
<?php include("includes/menu.php");?>

<div id="content">
	<h1>Logout of your account</h1>

	<p>You have successfully loggout out.</p>

</div>

<?php include("includes/postamble.php");?>
