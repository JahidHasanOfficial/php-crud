<?php include 'config/database.php'; ?>
<?php include 'includes/header.php'; ?>

<h2>User List</h2>
<a href="pages/create.php" class="btn btn-success mb-3">Add User</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['phone']}</td>
                <td>
                    <a href='pages/update.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                    <a href='pages/delete.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                </td>
            </tr>";
        }
        ?>
    </tbody>
</table>

<?php include 'includes/footer.php'; ?>
