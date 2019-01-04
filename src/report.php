<?php include 'connect.php'; ?>
<html lang="en">
<!-- HTML Commenting is done this way -->
<body>
	<?php
	$post_id = (int)$_GET['post_id'];
	$sql = "UPDATE Post SET reported = 1 WHERE post_id = $post_id;";
	mysqli_query($conn, $sql);
	echo "
	<script type='text/javascript'>
	alert(\"Post Reported Successfully!\");
	window.location='newsfeed.php';
	</script>";
	?>
</body>
</html>
