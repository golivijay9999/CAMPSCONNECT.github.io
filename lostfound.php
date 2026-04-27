<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
$email = $_SESSION['user'];

/* ---------------- ADD ITEM WITH IMAGE ---------------- */
if(isset($_POST['add'])){

    $item = mysqli_real_escape_string($conn, $_POST['item']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);

    $imageName = $_FILES['image']['name'];
    $tempName = $_FILES['image']['tmp_name'];

    $folder = "uploads/" . $imageName;

    move_uploaded_file($tempName, $folder);

    mysqli_query($conn,
        "INSERT INTO lostfound(item,details,user_email,image)
         VALUES('$item','$details','$email','$imageName')");
}

/* ---------------- DELETE (Faculty Only) ---------------- */
if(isset($_GET['delete']) && $role == 'faculty'){
    $id = $_GET['delete'];

    // delete image file also
    $getImg = mysqli_query($conn,"SELECT image FROM lostfound WHERE id=$id");
    $imgRow = mysqli_fetch_assoc($getImg);

    if($imgRow['image']){
        unlink("uploads/".$imgRow['image']);
    }

    mysqli_query($conn,"DELETE FROM lostfound WHERE id=$id");
}

$items = mysqli_query($conn,"SELECT * FROM lostfound ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Lost & Found</title>

<style>
body {
    font-family: Arial;
    background: linear-gradient(to right, #ff9966, #ff5e62);
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

img {
    width: 200px;
    height: auto;
    margin-top: 10px;
    border-radius: 8px;
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

input, textarea {
    padding: 8px;
    margin: 5px;
    width: 250px;
}
</style>
</head>
<body>

<h2>Lost & Found</h2>

<!-- Upload Form -->
<form method="post" enctype="multipart/form-data">
    <input type="text" name="item" placeholder="Item Name" required><br>
    <textarea name="details" placeholder="Item Details"></textarea><br>
    <input type="file" name="image" required><br>
    <button type="submit" name="add" class="add-btn">Post Item</button>
</form>

<hr>

<!-- Show Items -->
<?php while($row = mysqli_fetch_assoc($items)) { ?>

<div class="card">
    <h3><?php echo $row['item']; ?></h3>
    <p><?php echo $row['details']; ?></p>
    <small>Posted by: <?php echo $row['user_email']; ?></small><br>

    <?php if($row['image']) { ?>
        <img src="uploads/<?php echo $row['image']; ?>">
    <?php } ?>

    <?php if($role == 'faculty') { ?>
        <a href="lostfound.php?delete=<?php echo $row['id']; ?>">
            <button class="delete-btn">Delete</button>
        </a>
    <?php } ?>
</div>

<?php } ?>

<br>
<a href="home.php" style="color:white;">Back to Home</a>

</body>
</html>