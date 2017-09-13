<?php ob_start();
require_once('auth.php');
// access the current session
session_start();
// check if there is a user identity stored in the session object
if (empty($_SESSION['user_id'])) {
// if there is no user_id in the session, redirect the user to the login page
    header('location:login.php');
    exit();
}
//Set the Page Title
$page_title = null;
$page_title = 'Main Menu';
//Embed the Header
require_once('header.php');
?>
<main class="container">
    <h1>COMP1006 Application</h1>
    <ul class="list-group">
        <li class="list-group-item"><a href="movies.php" title="Movies">Movies</a></li>
        <li class="list-group-item"><a href="books.php" title="Books">Books</a></li>
    </ul>
</main>
<?php
//Embed Footer
require_once('footer.php');
?>

