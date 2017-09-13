<?php ob_start();
// authorization check
require_once('auth.php');
// Error Checking Try-Catch
try {
    require_once('db.php');
    require_once('header.php');
    // access the current session
    session_start();
    // check if there is a user identity stored in the session object
    if (empty($_SESSION['user_id'])) {
    // if there is no user_id in the session, redirect the user to the login page
        header('location:login.php');
        exit();
    }
    // capture the selected book_id from the url and store it in a variable with the same name
    $book_id = $_GET['book_id'];
    // connect to database
    require_once('db.php');
    // set up the SQL command
    $sql = "DELETE FROM books WHERE book_id = :book_id";
    // create a command object so we can populate the book_id value, the run the deletion
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':book_id', $book_id, PDO::PARAM_INT);
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
header('location:books.php');
require_once('footer.php');
ob_flush(); ?>