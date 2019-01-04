<?php include 'connect.php'; ?>
<html lang="en">
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
</head>
<!-- HTML Commenting is done this way -->
<body style="background-color: #223E4A;">
<?php 
$sql = "SELECT min(match_id),max(match_id) from F_Match;";
$match_id_limits = mysqli_fetch_assoc(mysqli_query($conn, $sql));
$max_match_id = $match_id_limits['max(match_id)'];
$min_match_id = $match_id_limits['min(match_id)'];
?>
<script type="text/javascript">
function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
function cleanCoupon(){
	document.cookie = "matches_betted=0"; 
    location.reload();
}
function addMatch(){
	var numOfMatches = parseInt(getCookie("matches_betted"));
  if (!numOfMatches) {
  	document.cookie = "matches_betted=0";
  	numOfMatches = 0;
  }  
  var inp_match_id = parseInt(document.getElementById("matchid").value);
  let i = 0;
  if(document.getElementById("matchid").value === "" || isNaN(document.getElementById("matchid").value) ||
  	inp_match_id > parseInt(<?php echo $max_match_id; ?>) || inp_match_id < 101 ||
  	inp_match_id < parseInt(<?php echo $min_match_id; ?>) || inp_match_id < 101){
  	document.getElementById("matchid").value = "";
   	alert("Invalid Match ID");
   	return;
  }
  for(; i < numOfMatches; i++){
   let match_id = parseInt(getCookie("match_id" + i));
   if(match_id == inp_match_id){
   	document.getElementById("matchid").value = "";
   	alert("Match already exists in your coupon!.");
   	return;
   }
  }
	var odd = document.getElementById("odd_to_add").value;
	document.cookie = "match_id" + i +"=" + inp_match_id;
	document.cookie = "odd" + i +"=" + odd;
	document.cookie = "matches_betted=" + ++numOfMatches;
	document.getElementById("matchid").value = "";
	location.reload();
}
function writeCurrentMatches(){
	var numOfMatches = parseInt(getCookie("matches_betted"));
	if (!numOfMatches) {
		document.cookie = "matches_betted=0";
		return;
	}
	for(let i = 0; i < numOfMatches; i++){
		document.write("<tbody>" +
				"<tr>" +
					"<td>" + getCookie("match_id" + i) + "</td>" +
					"<td>" + getCookie("odd" + i) + "</td>" +
				"</tr>" +
				"</tbody>");
	}
}
</script>
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
    <p class="h4" style="color:#9EBAC4;">Welcome <?php
    	if(empty($_SESSION['tid']) || $_SESSION['tid'] == ""){
			header("Location: /index.php");
			die();
		}
		$tid = $_SESSION['tid'];
		$sql = "SELECT * FROM User WHERE tid = \"$tid\";";
		$user = mysqli_fetch_assoc(mysqli_query($conn, $sql));
		echo $user['name'];
    ?></p>
    <!-- Matches Table -->
    <div class="panel container-fluid col-md-8" >
			<?php
			$sql = "SELECT * FROM showFootball;"; 
			$leagues = mysqli_query($conn, $sql);
			while($league = mysqli_fetch_assoc($leagues)) {
				echo "
				<h3 class=\"page-header\" style=\"font-weight: bold;\">" . $league['league'] . "</h3>
		    	<table class=\"table table-bordered\" style=\"border:solid;\">
		    	<thead>
		      <tr>
				    <th>ID</th>
				    <th>Time</th>
				    <th>Min Bet</th>
				    <th>Teams</th>
				    <th>FT1</th>
				    <th>FT2</th>
				    <th>FT0</th>
				    <th>A2.5</th>
				    <th>B2.5</th>
		      </tr>
		      </thead>";

		    	$sql = "SELECT * FROM gmatch WHERE league =\"" . $league['league'] . "\";";
		    	$matches = mysqli_query($conn, $sql);
		    	while($match = mysqli_fetch_assoc($matches)) {
						$sql = "SELECT * FROM Team_Match WHERE match_id = \"" . $match['match_id'] . "\";";
						$teams = mysqli_fetch_assoc(mysqli_query($conn, $sql));
						$teamid1 = $teams['team_id1'];
						$teamid2 = $teams['team_id2'];

						$team1sql = "SELECT * FROM Team WHERE team_id = \"" . $teamid1 . "\";";
						$team2sql = "SELECT * FROM Team WHERE team_id = \"" . $teamid2 . "\";";
						$oddsql = "SELECT * FROM Odd WHERE match_id = \"" . $match['match_id'] . "\";";
						$team1 = mysqli_fetch_assoc(mysqli_query($conn, $team1sql));
						$team2 = mysqli_fetch_assoc(mysqli_query($conn, $team2sql));
						$odds = mysqli_query($conn, $oddsql);
						$oddArray = array();
						while($odd = mysqli_fetch_assoc($odds)) {
							//each element of the array is one of the rows of table with columns: match_id / type / odd_rate
							array_push($oddArray, $odd);
						}
						echo "
						<tbody>
						<tr>
							<td>" . $match["match_id"] . "</td>
							<td>" . $match["time"] . "</td>
							<td>" . $match["min_bet"] . "</td>
							<td><a href='match_details.php?match_id=".$match["match_id"]."'>".$team1["team_name"]." - ".$team2["team_name"]."</a></td>
							<td>" . $oddArray[3]["odd_rate"] . "</td>
							<td>" . $oddArray[4]["odd_rate"] . "</td>
							<td>" . $oddArray[2]["odd_rate"] . "</td>
							<td>" . $oddArray[0]["odd_rate"] . "</td>
							<td>" . $oddArray[1]["odd_rate"] . "</td>
						</tr>
						</tbody>";
					}

				echo "</table>";
			}
			?>
    </div>
    <!-- Create Coupon -->
    <div class="panel container-fluid col-md-4" style="border:solid; position:fixed; left:65%;">
    	<h4 class="page-header" style="font-weight: bold;">Create Coupon</h4>
    	<button type="button" class="btn btn-primary btn-sm" onclick="cleanCoupon();">Clean Coupon</button>
    	<table class="table">
    		<thead>
        <tr>
		      <th>Match ID</th>
		      <th>Odd Type</th>
        </tr>
        </thead>

        <script type="text/javascript">writeCurrentMatches();</script>

    	</table>

    	<form class="form-inline">
				<div class="form-group">
					<input type="text" class="form-control" maxlength="3" id="matchid" required placeholder="Match ID">
				</div>
				<select id="odd_to_add">
					<option value="FT1">FT1</option>
					<option value="FT2">FT2</option>
					<option value="FT0">FT0</option>
					<option value="A2.5">A2.5</option>
					<option value="B2.5">B2.5</option>
				</select>
				<div style="text-align: center; margin-top:1em;">
					<button type="button" class="btn btn-primary btn-sm" onclick="addMatch();">Add Match</button>
				</div>
			</form>
			<?php
			$matches_betted = (int)$_COOKIE['matches_betted'];
			$totalodd = 1;
			for($i = 0; $i < $matches_betted; $i++){
				$match_id = (int)$_COOKIE['match_id' . $i];
				$odd = $_COOKIE['odd' . $i];
				$sql = "SELECT odd_rate FROM Odd WHERE match_id = $match_id and type = \"$odd\";";
				$odd = mysqli_fetch_assoc(mysqli_query($conn, $sql));
				$odd = (double)($odd['odd_rate']);
				$totalodd *= $odd;	
			}
			?>
			<form class="form-inline" action="createCoupon.php" method="post" >
				<input type="text" class="form-control" maxlength="5" id="stake" name="stake" required placeholder="Stake"><span>TL</span>
				<div class="text-primary" style="display:inline;">Win: </div>
				<div class="text-primary" id="winvalue"style="display:inline;"></div>
          		<button style="float: right;" type="submit" class="btn btn-primary btn-sm">Done</button>
          	</form>
          	<script>
          		var stakeinp = document.getElementById('stake');
				var winvalue = document.getElementById('winvalue');
				var reg = /^\d+$/;
				var totalodd = <?php echo $totalodd; ?>;
				stakeinp.addEventListener("input", function(){				
					if(!reg.test(stakeinp.value)){
						stakeinp.value = "";
						winvalue.innerHTML = "";
					}
					else{
						winval = parseInt(stakeinp.value) * totalodd;
						if(totalodd == 1 || winval <= 1.0){
							winvalue.innerHTML = "";
						}
						else{
							winvalue.innerHTML = winval.toFixed(2) + " TL";
						}
					}
					
				});
          	</script>
    </div>
</div>

</body>
</html>
