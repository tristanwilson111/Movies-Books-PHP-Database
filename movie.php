<?php ob_start();
// authorization check
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
$page_title = 'Movie Selection';
//Embed the Header
require_once('header.php');
if (empty($_GET['movie_id']) == false) {
    $movie_id = $_GET['movie_id'];
// Error Checking Try-Catch
    try {
        // connect
        require_once('db.php');

        // write the sql query
        $sql = "SELECT * FROM movies WHERE movie_id = :movie_id";

        // execute the query and store the results
        $cmd = $conn->prepare($sql);
        $cmd->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
        $cmd->execute();
        $movies = $cmd->fetchAll();

        // populate the fields for the selected movie from the query result
        foreach ($movies as $movie) {
            $title = $movie['title'];
            $length = $movie['length'];
            $year = $movie['year'];
            $url = $movie['url'];
        }

        // disconnect
        $conn = null;
    }
    //Any HTTP error will redirect to the 'error.php' page
        catch (Exception $e) {
            //Send Error Exception to email address
            mail('tristanwilson111@gmail.com', 'COMP1006 Web App Error', $e, 'From:errors@comp1006webapp.com');
            header('location:error.php');
        }
}
?>
<div class="container">
    <h1>Movie Details</h1>
    <form method="post" action="save-movie.php">
        <fieldset class="form-group">
            <label for="title" class="col-sm-2">Title:</label>
            <input name="title" id="title" required value="<?php echo $title; ?>" />
        </fieldset>
        <fieldset class="form-group">
            <label for="year" class="col-sm-2">Year:</label>
            <input name="year" id="year" required type="number" value="<?php echo $year; ?>" />
        </fieldset>
        <fieldset class="form-group">
            <label for="length" class="col-sm-2">Length:</label>
            <input name="length" id="length" required type="number" value="<?php echo $length; ?>" />
        </fieldset>
        <fieldset class="form-group">
            <label for="url" class="col-sm-2">URL:</label>
            <input name="url" id="url" required type="url" value="<?php echo $url; ?>" />
        </fieldset>
        <input name="movie_id" type="hidden" value="<?php echo $movie_id; ?>" />
        <button type="submit" class="col-sm-offset-2 btn btn-success">Submit</button>
    </form>
</div>
<?php
//Embed the Footer
require_once('footer.php');
ob_flush(); ?>