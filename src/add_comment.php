<?php include 'connect.php'; ?>
<html lang="en">
<!-- HTML Commenting is done this way -->
<body>
	<?php
	$post_id = (int)$_GET['post_id'];
	$tid = (int)$_SESSION['tid'];
	$comment = $_POST['comment'];
	$sql = "SELECT max(comment_id) from Comment_Write;";
	$ncomment = mysqli_fetch_assoc(mysqli_query($conn, $sql));
	$comment_id = (int)($ncomment['max(comment_id)']);
	$comment_id = $comment_id + 1;
	$sql = "INSERT INTO Comment_Write VALUES($tid, $comment_id, $post_id, \"$comment\");";
	mysqli_query($conn, $sql);
	echo "
	<script type='text/javascript'>
	window.location='newsfeed.php';
	</script>";
	?>
</body>
</html>
