<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
    
    <?php if (!empty($_SESSION['profile_picture'])): ?>
        <p><img src="<?php echo htmlspecialchars($_SESSION['profile_picture']); ?>" width="150"></p>
    <?php else: ?>
        <p>No profile picture uploaded.</p>
    <?php endif; ?>

    <a href="logout.php">Logout</a>
</body>
</html>
