<?php
	$conn = mysqli_connect("localhost", "root", "root", "simplevle2023");
	$result = "";

	session_start();

	if (is_numeric($_SESSION["loginUsername"])) header("Location: index.php"); 


function attachFile($file, $message, $header) {
$semi_rand = md5(time()); 
$mime_boundary = 
"==Multipart_Boundary_x{$semi_rand}x"; 
$header .= "\nMIME-Version: 1.0\n" . "ContentType: multipart/mixed;\n" . " 
boundary=\"{$mime_boundary}\"";
$message = "--{$mime_boundary}\n" . "Content-Type: 
text/html; charset=\"UTF-8\"\n" . 
"Content-Transfer-Encoding: 7bit\n\n" . $message . 
"\n\n";
if(!empty($file) > 0){ 
 if(is_file($file)){ 
 $message .= "--{$mime_boundary}\n"; 
 $fp = @fopen($file,"rb"); 
 $data = @fread($fp,filesize($file)); 
 @fclose($fp); 
 $data = 
chunk_split(base64_encode($data)); 
 $message .= "Content-Type: 
application/octet-stream; 
name=\"".basename($file)."\"\n" . 
 "Content-Description: 
".basename($file)."\n" . 
 "Content-Disposition: attachment;\n" . " 
filename=\"".basename($file)."\"; 
size=".filesize($file).";\n" . 
 "Content-Transfer-Encoding: base64\n\n" . 
$data . "\n\n"; 
 } 
} 
$message .= "--{$mime_boundary}--"; 
}

?>

<?php $title = "Tutor Page"; include("includes/preamble.php");?>
<?php include("includes/header.php");?>
<?php include("includes/menu.php");?>

<div id="content">
	<h1>Tutor Page</h1>

	<h2>Authorise Student Registrations</h2>

	<?php
		if (isset($_POST["authoriseUsername"])) {
			extract($_POST);

			$sql = "UPDATE users
					SET authorised='1'
					WHERE username='$authoriseUsername'";
			if (mysqli_query($conn, $sql)) {
				echo "<p style='color: green'>Student $authoriseUsername has been successfully authorised.</p>";
			}
			else {
				echo "<p style='color: red'>Student $authoriseUsername FAILED to be authorised.  Please try again or contact the administrator</p>";
			}

		} 
	?>	

	<table border="1">
		<tr>
			<th>Username</th>
			<th>Forename</th>
			<th>Surname</th>
			<th>Action</th>
		</tr>

		<?php
			$sql = "SELECT * FROM users 
					WHERE authorised='0'";
			$data = mysqli_query($conn, $sql) or die(mysqli_error($conn));

			while ($row = mysqli_fetch_assoc($data)) {
				extract($row);
				echo "<tr>
						<td>$username</td>
						<td>$forename</td>
						<td>$surname</td>
						<td>
							<form method='post' action='tutor_page.php'>
								<input type='hidden' name='authoriseUsername' value='$username'/>
								<input type='submit' value='AUTHORISE'/>
							</form>
						</td>
				      </tr>";
			}
		?>
	</table>


	<h2>Create a New Course</h2>
	<p>Use this to create courses.</p>

	<?php
		if (isset($_POST["createCourseName"])) {
			$courseName = mysqli_real_escape_string($conn, $_POST["createCourseName"]);
			$owner = $_SESSION["loginUsername"];

			$sql = "INSERT INTO courses(title, owner)
					VALUES('$courseName', '$owner')";
			if (mysqli_query($conn, $sql)) {
				echo "<p style='color: green;'>Course $courseName successfully created.</p>";
			}
			else {
				echo "<p style='color: red;'>COURSE $courseName FAILED TO BE CREATED: " . mysqli_error($conn) . ".</p>";
			}
		}
	?>


	<form method="post" action="tutor_page.php">
		<label for="createCourseName">Course name:</label>
		<input type="text" name="createCourseName"/>
		<br/>
		<input type="submit" value="CREATE COURSE"/>
	</form>





	<h2>Authorise Student Enrollments</h2>

	<?php
		if (isset($_POST["enrolAuthoriseStudentUsername"])) {
			extract($_POST);

			$sql = "UPDATE studentsOnCourses
					SET authorised='1'
					WHERE studentUsername='$enrolAuthoriseStudentUsername'
					AND courseId='enrolAuthoriseCourseId'";
			if (mysqli_query($conn, $sql)) {
				echo "<p style='color: green'>Student $enrolAuthoriseStudentUsername has been successfully enrolled onto course id $enrolAuthoriseCourseId.</p>";
			}
			else {
				echo "<p style='color: red'>Student $enrolAuthoriseStudentUsername FAILED to be authorised onto course id $enrolAuthoriseCourseId.  Please try again or contact the administrator." . mysqli_error($conn) . "</p>";
			}



		} 
	?>	

	<table border="1">
		<tr>
			<th>Student Id</th>
			<th>Course Id</th>
		</tr>

		<?php
			$sql = "SELECT * FROM studentsOnCourses 
					WHERE authorised='0'";
			$data = mysqli_query($conn, $sql) or die(mysqli_error($conn));

			while ($row = mysqli_fetch_assoc($data)) {
				extract($row);
				echo "<tr>
						<td>$studentUsername</td>
						<td>$courseId</td>
						<td>
							<form method='post' action='tutor_page.php'>
								<input type='hidden' name='enrolAuthoriseStudentUsername' value='$studentUsername'/>
								<input type='hidden' name='enrolAuthoriseCourseId' value='$courseId'/>
								<input type='submit' value='AUTHORISE'/>
							</form>
						</td>
				      </tr>";
			}
		?>
	</table>


	<h2>Upload Resources</h2>
	<p>.....</p>

	<?php
		if (isset($_FILES["uploadFile"])) {
			//print_r($_FILES["uploadFile"]);

			extract($_FILES["uploadFile"]);
			//echo $tmp_name;
			$targetFile = "resources/$name";

			$extension = substr($name, -3);
			//if ($extension == "jpg") {....}

			if ($size <= 5000000) {
				if (move_uploaded_file($tmp_name, $targetFile)) {
					echo "<p style='color: green;'>File $name succesfully uploaded.</p>";

					$uploader = $_SESSION["loginUsername"];
					$sql = "INSERT INTO resources(fileName, uploader) VALUE('$name', '$uploader')";
					mysqli_query($conn, $sql) or die(mysqli_error($conn));
				}
				else {
					echo "<p style='color: red;'>File $name failed to upload. Please try again.</p>";
				}
			}
			else {
					echo "<p style='color: red;'>File $name is too large!!</p>";
			}

		}


		//$uploads = scandir("resources/");
		//print_r($uploads);
	?>

	<form method="post" action="tutor_page.php" enctype="multipart/form-data">
		<label for="uploadFile">Select a file: </label>
		<input type="file" name="uploadFile"/>
		<br/>
		<input type="submit" value="UPLOAD FILE"/>
	</form>


	<h1>Email Students</h1>
	<p>.....</p>

	<?php
		if (isset($_POST["emailMessage"])) {
			$emailMessage = $_POST["emailMessage"];

			$mailTo = "08008783@hope.ac.uk";
			$subject = "Classes are as normal";
			//$message = "Despite the strikes, all classes are assumed to be going ahead.\nYou should come in!\nKind regards,\nNeil";
			$header = "From: bucklen@hope.ac.uk\r\nCC:someoneelse@hope.ac.uk;anotherperson@hope.ac.uk\r\nBCC:yetanotherperson@hope.ac.uk";

			/*
			extract($_FILES["attachment"]);

			if ($size <= 5000000) {
				if (move_uploaded_file($tmp_name, $targetFile)) {
					echo "<p style='color: green;'>File $name succesfully uploaded to be attached.</p>";

				}
				else {
					echo "<p style='color: red;'>File $name failed to upload for attachment. Please try again.</p>";
				}
			}
			else {
					echo "<p style='color: red;'>File $name is too large!!</p>";
			}
			*/

			//$emailMessage = attachFile("uploads/$targetFile", $emailMessage, $header);

			$numCookiesSet = sizeof($_COOKIE);

			$topics = array();
			$topics[] = "WebDev";
			$topics[] = "SE";
			$topics[] = "OOSD";

			$topics = serialize($topics);
			setcookie("topics", $topics, time() + 60*60);

			$topics = $_COOKIE["topics"];
			$topics = unserialize($topics);
			echo "<ol>";
			foreach ($topics as $topic) {
				echo "<li>$topic</li>";
			}
			echo "</ol>";

			if (isset($_COOKIE["emailSent"])) {
				$previousEmailSent = $_COOKIE["emailSent"];
				$allowAnotherEmail = false;
			}
			else {
				$allowAnotherEmail = true;
			}

			if ($allowAnotherEmail) {
				if (mail($mailTo, $subject, $emailMessage, $header)) {
					echo "<p style='color: green;'>Email successfully sent.</p>";


					setcookie("emailSent", $emailMessage, time() + 30);
				}
				else {
					echo "<p style='color: red;'>Email failed.  Please try again.</p>";
				}
			}
			else {
				echo "<p style='color: red'>Please wait before you send yet another email to those poor students!</p>";
			}
		}
	?>

	<form method="post" action="" enctype="multipart/form-data">
		<label for="emailMessage">Your message: </label>
		<textarea name="emailMessage" cols="50" rows="8"></textarea>
		<br/><br/>
		<label for="attachment">Attachment: </label>
		<input type="file" name="attachment"/>
		<br/><br/>		
		<input type="submit" value="SEND MESSAGE"/>


	</form>

</div>

<?php include("includes/postamble.php");?>
