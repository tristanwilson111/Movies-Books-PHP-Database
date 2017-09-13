<?php ob_start();
// authorization check
require_once('auth.php');
$page_title = null;
$page_title = 'Saving your Movie...';
require_once('header.php');
// access the current session
session_start();
// check if there is a user identity stored in the session object
if (empty($_SESSION['user_id'])) {
// if there is no user_id in the session, redirect the user to the login page
    header('location:login.php');
    exit();
}
// store the movie_id if we are editing.  if we are adding, this value will be empty (which is ok)
$movie_id = $_POST['movie_id'];
// save form inputs into variables
$title = $_POST['title'];
$year = $_POST['year'];
$length = $_POST['length'];
$url = $_POST['url'];
// create a variable to indicate if the form data is ok to save or not
$ok = true;
// check each value
if (empty($title)) {
    // notify the user
    echo 'Title is required<br />';

    // change $ok to false so we know not to save
    $ok = false;
}
if (empty($year)) {
    // notify the user
    echo 'Year is required<br />';
    // change $ok to false so we know not to save
    $ok = false;
}
elseif (is_numeric($year) == false) {
    echo 'Year is invalid<br />';
    $ok = false;
}

if (empty($length)) {
    // notify the user
    echo 'Title is required<br />';
    // change $ok to false so we know not to save
    $ok = false;
}
elseif (is_numeric($length) == false) {
    echo 'Length is invalid<br />';
    $ok = false;
}
if (empty($url)) {
    // notify the user
    echo 'URL is required<br />';
    // change $ok to false so we know not to save
    $ok = false;
}
// check the $ok variable and save the data if $ok is still true (meaning we didn't find any errors)
if ($ok == true) {
    try {
        // connect to the database
        require_once('db.php');
        // set up the SQL INSERT command
        if (empty($movie_id)) {
            // set up the SQL INSERT command
            $sql = "INSERT INTO movies (title, year, length, url) VALUES (:title, :year, :length, :url)";
        }
        else {
        // set up the SQL UPDATE command to modify the existing movie
        $sql = "UPDATE movies SET title = :title, year = :year, length = :length, url = :url WHERE movie_id = :movie_id";
        }
        $cmd = $conn->prepare($sql);
        // create a command object and fill the parameters with the form values
        $cmd->bindParam(':title', $title, PDO::PARAM_STR, 50);
        $cmd->bindParam(':year', $year, PDO::PARAM_INT);
        $cmd->bindParam(':length', $length, PDO::PARAM_INT);
        $cmd->bindParam(':url', $url, PDO::PARAM_STR, 100);
        // fill the movie_id if we have one
        if (!empty($movie_id)) {
            $cmd->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
        }
        // execute the command
        $cmd->execute();
        // disconnect from the database
        $conn = null;
        // show confirmation
        echo "Movie Saved";
    }
        //Any HTTP error will redirect to the 'error.php' page
    catch (Exception $e) {
        //Send Error Exception to email address
        mail('tristanwilson111@gmail.com', 'COMP1006 Web App Error', $e, 'From:errors@comp1006webapp.com');
        header('location:error.php');
    }
}
require_once('footer.php');
ob_flush(); ?>