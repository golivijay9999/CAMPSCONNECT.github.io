<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Home - CampusConnect</title>

<style>
body {
    font-family: Arial;
    background: linear-gradient(to right, #4facfe, #00f2fe);
    text-align: center;
    margin: 0;
    padding: 0;
}

.container {
    margin-top: 100px;
}

h2 {
    color: white;
}

a {
    display: inline-block;
    margin: 10px;
    padding: 10px 20px;
    background: white;
    text-decoration: none;
    border-radius: 20px;
    font-weight: bold;
    color: #333;
}

a:hover {
    background: #333;
    color: white;
}
</style>
</head>
<body>

<div class="container">
    <h2>Welcome <?php echo $_SESSION['name']; ?></h2>
    <h3>Role: <?php echo strtoupper($_SESSION['role']); ?></h3>

    <a href="events.php">Events</a>
    <a href="lostfound.php">Lost & Found</a>
    <a href="emergency.php">Emergency</a>
    <a href="logout.php">Logout</a>
</div>

</body>
</html>