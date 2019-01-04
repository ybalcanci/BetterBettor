
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
    <p class="h4" style="color:#9EBAC4;">
      <?php
        include 'connect.php';
        if(empty($_SESSION['tid'])){
    			header("Location: /index.php");
    			die();
    		}
    		$tid = $_SESSION['tid'];
    		$sql = "SELECT * FROM User WHERE tid = \"$tid\";";
    		$user = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    		echo $user['name'] . " ". $user['surname'] . " ";

        $sql = "SELECT count(follower_tid) as follower_count FROM Follow WHERE followed_tid = \"$tid\";";
        $follower_count = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        echo "Followers: " . $follower_count['follower_count']. " ";

        $sql = "SELECT count(followed_tid) as followed_count FROM Follow WHERE follower_tid = \"$tid\";";
        $followed_count = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        echo "Followeds: " . $followed_count['followed_count'];

      ?>
    </p>

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
            <a href="/show_posts_liked.php" class="btn btn-primary btn-sm">
                <div class="menuTopPostsLiked"></div>
                <div class="menuTopText1">Liked Posts</div>
            </a>
            </div>

                        <div class="topMenuLeft ">
            <a href="/show_posts_commented.php" class="btn btn-primary btn-sm">
                <div class="menuTopPostsCommented"></div>
                <div class="menuTopText2">Commented Posts</div>
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

      <!-- Coupons -->
      <div class="panel container-fluid col-md-6" >

          <h3 class=\"page-header\" style=\"font-weight: bold;\"> Posts </h3>

          <div class="panel container-fluid col-md-3" style="margin-left: 2em;" >
          <form class="form-write" action="write_post_db.php" method='post' accept-charset='UTF-8' style='width: 30%;margin-left: auto;margin-right: auto;margin-top: 100px;'>
                <h3 class="form-register-heading">Share</h3>
                <label for="name" class="sr-only">Description</label>
                <textarea class="form-control" placeholder="What's your opinion?" style ="width:175px;" rows="3" name="description" required autofocus></textarea>
                <button class="btn btn-lg btn-primary btn-block" style="margin-top: 10px" type="submit" name="register">Send</button>
          </form>
          </div>

            <table class="table table-bordered" style="border:solid;">
            <thead>
            <tr>
              <th>Date</th>
              <th>Time</th>
              <th>Description</th>
            </tr>
            </thead>

          <?php
          $sql = "SELECT * FROM Post where tid =  ". $_SESSION['tid'] . ";" ;
    			$posts = mysqli_query($conn, $sql);
          while($post = mysqli_fetch_assoc($posts)) {

                echo "
                <tbody>
                <tr>
                  <td>" . $post['post_date'] . "</td>
                  <td>" . $post['post_time'] . "</td>
                  <td>" . $post['description'] . "</td>
                </tr>
                </tbody>";
            }
            echo "<br>";
            echo "</table>";
  			?>
      </div>

</body>
</html>
