<!DOCTYPE html>
<html>
<body>
<?php
include 'connect.php';

$sql = "SELECT max(post_id) from Post;";
$post = mysqli_fetch_assoc(mysqli_query($conn, $sql));
$post_id = (int)($post['max(post_id)']);

$post_id = $post_id + 1;

$sql = "INSERT INTO Post VALUES($post_id, ".$_SESSION['tid'].", \"".date("Y.m.d")."\", \"".date("h:i")."\", \"".$_POST["description"]."\", 0);";
mysqli_query($conn, $sql);

header("Location: profile.php");
die();

mysqli_close($conn);
?>

</body>
</html>
