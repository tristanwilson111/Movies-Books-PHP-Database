<?php ob_start();
// Authentication Check
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
$page_title = 'Book Selection';
require_once('header.php');
//IF user book id value IS NOT empty
if (empty($_GET['book_id']) == false) {
    //Set $book_id equal to value from previous page
    $book_id = $_GET['book_id'];
// Error Checking Try-Catch
    try {
        // connect
        require_once('db.php');
        // write the sql query
        $sql = "SELECT * FROM books WHERE book_id = :book_id";
        // execute the query and store the results
        $cmd = $conn->prepare($sql);
        $cmd->bindParam(':book_id', $book_id, PDO::PARAM_INT);
        $cmd->execute();
        $books = $cmd->fetchAll();
        // populate the fields for the selected book from the query result
        foreach ($books as $book) {
            $title = $book['title'];
            $author = $book['author'];
            $year = $book['year'];
        }
        // disconnect
        $conn = null;
    }
    catch (Exception $e) {
        //Send Error Exception to email address
        mail('tristanwilson111@gmail.com', 'COMP1006 Web App Error', $e, 'From:errors@comp1006webapp.com');
        header('location:error.php');
    }
}
?>
<div class="container">
    <h1>Book Details</h1>
    <form method="post" action="save-book.php">
        <fieldset class="form-group">
            <label for="title" class="col-sm-2">Title:</label>
            <input name="title" id="title" required value="<?php echo $title; ?>"/>
        </fieldset>
        <fieldset class="form-group">
            <label for="author" class="col-sm-2">Author:</label>
            <input name="author" id="author" required value="<?php echo $author; ?>"/>
        </fieldset>
        <fieldset class="form-group">
            <label for="year" class="col-sm-2">Year:</label>
            <input name="year" id="year" required type="number" value="<?php echo $year; ?>"/>
        </fieldset>
        <input name="book_id" type="hidden" value="<?php echo $book_id; ?>" />
        <button type="submit" class="col-sm-offset-2 btn btn-success">Submit</button>
    </form>
</div>
<?php
require_once('footer.php');
ob_flush(); ?>