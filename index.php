<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>CampusConnect</title>

<style>
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(to right, #4facfe, #00f2fe);
    text-align: center;
}

.container {
    margin-top: 150px;
}

h1 {
    font-size: 45px;
    color: white;
    margin-bottom: 30px;
}

a {
    text-decoration: none;
    padding: 12px 25px;
    margin: 10px;
    display: inline-block;
    background-color: white;
    color: #333;
    border-radius: 25px;
    font-weight: bold;
    transition: 0.3s;
}

a:hover {
    background-color: #333;
    color: white;
}
</style>

</head>
<body>

<div class="container">
    <h1>Welcome to CampusConnect</h1>

    <?php if(isset($_SESSION['user'])) { ?>
        <a href="home.php">Go to Home</a>
        <a href="logout.php">Logout</a>
    <?php } else { ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    <?php } ?>
</div>

</body>
</html>