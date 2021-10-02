<?php

require_once "config.php";
require_once "session.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $fullname = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST["confirm_password"]);
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    if ($query = $db->prepare("SELECT * FROM users WHERE email = ?")) {
        $error = '';
        //used to bind parameters
        $query->bind_param('s', $email);
        $query->execute();
        //stores result to check if account is in db
        $query->store_result();
            if($query->num_rows > 0) {
                $error .= '<p class="error">This email address is already registered!</p>';

            } else {
                //password validation
                if (strlen($password) < 6) {
                    $error .= '<p class="error">Password must have at least 6 characters.</p>';
                }
            }

            //confirm password
            if(empty($confirm_password)) {
                $error .= '<p class="error">Enter password again to confirm.</p>';

            } else {
                if(empty($error) && ($password != $confirm_password)) {
                    $error .= '<p class="error">Passwords did not match</p>';

                }
            }

            if (empty($error)) {
                $insertQuery = $db->prepare("INSERT INTO USERS (name, email, password) VALUES (?, ?, ?);");
                $insertQuery->bind_param("sss", $fullname, $email, $password_hash);
                $result = $insertQuery->execute();
                
                if($result) {
                    $error .= '<p class="success">Your registration was successful!</p>';

                } else {
                    $error .= '<p class="error">Something went wrong!</p>';
                }
            }
    }
}



//close DB con
mysqli_close($db);
?>

<!-- HTML PART -->

<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sign Up</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Register</h2>
                    <p>Please fill this form to create an account.</p>

                    <form action="" method="post">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div clas="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                        </div>

                        <p>Already have an account? <a href="index.php">Login here</a>.</p>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>