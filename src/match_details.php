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

    <!-- Team 1 Info -->
    <div class="panel container-fluid col-md-4" >
			<?php
				if(empty($_SESSION['tid']) || $_SESSION['tid'] == ""){
					header("Location: /index.php");
					die();
				}
				$tid = $_SESSION['tid'];
				$match_id = (int)$_GET['match_id'];
				$sql = "SELECT team_id1, team_id2 FROM Team_Match WHERE match_id = $match_id;";
				$teams = mysqli_fetch_assoc(mysqli_query($conn, $sql));
				$team_id1 = $teams['team_id1'];
				$team_id2 = $teams['team_id2'];
				$sql = "SELECT * FROM Team WHERE team_id = $team_id1;";
				$team = mysqli_fetch_assoc(mysqli_query($conn, $sql));
				$team_name1 = $team['team_name'];
				$branch = $team['branch'];
				$sql = "SELECT * FROM Team WHERE team_id = $team_id2;";
				$team = mysqli_fetch_assoc(mysqli_query($conn, $sql));
				$team_name2 = $team['team_name'];
				echo "
				<h3 class=\"page-header\" style=\"font-weight: bold;\">$team_name1</h3>
		    	<table class=\"table table-bordered\" style=\"border:solid;\">
		    	<thead>
		      <tr>
				    <th>Kit</th>
				    <th>Name</th>
		      </tr>
		      </thead>";

		    	$sql = "SELECT * FROM Player WHERE team_id = $team_id1;";
		    	$players = mysqli_query($conn, $sql);
		    	while($player = mysqli_fetch_assoc($players)) {
						echo "
						<tbody>
						<tr>
							<td>" . $player["kit_number"] . "</td>
							<td>" . $player["name"] . "</td>
						</tr>
						</tbody>";
					}

				echo "</table>";

				$sql = "SELECT league FROM gmatch WHERE match_id = $match_id;";
				$leagues = mysqli_fetch_assoc(mysqli_query($conn, $sql));
				$league = $leagues['league'];

				echo "
				<h3  style=\"font-weight: normal;\">Some Statistics</h3>
		    	<table class=\"table table-bordered\" style=\"border:solid;\">
		    	<thead>
		      <tr>
				    <th>Type</th>
				    <th>Average Odd</th>
		      </tr>
		      </thead>";

		    	$sql = "SELECT avg(odd_rate) as avg_odd, type FROM Odd NATURAL JOIN Team_Match join gmatch using (match_id) WHERE team_id1 = $team_id1 and league = \"" . $league . "\" GROUP BY type;";
		    	$odds = mysqli_query($conn, $sql);
		    	while($odd = mysqli_fetch_assoc($odds)) {
						if($odd['type'] == "FT1"){
							echo "
								<tbody>
								<tr>
								<td>Win</td>
								<td>" . round($odd["avg_odd"], 2) . "</td>
								</tr>
								</tbody>";
						} elseif($odd['type'] == "FT0"){
							echo "
								<tbody>
								<tr>
								<td>Draw</td>
								<td>" . round($odd["avg_odd"], 2) . "</td>
								</tr>
								</tbody>";
						} elseif($odd['type'] == "FT2"){
							echo "
								<tbody>
								<tr>
								<td>Lose</td>
								<td>" . round($odd["avg_odd"], 2) . "</td>
								</tr>
								</tbody>";
						}
					}

				echo "</table>";

				echo "*These are the average odds of $team_name1 at home matches in $league";
			?>
    </div>
    
    <!-- Extra Info (referee or narrator) -->
    <div class="panel container-fluid col-md-3" >
    <?php
    if($branch == "Football"){
    	$sql = "SELECT * FROM F_Match WHERE match_id = $match_id;";
		$referee = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    	echo "<h4 class=\"page-header text-center\" style=\"font-weight: bold;\">Referee</h4>";
    	echo "<h4 class=\"page-header text-center\" style=\"font-weight: bold;\">".$referee['referee']."</h4>";
    }
    else if($branch == "Basketball"){
    	$sql = "SELECT * FROM B_Match WHERE match_id = $match_id;";
		$narrator = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    	echo "<h4 class=\"page-header text-center\" style=\"font-weight: bold;\">Narrator</h4>";
    	echo "<h4 class=\"page-header text-center\" style=\"font-weight: bold;\">".$narrator['narrator']."</h4>";
    }
    ?>
    </div>
    
    <!-- Team 2 Info -->
    <div class="panel container-fluid col-md-4" >
			<?php
				echo "
					<h3 class=\"page-header text-right\" style=\"font-weight: bold;\">$team_name2</h3>
					<table class=\"table table-bordered\" style=\"border:solid;\">
					<thead>
				  <tr>
						<th>Kit</th>
						<th>Name</th>
				  </tr>
				  </thead>";
				$sql = "SELECT * FROM Player WHERE team_id = $team_id2;";
		    	$players = mysqli_query($conn, $sql);
		    	while($player = mysqli_fetch_assoc($players)) {
						echo "
						<tbody>
						<tr>
							<td>" . $player["kit_number"] . "</td>
							<td>" . $player["name"] . "</td>
						</tr>
						</tbody>";
					}

				echo "</table>";

				echo "
				<h3  style=\"font-weight: normal;\">Some Statistics</h3>
		    	<table class=\"table table-bordered\" style=\"border:solid;\">
		    	<thead>
		      <tr>
				    <th>Type</th>
				    <th>Average Odd</th>
		      </tr>
		      </thead>";

		    	$sql = "SELECT avg(odd_rate) as avg_odd, type FROM Odd NATURAL JOIN Team_Match join gmatch using (match_id) WHERE team_id2 = $team_id2 and league = \"" . $league . "\" GROUP BY type;";
		    	$odds = mysqli_query($conn, $sql);
		    	while($odd = mysqli_fetch_assoc($odds)) {
						if($odd['type'] == "FT1"){
							echo "
								<tbody>
								<tr>
								<td>Lose</td>
								<td>" . round($odd["avg_odd"], 2) . "</td>
								</tr>
								</tbody>";
						} elseif($odd['type'] == "FT0"){
							echo "
								<tbody>
								<tr>
								<td>Draw</td>
								<td>" . round($odd["avg_odd"], 2) . "</td>
								</tr>
								</tbody>";
						} elseif($odd['type'] == "FT2"){
							echo "
								<tbody>
								<tr>
								<td>Win</td>
								<td>" . round($odd["avg_odd"], 2) . "</td>
								</tr>
								</tbody>";
						}
					}

				echo "</table>";
				echo "*These are the average odds of $team_name2 at away matches in $league";
			?>
    </div>
    
</div>

</body>
</html>
