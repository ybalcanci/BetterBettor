<?php include 'connect.php';
	$sql = "SELECT balance FROM User WHERE TID = ". $_SESSION['tid'] . ";";
	$result = mysqli_query($conn,$sql);
	$balance = mysqli_fetch_assoc($result);
	//mysqli_data_seek($result, 0);
?>
<html lang="en">
<body style="background-image:url(para.jpg)">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>BetterBettor</title>
    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="profile_style.css" rel="stylesheet">
    <script src="welcomeClickHandler.js"></script>
</head>
<!-- HTML Commenting is done this way -->
<body style="background-color: #223E4A;">



<div class="container" style="margin-top:80px;">
    <nav class="navbar navbar-inverse bg-primary navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="football.php">BetterBettor</a>
                <a class="navbar-brand" href="football.php">Football</a>
                <a class="navbar-brand" href="basketball.php">Basketball</a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="logout.php">Log Out</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            	<li><a href="newsfeed.php">Newsfeed</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            	<li><a href="profile.php">Profile</a></li>
            </ul>
        </div>



    </nav>

	<div id="navigation" >
        <div id="thinBlueMenuContent" class="col-md-2">

                        <div class="topMenuLeft ">
            <a href="/~n.musevitoglu/deposit.php" class="btn btn-primary btn-sm">
                <div class="menuTopDeposit"></div>
                <div class="menuTopText1">Deposit</div>
            </a>
            </div>

                        <div class="topMenuLeft" >
            <a href="/~n.musevitoglu/deposit.php" class="btn btn-primary btn-sm width=120px">
                <div class="menuTopWithdraw"></div>
                <div class="menuTopText2">Withdraw</div>
            </a>
            </div>

                        <div class="topMenuLeft ">
            <a href="/~n.musevitoglu/show_followers.php" class="btn btn-primary btn-sm">
                <div class="menuTopFollower"></div>
                <div class="menuTopText2">Followers</div>
            </a>
            </div>

                        <div class="topMenuLeft ">
            <a href="/~n.musevitoglu/show_followed.php" class="btn btn-primary btn-sm">
                <div class="menuTopFollowed"></div>
                <div class="menuTopText2">Following</div>
            </a>
            </div>

                        <div class="topMenuLeft ">
            <a href="/~n.musevitoglu/show_coupons.php" class="btn btn-primary btn-sm">
                <div class="menuTopMyCoupons"></div>
                <div class="menuTopText2">Coupons</div>
            </a>
            </div>
        </div>

      </div>
    <!-- Create Coupon -->
    <div class="panel container-fluid col-md-4" style="border:solid; position:centre; padding-bottom:40px;">

		<?php echo "Balance: ".$balance['balance']. " TL"; ?>

		<!--<h4 style="font-weight: bold;"><?php echo "Balance: ".$balance['balance']. " TL"; ?></h4>-->

    	<h4 class="page-header" style="font-weight: bold;">Deposit</h4>

		<!--<div class="form-group">
			<h4 style="font-weight: normal;" method="get">Amount:
				<input type="number" class="form-group" id="deposit" required placeholder="Deposit">
			</h4>-->
		<form action="" method="post">
			Amount: <input type="number" name="dep"><br>
		<input type="submit" value="Deposit" name="deposit">
		</form>

		<h4 class="page-header" style="font-weight: bold;">Withdraw</h4>

		<form action="" method="post">
			Amount: <input type="number" name="wit"><br>
		<input type="submit" value="Withdraw" name="withdraw">
		</form>

<?php
	include 'connect.php';
	$x = 0;
	if($_POST){
		$sq = "SELECT balance FROM User WHERE TID = ". $_SESSION['tid'] . ";";
		$resul = mysqli_query($conn,$sq);
		$balanc = mysqli_fetch_assoc($resul);
		$GLOBALS['x'] = (int)$balanc['balance'];

		if(isset($_POST['dep'])){
			$a = (int)$_POST['dep'];
			deposit($a);

		} elseif(isset($_POST['wit'])){
			$b = (int)$_POST['wit'];
			withdraw($b);
		  }
	}

function deposit($a)
{

	$m = (int)$GLOBALS['x'];
	//echo "<script type='text/javascript'>alert('I am in deposit function $m');</script>";

	//$txt = "a: $a" . "balance: ". $m;
	//echo "<script type='text/javascript'>alert('$txt');</script>";
	$dep = $a + $m;
	//var_dump($dep);
	//$txt = $dep. " TL will be deposited into your account";
	//echo "<script type='text/javascript'>alert('$POST['deposit']');</script>";

	$sql = "UPDATE User SET balance = $dep WHERE tid = ". $_SESSION['tid'] . ";";
	//echo $sql;
	include 'connect.php';
	mysqli_query($conn, $sql);
	echo "<script type=\"text/javascript\">window.location.replace('deposit.php');</script>";
}

function withdraw($b)
{
	//include 'connect.php';
	$m = (int)$GLOBALS['x'];
	//echo "<script type='text/javascript'>alert('I am in deposit function $m');</script>";

	//$txt = "a: $a" . "balance: ". $m;
	//echo "<script type='text/javascript'>alert('$txt');</script>";
	$dep = $m - $b;
	//var_dump($dep);
	//$txt = $dep. " TL will be deposited into your account";
	//echo "<script type='text/javascript'>alert('$txt');</script>";

	$sql = "UPDATE User SET balance = $dep WHERE tid = ". $_SESSION['tid'] . ";";
	//echo $sql;
	include 'connect.php';
	mysqli_query($conn, $sql);
	echo "<script type=\"text/javascript\">window.location.replace('deposit.php');</script>";
}

?>


		<!--</div>
    	<button type="button" class="btn btn-primary btn-sm" onclick="deposit();">Deposit</button>

		<h4 class="page-header" style="font-weight: bold;">Withdraw</h4>
			<div class="form-group">
				<h4 style="font-weight: normal;">Amount:
				<input type="number" class="form-inline" id="withdraw" required placeholder="Withdraw"> </h4>
			</div>
		<button type="button" class="btn btn-primary btn-sm" onclick="withdraw();">Withdraw</button> -->


    </div>
</div>

</body>
</html>
