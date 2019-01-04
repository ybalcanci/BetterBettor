<?php include 'connect.php'; ?>
<html lang="en">
<!-- HTML Commenting is done this way -->
<body>
	<?php
	include 'connect.php';
	$coupon_id = (int)$_GET['coupon_id'];
	$tid = (int)$_SESSION['tid'];
	$sql = "SELECT max(post_id) from Post;";
	$post = mysqli_fetch_assoc(mysqli_query($conn, $sql));
	$post_id = (int)($post['max(post_id)']);
	$post_id = $post_id + 1;
	$sql = "INSERT INTO Post VALUES($post_id, $tid, \"".date("Y.m.d")."\", \"".date("h:i")."\", \"\", 0);";
	mysqli_query($conn, $sql);
	$sql = "INSERT INTO Post_Coupon VALUES($post_id, $coupon_id);";
	mysqli_query($conn, $sql);
	echo "<script type='text/javascript'>alert('Coupon is Shared Successfully');
	window.location='show_coupons.php';
	</script>";
	?>
</body>
</html>
