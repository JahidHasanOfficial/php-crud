<?php include 'config/database.php'; ?>
<?php include 'includes/header.php'; ?>

<h2>User List</h2>
<a href="pages/create.php" class="btn btn-success mb-3">Add User</a>

<?php
// Pagination setup
$limit = 5; // Show 5 records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total records
$totalQuery = $conn->query("SELECT COUNT(*) AS total FROM users");
$totalRow = $totalQuery->fetch_assoc();
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);

// Fetch data with pagination
$sql = "SELECT * FROM users LIMIT $offset, $limit";
$result = $conn->query($sql);

// Set serial number (SL)
$sl = $offset + 1;
?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>SL</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $sl++; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['email']; ?></td>
                <td><?= $row['phone']; ?></td>
                <td>
                    <a href="pages/update.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="javascript:void(0);" onclick="confirmDelete(<?= $row['id']; ?>)" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- JavaScript for delete confirmation -->
<script>
function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this record?")) {
        window.location.href = "pages/delete.php?id=" + id;
    }
}
</script>

<?php include 'includes/footer.php'; ?>
