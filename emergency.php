<?php
include 'config.php';

if(isset($_POST['add'])){
    $name = $_POST['contact_name'];
    $phone = $_POST['phone'];

    mysqli_query($conn,"INSERT INTO emergency(contact_name,phone)
                        VALUES('$name','$phone')");
}

$result = mysqli_query($conn,"SELECT * FROM emergency");
?>

<h2>Emergency Contacts</h2>

<form method="post">
<input type="text" name="contact_name" placeholder="Contact Name" required><br>
<input type="text" name="phone" placeholder="Phone Number" required><br>
<button name="add">Add</button>
</form>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
    <p><b><?php echo $row['contact_name']; ?></b> - <?php echo $row['phone']; ?></p>
<?php } ?>

<a href="home.php">Back</a>