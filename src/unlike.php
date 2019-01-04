<?php include 'connect.php'; ?>
<html lang="en">
<!-- HTML Commenting is done this way -->
<body>
	<?php
	$post_id = (int)$_GET['post_id'];
	$tid = (int)$_SESSION['tid'];
	$sql = "DELETE FROM Post_Like WHERE post_id = $post_id and tid = $tid;";
	mysqli_query($conn, $sql);
	echo "
	<script type='text/javascript'>
	window.location='newsfeed.php';
	</script>";
	?>
</body>
</html>
