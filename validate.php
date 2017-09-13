<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<body>
<?php
//Start Session
session_start();
//Store the inputs & hash the password
$username = $_POST['username'];
$password = hash('sha512', $_POST['password']);
try {
    //Connect to Database
    require_once('db.php');
    //Write the query
    $sql = "SELECT user_id FROM users WHERE username = :username AND password = :password";
    // create the command, run the query and store the result
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':username', $username, PDO::PARAM_STR, 50);
    $cmd->bindParam(':password', $password, PDO::PARAM_STR, 128);
    $cmd->execute();
    $users = $cmd->fetchAll();
    // if count is 1, we found a matching username and password in the database
    if (count($users) >= 1) {
        echo 'Logged in Successfully.';

        foreach  ($users as $user) {
            $_SESSION['user_id'] = $user['user_id'];
            header('location:menu.php');
        }
    }
    else {
        echo 'Invalid Login';
    }
    //Disconnect from Database
    $conn = null;
}
    //Any HTTP error will redirect to the 'error.php' page
    catch (Exception $e) {
        //Send Error Exception to email address
        mail('tristanwilson111@gmail.com', 'COMP1006 Web App Error', $e, 'From:errors@comp1006webapp.com');
        header('location:error.php');
}
?>
</body>
</html>
<?php ob_flush(); ?>