<?php ob_start();
// authorization check
require_once('auth.php');
require_once('header.php');
// access the current session
session_start();
// check if there is a user identity stored in the session object
if (empty($_SESSION['user_id'])) {
// if there is no user_id in the session, redirect the user to the login page
    header('location:login.php');
    exit();
}
// capture the selected movie_id from the url and store it in a variable with the same name
$movie_id = $_GET['movie_id'];
// Error Checking Try-Catch
try {
    // connect to database
    require_once('db.php');
    // set up the SQL command
    $sql = "DELETE FROM movies WHERE movie_id = :movie_id";
    // create a command object so we can populate the movie_id value, the run the deletion
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
    $cmd->execute();
    // disconnect
    $conn = null;
}
//Any HTTP error will redirect to the 'error.php' page
catch (Exception $e) {
    //Send Error Exception to email address
    mail('tristanwilson111@gmail.com', 'COMP1006 Web App Error', $e, 'From:errors@comp1006webapp.com');
    header('location:error.php');
}
header('location:movie.php');
require_once('footer.php');
ob_flush(); ?>