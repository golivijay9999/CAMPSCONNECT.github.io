<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
$email = $_SESSION['user'];

/* ---------------- ADD EVENT (Faculty Only) ---------------- */
if(isset($_POST['add']) && $role == 'faculty'){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    mysqli_query($conn,"INSERT INTO events(title,description)
                        VALUES('$title','$description')");
}

/* ---------------- REGISTER EVENT ---------------- */
if(isset($_GET['register'])){
    $event_id = $_GET['register'];

    $check = mysqli_query($conn,
        "SELECT * FROM event_registrations 
         WHERE event_id=$event_id AND user_email='$email'");

    if(mysqli_num_rows($check) == 0){
        mysqli_query($conn,
            "INSERT INTO event_registrations(event_id,user_email)
             VALUES($event_id,'$email')");
    }
}

/* ---------------- DELETE EVENT (Faculty Only) ---------------- */
if(isset($_GET['delete']) && $role == 'faculty'){
    $id = $_GET['delete'];
    mysqli_query($conn,"DELETE FROM events WHERE id=$id");
}

$events = mysqli_query($conn,"SELECT * FROM events ORDER BY id DESC");

/* ---------------- MY REGISTERED EVENTS ---------------- */
$myEvents = mysqli_query($conn,"
    SELECT events.title, events.description 
    FROM events 
    INNER JOIN event_registrations 
    ON events.id = event_registrations.event_id 
    WHERE event_registrations.user_email='$email'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Events</title>

<style>
body {
    font-family: Arial;
    background: linear-gradient(to right, #8360c3, #2ebf91);
    text-align: center;
    margin: 0;
}

h2 { color: white; }

.card {
    background: white;
    padding: 15px;
    margin: 15px auto;
    width: 60%;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

button {
    padding: 6px 12px;
    margin: 5px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.add-btn { background: green; color: white; }
.delete-btn { background: red; color: white; }
.register-btn { background: blue; color: white; }
.my-section {
    background: #ffffffcc;
    padding: 20px;
    margin: 20px auto;
    width: 70%;
    border-radius: 10px;
}
</style>
</head>
<body>

<h2>Campus Events</h2>

<!-- Faculty Add Event -->
<?php if($role == 'faculty') { ?>
<form method="post">
    <input type="text" name="title" placeholder="Event Title" required>
    <input type="text" name="description" placeholder="Description">
    <button type="submit" name="add" class="add-btn">Add Event</button>
</form>
<?php } ?>

<hr>

<!-- All Events -->
<?php while($row = mysqli_fetch_assoc($events)) { ?>

<div class="card">
    <h3><?php echo $row['title']; ?></h3>
    <p><?php echo $row['description']; ?></p>

    <!-- Register Button -->
    <?php
    $check = mysqli_query($conn,
        "SELECT * FROM event_registrations 
         WHERE event_id=".$row['id']." AND user_email='$email'");
    if(mysqli_num_rows($check) == 0){
    ?>
        <a href="events.php?register=<?php echo $row['id']; ?>">
            <button class="register-btn">Register</button>
        </a>
    <?php } else { ?>
        <button disabled>Already Registered</button>
    <?php } ?>

    <!-- Faculty Delete -->
    <?php if($role == 'faculty') { ?>
        <a href="events.php?delete=<?php echo $row['id']; ?>">
            <button class="delete-btn">Delete</button>
        </a>
    <?php } ?>

</div>

<?php } ?>

<!-- My Registered Events Section -->
<div class="my-section">
    <h3>My Registered Events</h3>

    <?php
    if(mysqli_num_rows($myEvents) > 0){
        while($m = mysqli_fetch_assoc($myEvents)){
            echo "<b>".$m['title']."</b><br>";
            echo $m['description']."<br><br>";
        }
    } else {
        echo "You have not registered for any events.";
    }
    ?>
</div>

<br>
<a href="home.php" style="color:white;">Back to Home</a>

</body>
</html>