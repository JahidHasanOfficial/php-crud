<?php
include '../config/database.php';

$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "UPDATE users SET name='$name', email='$email', phone='$phone' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../index.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<?php include '../includes/header.php'; ?>
<h2>Edit User</h2>
<form method="POST">
    <div class="mb-3">
        <label>Name:</label>
        <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>" required>
    </div>
    <div class="mb-3">
        <label>Email:</label>
        <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" required>
    </div>
    <div class="mb-3">
        <label>Phone:</label>
        <input type="text" name="phone" class="form-control" value="<?php echo $row['phone']; ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
<?php include '../includes/footer.php'; ?>
