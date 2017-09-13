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
// load header
require_once('header.php');
// Error Checking Try-Catch
try {
    // Connect
    require_once('db.php');
    // Prepare the Query
    $sql = "SELECT * FROM books";
    // Run the Query, Store the results
    $cmd = $conn->prepare($sql);
    $cmd->execute();
    $books = $cmd->fetchAll();
    // Start our grid
    echo '<h1>Book Titles</h1>
    <a href="book.php" title="Add a New Book">Add a New Book</a>
    <table class="table table-striped table-hover"><thead>
        <th>Title</th><th>Author</th><th>Year</th><th>Edit</th><th>Delete</th></thead><tbody>';
    // Loop through the data and display the results
    foreach ($books as $book) {
        echo '<tr><td>' . $book['title'] . '</td>
                    <td>' . $book['author'] . '</td>
                    <td>' . $book['year'] . '</td>
                    <td><a href="book.php?book_id=' . $book['book_id'] . '">Edit</a>
                    <td><a onclick="return confirm(\'Are you sure you want to delete this book? \');" href="delete-book.php?book_id=' . $book['book_id'] . '">Delete</a></td></tr>';
    }
    // Close the grid
    echo '</tbody></table>';
    // Disconnect
    $conn = null;
}
//Any HTTP error will redirect to the 'error.php' page
catch (Exception $e) {
    //Send Error Exception to email address
    mail('tristanwilson111@gmail.com', 'COMP1006 Web App Error', $e, 'From:errors@comp1006webapp.com');
    header('location:error.php');
}
require_once('footer.php');
ob_flush(); ?>