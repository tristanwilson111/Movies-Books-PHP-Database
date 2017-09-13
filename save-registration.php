<?php ob_start();
$page_title = null;
$page_title = "Saving your Registration...";
require_once('header.php');
//1. Store form inputs & variables
$username = $_POST['username'];
$password = $_POST['password'];
$confirm = $_POST['confirm'];
$ok = true;
//2. Validate the inputs - No blanks, Matching Passwords
if (empty($username)) {
    echo 'Email is required<br />';
    $ok = false;
}
if (empty($password)) {
    echo 'Password is required<br />';
    $ok = false;
}

if (empty($confirm)) {
    echo 'Confirm Password is required<br />';
    $ok = false;
}

if ($password != $confirm) {
    echo 'Passwords must match<br />';
    $ok = false;
}
//3. If inputs are valid, Connect
if ($ok) {
    try {
        // Connect to the database
        require_once('db.php');

        //4. Set up the SQL Command
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";

        //5. Hash the password
        $hashed_password = hash('sha512', $password);

        //6. Execute the save
        $cmd = $conn->prepare($sql);
        $cmd->bindParam(':username', $username, PDO::PARAM_STR, 50);
        $cmd->bindParam(':password', $hashed_password, PDO::PARAM_STR, 128);
        $cmd->execute();

        //7. Disconnect
        $conn = null;

        //8. Show confirmation message to user
        echo 'User Saved';
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
