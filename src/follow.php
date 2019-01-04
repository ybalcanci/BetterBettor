<!DOCTYPE html>
<html>
<body>

<?php
include 'connect.php';

$other_user_tid = (int) $_GET['tid'];
$sql = "INSERT INTO Follow VALUES(" .$_SESSION['tid']. ", $other_user_tid);";
mysqli_query($conn, $sql);

header("Location: userProfile.php?tid=". $other_user_tid. "");
die();

mysqli_close($conn);
?>

</body>
</html>
