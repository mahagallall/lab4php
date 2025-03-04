<?php
session_start();
define('USER_FILE', 'users');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $room_number = $_POST['room_number'];
    $profile_picture = $_FILES['profile_picture'];
    $errors = [];

    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

   
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (strlen($password) < 8 || strlen($password) > 16 || !preg_match("/^[a-z0-9_]+$/", $password)) {
        $errors[] = "Password must be 8-16 characters long and contain only lowercase letters, numbers, and underscores.";
    }

    
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $file_extension = strtolower(pathinfo($profile_picture['name'], PATHINFO_EXTENSION));

    if (!in_array($file_extension, $allowed_extensions) || getimagesize($profile_picture['tmp_name']) === false) {
        $errors[] = "Profile picture must be a valid image (JPG, JPEG, PNG, GIF).";
    }

    if ($profile_picture['size'] > 2 * 1024 * 1024) {
        $errors[] = "Profile picture size must be less than 2MB.";
    }

    
    if ($profile_picture['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "File upload error: " . $profile_picture['error'];
    }

   
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        
        $upload_directory = "images/";
        if (!is_dir($upload_directory)) {
            mkdir($upload_directory, 0777, true);
        }

        
        $unique_filename = uniqid() . "." . $file_extension;
        $upload_path = $upload_directory . $unique_filename;

        
        if (move_uploaded_file($profile_picture['tmp_name'], $upload_path)) {
            
            $user_data = "$name|$email|$hashed_password|$room_number|$upload_path\n";
            file_put_contents(USER_FILE, $user_data, FILE_APPEND);

            
            $_SESSION['user'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['profile_picture'] = $upload_path;

            
            header("Location: welcome.php");
            exit();
        } else {
            echo "<p style='color:red;'>Error moving uploaded file.</p>";
        }
    } else {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
