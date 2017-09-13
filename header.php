<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <title><?php echo $page_title; ?></title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
</head>
<body>
<nav class="navbar">
    <a href="menu.php" title="COMP1006 Web Application" class="navbar-brand">COMP1006 Web App</a>
    <ul class="nav navbar-nav">
        <?php //Show public or private links depending on whether the user has been authenticated
        if (!empty($_SESSION['user_id'])) { ?>
            <li><a href="movies.php" title="Movies">Movies</a></li>
            <li><a href="books.php" title="Books">Books</a></li>
            <li><a href="logout.php" title="Logout">Logout</a></li>
        <?php
        }
        else { ?>
            <li><a href="register.php" title="Register">Register</a></li>
            <li><a href="login.php" title="Login">Login</a></li>
        <?php } ?>
    </ul>
</nav>
<!-- Page Content Starts Here-->
