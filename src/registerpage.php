<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Log in</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    
</head>

<body>
<div class="container">
    <nav class="navbar navbar-inverse bg-primary navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">BetterBettor</a>
            </div>
        </div>
    </nav>
	<form class="form-register" action="register.php" method='post' accept-charset='UTF-8' style='width: 30%;margin-left: auto;margin-right: auto;margin-top: 100px;'>
        <h2 class="form-register-heading">Register</h2>
        <label for="name" class="sr-only">Name</label>
        <input type="text" id="name" class="form-control" placeholder="Name" name="name" required
               autofocus>
        <label for="surname" class="sr-only">Surname</label>
        <input type="text" id="surname" class="form-control" placeholder="Surname" name="surname" required>
		<label for="email" class="sr-only">Email</label>
        <input type="email" id="email" class="form-control" placeholder="Email" name="email" required>
		<label for="password" class="sr-only">Password</label>
        <input type="password" id="password" class="form-control" placeholder="Password" name="password" required>
		<label for="tid" class="sr-only">Turkish ID Number</label>
        <input type="text" id="tid" class="form-control" placeholder="Turkish ID Number" name="tid" required>
		<label for="birthdate" class="sr-only">Date of Birth</label>
        <input type="text" id="phonenumber" class="form-control" placeholder="Date of Birth (DD.MM.YYYY)" name="birthdate" required>
		<label for="phonenumber" class="sr-only">Phone Number</label>
        <input type="tel" id="phonenumber" class="form-control" maxlength="10" placeholder="Phone Number (535 545 5555)" name="phonenumber" required>
        <button class="btn btn-lg btn-primary btn-block" style="margin-top: 10px" type="submit" name="register">Register</button>
    </form>
    </br>
    <p class="text-center"><b>Already have an account?</b></p>
    <p class="text-center"><u><a href="index.php">Click here to log in</a></u></p>
</div>
</body>
</html>
