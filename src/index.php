<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Log in</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    
</head>
<body>
<?php
if(!empty($_SESSION['tid'])){
	header("Location: /football.php");
	die();
}
?>
<div class="container">
    <nav class="navbar navbar-inverse bg-primary navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">BetterBettor</a>
            </div>
        </div>
    </nav>
    <form class="form-signin" action="login.php" method='post' accept-charset='UTF-8' style='width: 30%;margin-left: auto;margin-right: auto;margin-top: 100px;'>
        <h2 class="form-signin-heading">Please log in</h2>
        <label for="email" class="sr-only">Email</label>
        <input type="email" id="email" class="form-control" placeholder="Email" name="email" required
               autofocus>
        <label for="password" class="sr-only">SID</label>
        <input type="password" id="inputsid" class="form-control" placeholder="Password" name="password" required>
        <button class="btn btn-lg btn-primary btn-block" style="margin-top: 10px" type="submit" name="logIn">Log in</button>
    </form>
    </br>
    <p class="text-center"><b>or</b></p>
    </br>
    <p class="text-center"><u><a href="registerpage.php">Click here to register</a></u></p>
</div>
</body>
</html>
