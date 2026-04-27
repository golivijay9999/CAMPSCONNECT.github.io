<?php
session_start();
include 'config.php';

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1){

        $row = mysqli_fetch_assoc($result);

        // Store user details in session
        $_SESSION['user'] = $row['email'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['role'] = $row['role'];

        header("Location: home.php");
        exit();

    } else {
        $error = "Invalid Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login - CampusConnect</title>

<style>
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(to right, #667eea, #764ba2);
}

.login-box {
    width: 350px;
    background: white;
    padding: 40px;
    margin: 120px auto;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    text-align: center;
}

h2 {
    margin-bottom: 20px;
}

input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
}

button {
    width: 100%;
    padding: 10px;
    background: #667eea;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background: #5a67d8;
}

.error {
    color: red;
    margin-bottom: 10px;
}

a {
    display: block;
    margin-top: 15px;
    text-decoration: none;
    color: #667eea;
}
</style>

</head>
<body>

<div class="login-box">
    <h2>Login to CampusConnect</h2>

    <?php if(isset($error)) { ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>

    <form method="post">
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <button type="submit" name="login">Login</button>
    </form>

    <a href="register.php">Don't have an account? Register</a>
</div>

</body>
</html>