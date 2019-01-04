<?php include 'connect.php'; ?>
<html lang="en">
<!-- HTML Commenting is done this way -->
<body>
	<?php
	$post_id = (int)$_GET['post_id'];
	$tid = (int)$_SESSION['tid'];
	$sql = "INSERT INTO Post_Like VALUES($post_id, $tid);";
	mysqli_query($conn, $sql);
	echo "
	<script type='text/javascript'>
	window.location='newsfeed.php';
	</script>";
	?>
</body>
</html>
