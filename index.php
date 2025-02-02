<?php include 'config/database.php'; ?>
<?php include 'includes/header.php'; ?>

<h2>User List</h2>
<a href="pages/create.php" class="btn btn-success mb-3">Add User</a>

<!-- Search Form -->
<form method="GET" action="" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search by name, email, or phone" value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button type="submit" class="btn btn-primary">Search</button>
        <a href="index.php" class="btn btn-secondary">Reset</a>
    </div>
</form>

<?php
// Pagination setup
$limit = 5; // Show 5 records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search filter
$searchQuery = "";
if (!empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $searchQuery = "WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%'";
}

// Get total records after search
$totalQuery = $conn->query("SELECT COUNT(*) AS total FROM users $searchQuery");
$totalRow = $totalQuery->fetch_assoc();
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);

// Fetch data with pagination & search
$sql = "SELECT * FROM users $searchQuery LIMIT $offset, $limit";
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
        <?php if ($result->num_rows > 0): ?>
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
        <?php else: ?>
            <tr><td colspan="5" class="text-center">No records found</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Pagination -->
<nav>
    <ul class="pagination justify-content-center">
        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="?search=<?= isset($search) ? $search : ''; ?>&page=<?= $page - 1; ?>">Previous</a>
        </li>
        
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                <a class="page-link" href="?search=<?= isset($search) ? $search : ''; ?>&page=<?= $i; ?>"><?= $i; ?></a>
            </li>
        <?php endfor; ?>

        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
            <a class="page-link" href="?search=<?= isset($search) ? $search : ''; ?>&page=<?= $page + 1; ?>">Next</a>
        </li>
    </ul>
</nav>

<!-- JavaScript for delete confirmation -->
<script>
function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this record?")) {
        window.location.href = "pages/delete.php?id=" + id;
    }
}
</script>

<?php include 'includes/footer.php'; ?>
