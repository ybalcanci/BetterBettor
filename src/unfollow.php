<!DOCTYPE html>
<html>
<body>

<?php
include 'connect.php';

$other_user_tid = (int) $_GET['tid'];
$sql = "DELETE FROM Follow WHERE follower_tid = ".$_SESSION['tid']. " and followed_tid = " . $other_user_tid . ";";
mysqli_query($conn, $sql);

header("Location: userProfile.php?tid=". $other_user_tid. "");
die();

mysqli_close($conn);
?>

</body>
</html>
