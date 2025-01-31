<?php
include '../config/database.php';

// Check if ID exists
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid request!";
    exit;
}

$id = intval($_GET['id']); // Prevent SQL injection
$sql = "DELETE FROM users WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: ../index.php?msg=deleted");
    exit;
} else {
    echo "Error deleting record: " . $conn->error;
}
?>
