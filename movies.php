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
$page_title = 'Movies';
//Embed the Header
require_once('header.php');
//Try-Catch for Error Handling
try {
    //Connect to Database
    require_once('db.php');
    //Prepare the Query
    $sql = "SELECT * FROM movies";
    //Run the Query, Store the results
    $cmd = $conn->prepare($sql);
    $cmd -> execute();
    $movies = $cmd->fetchAll();
    //Start our grid
    echo '<h1>Movie List</h1>
    <a href="movie.php" title="Add a New Movie">Add a New Movie</a>
    <table class="table table-striped table-hover"><thead>
        <th>Title</th><th>Year</th><th>Length</th><th>URL</th><th>Edit</th><th>Delete</th></thead><tbody>';
    //Loop through the data and display the results
    foreach($movies as $movie) {
        echo '<tr><td>' . $movie['title'] . '</td>
                    <td>' . $movie['year'] . '</td>
                    <td>' . $movie['length'] . '</td>
                    <td>' . $movie['url'] . '</td>
                    <td><a href="movie.php?movie_id=' . $movie['movie_id'] . '">Edit</a>
                    <td><a onclick="return confirm(\'Are you sure you want to delete this movie? \');" href="delete-movie.php?movie_id=' . $movie['movie_id'] . '">Delete</a></td></tr>';
    }
    //Close the grid
    echo '</tbody></table>';
    //Disconnect
    $conn = null;
}
//Any HTTP error will redirect to the 'error.php' page
catch (Exception $e) {
    //Send Error Exception to email address
    mail('tristanwilson111@gmail.com', 'COMP1006 Web App Error', $e, 'From:errors@comp1006webapp.com');
    header('location:error.php');
}
//Embed Footer
require_once('footer.php');
ob_flush(); ?>