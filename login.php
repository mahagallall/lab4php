<?php
session_start();
define('USER_FILE', 'users');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_email = trim($_POST['login_email']);
    $login_password = $_POST['login_password'];
    $users = file(USER_FILE, FILE_IGNORE_NEW_LINES);
    $authenticated = false;

    foreach ($users as $user) {
        list($name, $email, $stored_password, $room_number, $profile_picture) = explode("|", trim($user));

        
        if ($email === $login_email && password_verify($login_password, $stored_password)) {
            $_SESSION['user'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['profile_picture'] = $profile_picture; 

            
            header("Location: welcome.php");
            exit();
        }
    }

    
    echo "<p style='color:red;'>Invalid email or password.</p>";
}
