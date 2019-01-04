<?php include 'connect.php'; ?>
<html lang="en">
<!-- HTML Commenting is done this way -->
<body>
	<?php
	$tid = (int)$_POST['tid'];
	$sql = "UPDATE User SET banned = 1 WHERE tid = $tid;";
	mysqli_query($conn, $sql);
	echo "
	<script type='text/javascript'>
	window.location='reported_posts.php';
	</script>";
	?>
</body>
</html>
