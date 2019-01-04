 <!DOCTYPE html>
<html>
<body>
<?php
include 'connect.php';
$sql = "SELECT * FROM User WHERE tid = \"" . $_POST["tid"] . "\" or email =  \"" . strtolower($_POST["email"]) . "\";";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	  echo "<script type='text/javascript'>alert('User exists.'); window.location='registerpage.php'; </script>";
} else{
	$sql = "INSERT INTO User VALUES(" . $_POST["tid"] . ", \"" . $_POST["name"] . "\", \"" . $_POST["surname"] .
		"\", \"" . strtolower($_POST["email"]) . "\", \"" . $_POST["password"] . "\", \"" . $_POST["birthdate"] . "\", \"" . $_POST["phonenumber"] . "\", 0,0);";

	mysqli_query($conn, $sql);
}

header("Location: ./index.php");
die();

mysqli_close($conn);
?>

</body>
</html>
