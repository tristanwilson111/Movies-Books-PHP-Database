<?php ob_start();
// authorization check
require_once('auth.php');
$page_title = null;
$page_title = 'Saving your Book...';
require_once('header.php');
// access the current session
session_start();
// check if there is a user identity stored in the session object
if (empty($_SESSION['user_id'])) {
// if there is no user_id in the session, redirect the user to the login page
    header('location:login.php');
    exit();
}
// store the book_id if we are editing.  if we are adding, this value will be empty (which is ok)
$book_id = $_POST['book_id'];
// save form inputs into variables
$title = $_POST['title'];
$author = $_POST['author'];
$year = $_POST['year'];
// create a variable to indicate if the form data is ok to save or not
$ok = true;
// check each value
if (empty($title)) {
    // notify the user
    echo 'Title is required<br />';
    // change $ok to false so we know not to save
    $ok = false;
}
if (empty($author)) {
    // notify the user
    echo 'Author is required<br />';
    // change $ok to false so we know not to save
    $ok = false;
}
elseif (is_numeric($year) == false) {
    echo 'Year is invalid<br />';
    $ok = false;
}
// check the $ok variable and save the data if $ok is still true (meaning we didn't find any errors)

if ($ok == true) {
    // Error Checking Try-Catch
    try {
        // connect to the database
        require_once('db.php');
        // set up the SQL INSERT command
        if (empty($book_id)) {
            // set up the SQL INSERT command
            $sql = "INSERT INTO books (title, author, year) VALUES (:title, :author, :year)";
        } else {
            // set up the SQL UPDATE command to modify the existing book
            $sql = "UPDATE books SET title = :title, author = :author, year = :year WHERE book_id = :book_id";
        }
        $cmd = $conn->prepare($sql);
        // create a command object and fill the parameters with the form values
        $cmd->bindParam(':title', $title, PDO::PARAM_STR, 50);
        $cmd->bindParam(':author', $author, PDO::PARAM_STR);
        $cmd->bindParam(':year', $year, PDO::PARAM_INT);
        // fill the book_id if we have one
        if (!empty($book_id)) {
            $cmd->bindParam(':book_id', $book_id, PDO::PARAM_INT);
        }
        // execute the command
        $cmd->execute();
        // disconnect from the database
        $conn = null;
        // show confirmation
        echo "Book Saved";
    } //Any HTTP error will redirect to the 'error.php' page
    catch (Exception $e) {
        //Send Error Exception to email address
        mail('tristanwilson111@gmail.com', 'COMP1006 Web App Error', $e, 'From:errors@comp1006webapp.com');
        header('location:error.php');
    }
}
require_once('footer.php');
ob_flush(); ?>