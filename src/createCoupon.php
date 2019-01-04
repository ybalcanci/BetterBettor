 <!DOCTYPE html>
<html>
<body>
<?php
include 'connect.php';
$stake = (int)$_POST["stake"];
$min = 4;
$matches_betted = (int)$_COOKIE['matches_betted'];
for($i = 0; $i < $matches_betted; $i++){
	$match_id = (int)$_COOKIE['match_id' . $i];
	$sql = "SELECT min_bet FROM gmatch WHERE match_id = $match_id;";
	$minbet = mysqli_fetch_assoc(mysqli_query($conn, $sql));
	$minbet = (int)($minbet['min_bet']);
	if($minbet < $min){
		$min = $minbet;
	}
}
$sql = "SELECT balance FROM User WHERE tid = ".$_SESSION['tid'].";";
$balance = mysqli_fetch_assoc(mysqli_query($conn, $sql));
$balance = (int)($balance['balance']);
if($matches_betted < $min){
	echo "<script type='text/javascript'>alert('Error: Minimum bet number is not satisfied.');window.location='football.php';</script>";
}
else if($stake < 3){
	echo "<script type='text/javascript'>alert('Error: You must pay at least 3TL.');window.location='football.php';</script>";
}
else if($balance < $stake){
	echo "<script type='text/javascript'>alert('Error: Check your balance.');window.location='football.php';</script>";
}
else{
	$sql = "SELECT max(coupon_id) from Coupon;";
	$coupon = mysqli_fetch_assoc(mysqli_query($conn, $sql));
	$coupon_id = (int)($coupon['max(coupon_id)']);
	$coupon_id = $coupon_id + 1;
	
	$newbalance = $balance - $stake;
	$sql = "UPDATE User SET balance = $newbalance WHERE tid = ".$_SESSION['tid'].";";
	mysqli_query($conn, $sql);
	
	$sql = "INSERT INTO Coupon VALUES($coupon_id, ".$_SESSION['tid'].", $stake, \"".date("h:i")."\", \"".date("Y.m.d")."\");";
	mysqli_query($conn, $sql);
	for($i = 0; $i < $matches_betted; $i++){
		$max_match_id = $max_match_id['max(match_id)'];
		$match_id = (int)$_COOKIE["match_id$i"];
		$type = $_COOKIE["odd$i"];
		$sql = "INSERT INTO Coupon_Match VALUES($match_id, $coupon_id);";
		mysqli_query($conn, $sql);
		$sql = "INSERT INTO Coupon_Odd VALUES($coupon_id, $match_id, \"$type\");";
		mysqli_query($conn, $sql);
	}
	setcookie("matches_betted", "0", time() + 3600, '/');
	echo "<script type='text/javascript'>alert('Coupon is Created Successfully');
	document.cookie = \"matches_betted=0\";
	window.location='football.php';
	</script>";
}

?>
</body>
</html> 
