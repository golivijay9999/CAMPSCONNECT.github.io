<?php
include 'config.php';

if(isset($_POST['register'])){

    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = mysqli_real_escape_string($conn, $_POST['password']);
    $role  = mysqli_real_escape_string($conn, $_POST['role']);

    $sql = "INSERT INTO users (name, email, password, role)
            VALUES ('$name', '$email', '$pass', '$role')";

    if(mysqli_query($conn, $sql)){
        $success = "Registration Successful! You can login now.";
    } else {
        $error = "Email already exists!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register - CampusConnect</title>

<style>
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(to right, #43cea2, #185a9d);
}

.register-box {
    width: 380px;
    background: white;
    padding: 40px;
    margin: 90px auto;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    text-align: center;
}

h2 {
    margin-bottom: 20px;
}

input, select {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
}

button {
    width: 100%;
    padding: 10px;
    background: #43cea2;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background: #36b38b;
}

.success {
    color: green;
    margin-bottom: 10px;
}

.error {
    color: red;
    margin-bottom: 10px;
}

a {
    display: block;
    margin-top: 15px;
    text-decoration: none;
    color: #185a9d;
}
</style>

</head>
<body>

<div class="register-box">
    <h2>Create Account</h2>

    <?php if(isset($success)) { ?>
        <div class="success"><?php echo $success; ?></div>
    <?php } ?>

    <?php if(isset($error)) { ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>

    <form method="post">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>

        <select name="role" required>
            <option value="">Select Role</option>
            <option value="student">Student</option>
            <option value="faculty">Faculty</option>
        </select>

        <button type="submit" name="register">Register</button>
    </form>

    <a href="login.php">Already have an account? Login</a>
</div>

</body>
</html>