 <!DOCTYPE html>
<html>
<body>
<?php
include 'connect.php';
$email = $_POST["email"];
$password = $_POST["password"];
$sql = "SELECT * FROM Admin WHERE admin_no = \"" . strtolower($email) . "\" AND password = \"$password\";";
$admin_result = mysqli_query($conn, $sql);

if (mysqli_num_rows($admin_result) > 0) {
	$user = mysqli_fetch_assoc($admin_result);
	$_SESSION['admin_no'] = $user['admin_no'];
	echo "<script type='text/javascript'>window.location='reported_posts.php'; </script>";
}

$sql = "SELECT * FROM User WHERE email = \"" . strtolower($email) . "\" AND password = \"$password\";";
$user_result = mysqli_query($conn, $sql);
if (mysqli_num_rows($user_result) <= 0) {
	  echo "<script type='text/javascript'>alert('Wrong username or password.');</script>";
	  header("Location: index.php");
		die();
}
else {
	session_start();
	$user = mysqli_fetch_assoc($user_result);
	if($user['banned'] == "1"){
		echo "<script type='text/javascript'>alert('User is banned.'); window.location='index.php'; </script>";
	}
	echo $user['tid'];
	$_SESSION['tid'] = $user['tid'];
	header("Location: football.php");
	die();
}

mysqli_close($conn);
?> 
</body>
</html> 
