
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
        $other_user_tid = (int) $_GET['tid'];
        if(empty($other_user_tid) || $other_user_tid == $_SESSION['tid'] ) {
    			header("Location: profile.php");
    			die();
    		}

        $sql = "SELECT * FROM User WHERE tid = $other_user_tid;";
    		$user = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    		echo $user['name'] . " " . $user['surname'] ;
        ?>

        <?php

        $sql = "SELECT count(follower_tid) as follower_count FROM Follow WHERE followed_tid = $other_user_tid;";
        $follower_count = mysqli_fetch_assoc(mysqli_query($conn, $sql));

        $sql = "SELECT count(followed_tid) as followed_count FROM Follow WHERE follower_tid = $other_user_tid;";
        $followed_count = mysqli_fetch_assoc(mysqli_query($conn, $sql));

        $sql = "SELECT * FROM Follow WHERE follower_tid = " . $_SESSION['tid'] . " and followed_tid = " . $other_user_tid . ";" ;
        $is_followed = mysqli_query($conn, $sql);
        if(mysqli_num_rows($is_followed) > 0 ){
          /*echo "<form class=\"form-follow\" action=\"unfollow.php\" method='post' accept-charset='UTF-8'>
            <button class=\"btn btn-lg btn-secondary btn-block\" style=\"margin-left: 15px\" type=\"submit\" name=\"unfollow\">Unfollow</button>
          </form>";*/
          echo "<a href=\"unfollow.php?tid=". $other_user_tid ."\" class=\"btn btn-lg btn-primary btn-block\"> Unfollow </a>";
        }
        else{
          echo "<a href=\"follow.php?tid=". $other_user_tid ."\" class=\"btn btn-lg btn-primary btn-block\"> Follow </a>";
        }
      ?>
    </p>

    <div id="navigation" >
        <div id="thinBlueMenuContent" class="col-md-2">

                        <div class="topMenuLeft ">
            <a href="/~n.musevitoglu/other_show_followers.php?tid=<?php echo $other_user_tid ?>" class="btn btn-primary btn-sm">
                <div class="menuTopFollower"></div>
                <div class="menuTopText2">Followers: <?php echo $follower_count['follower_count'] ?></div>
            </a>
            </div>

                        <div class="topMenuLeft ">
            <a href="/~n.musevitoglu/other_show_followed.php?tid=<?php echo $other_user_tid ?>" class="btn btn-primary btn-sm">
                <div class="menuTopFollowed"></div>
                <div class="menuTopText2">Following: <?php echo $followed_count['followed_count'] ?></div>
            </a>
            </div>
        </div>
      </div>

      <!-- Coupons -->
      <div class="panel container-fluid col-md-7" >
        <h3 class= "page-header" style="font-weight: bold;"> Posts </h3>


        <?php

        $sql = "SELECT * FROM Post where tid =  ". $other_user_tid . " ORDER BY post_id DESC;" ;
      $posts = mysqli_query($conn, $sql);
        while($post = mysqli_fetch_assoc($posts)) {
    if($post['description'] == ""){
      $sql = "SELECT * FROM Post, Post_Coupon WHERE
                Post.post_id = Post_Coupon.post_id AND tid = ". $other_user_tid . " AND Post.post_id = ".$post['post_id'].";";
              $coupon_post = mysqli_fetch_assoc(mysqli_query($conn, $sql));
              $coupon_id = $coupon_post['coupon_id'];
              echo
            "<table class=\"table table-bordered\" style=\"border:solid;\">
            <thead>
            <tr>
              <th>Match ID</th>
              <th>Time</th>
              <th>Teams</th>
              <th>Type</th>
              <th>Odd</th>
            </tr>
            </thead>";
      $total_odd_rate = 1;
          $sql = "SELECT match_id FROM Coupon_Match where coupon_id = ". $coupon_id . ";" ;
          $matches_in_coupon = mysqli_query($conn, $sql);
          $sql = "SELECT * FROM Coupon where coupon_id = ". $coupon_id . ";" ;
      $coupon = mysqli_fetch_assoc(mysqli_query($conn, $sql));
          while($match_in_coupon = mysqli_fetch_assoc($matches_in_coupon)) {
            $sql = "SELECT time from gmatch where match_id = " .$match_in_coupon['match_id']. ";" ;
            $time =  mysqli_fetch_assoc(mysqli_query($conn, $sql));

            $sql = "SELECT team_id1, team_id2 from Team_Match where match_id = ". $match_in_coupon['match_id'] . ";" ;
            $teams = mysqli_fetch_assoc(mysqli_query($conn, $sql));
            $teamid1 = $teams['team_id1'];
            $teamid2 = $teams['team_id2'];

            $sql = "SELECT team_name from Team where team_id = $teamid1; ";
            $team_name1 = mysqli_fetch_assoc(mysqli_query($conn, $sql));

            $sql = "SELECT team_name from Team where team_id = $teamid2; ";
            $team_name2 = mysqli_fetch_assoc(mysqli_query($conn, $sql));

            $sql = "SELECT type from Coupon_Odd where match_id = ".$match_in_coupon['match_id']." and coupon_id = ".$coupon_id.";";
            $type = mysqli_fetch_assoc(mysqli_query($conn, $sql));

            $sql = "SELECT odd_rate from Odd where match_id = ".$match_in_coupon['match_id'] ." and type = \"" . $type['type'] . "\";";
            $selected_odd = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        $total_odd_rate *= (double)$selected_odd['odd_rate'];

              echo "
              <tbody>
              <tr>
                <td>" . $match_in_coupon['match_id'] . "</td>
                <td>" . $time['time'] . "</td>
                <td>" . $team_name1['team_name'] . " - " . $team_name2['team_name'] . "</td>
                <td>" . $type['type'] . "</td>
                <td>" . $selected_odd['odd_rate'] . "</td>
              </tr>
              </tbody>";
            }
            $win = $total_odd_rate * (double)$coupon['deposit'];
            echo "<br>";
            echo "</table>";
            echo "<ul class=\"list-inline\" style='margin-bottom:0px;'>
            <li><h4>Stake = ".$coupon['deposit']." TL</h4></li>
            <li><h4>Win = ". number_format((float) $win, 2, '.', '')." TL</h4></li>

        </ul>";
          }
    else{
              echo "
              <section style=\"border:solid;\">
                <h4>" . $post['description'] . "</h4>
                <ul class=\"list-inline\">
          <li><h5>" . $post['post_date'] . "</h5></li>
          <li><h5>" . $post['post_time'] . "</h5></li>
          </ul>
              </section>";
          }
          $sql = "SELECT * FROM Post_Like WHERE tid = ".$_SESSION['tid']." AND post_id = ".$post['post_id']." ";
          $result = mysqli_query($conn, $sql);
          $sql = "SELECT * FROM Post_Like WHERE post_id = ".$post['post_id'].";";
          $likes = mysqli_query($conn, $sql);
          echo
          "<div class=\"btn-group\">";
          if(mysqli_num_rows($result) <= 0){
            echo
            "<form action='add_like.php?post_id=".$post['post_id']."' method='post' style='float: left;'>
        <button type=\"submit\" class=\"btn btn-success btn-sm\">Like(".mysqli_num_rows($likes).")</button>
        </form>";
          }
          else{
            echo
            "<form action='unlike.php?post_id=".$post['post_id']."' method='post' style='float: left;'>
        <button type=\"submit\" class=\"btn btn-danger btn-sm\">Unlike(".mysqli_num_rows($likes).")</button>
       </form>";
          }
          $sql = "SELECT * FROM Comment_Write WHERE post_id = ".$post['post_id'].";";
          $comments = mysqli_query($conn, $sql);
    echo
    "<button onclick=\"dispCommentArea('cm-".$post['post_id']."')\" class=\"btn btn-primary btn-sm\">Comment(".mysqli_num_rows($comments).")</button>

    </div>
          <section id='cm-".$post['post_id']."' style='display:none;'>";
          while($comment = mysqli_fetch_assoc($comments)) {
            $sql = "SELECT * FROM User WHERE tid = ". $comment['tid'] .";";
            $comment_user = mysqli_fetch_assoc(mysqli_query($conn, $sql));
            $comment_user_name = $comment_user['name'] . " " . $comment_user['surname'];
            echo "
            <section style=\"border:dotted;\">
            <h5>" . $comment_user_name . "</h5>
              <h4>" . $comment['content'] . "</h4>
            </section>";
          }
    echo "<form class=\"form-write\" action=\"add_comment?post_id=".$post['post_id'].".php\" method='post' accept-charset='UTF-8'>
              <textarea class=\"form-control\" placeholder=\"What's your opinion?\" style =\"width:100%;\" rows=\"2\" name=\"comment\" required autofocus></textarea>
              <button class=\"btn btn-sm btn-success btn-block\" style=\"margin-top: 10px\" type=\"submit\">Send</button>
        </form>
        </section>
    <br>";
    }
      ?>
      </div>
</body>
</html>
