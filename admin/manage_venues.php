<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

include(__DIR__ . '/../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        $V_ID = $_POST['V_ID'];
        $sql = "DELETE FROM venue WHERE V_ID = '$V_ID'";
        $conn->query($sql);
    }
}

$sql = "SELECT * FROM venue";
$result = $conn->query($sql);
?>
<?php include(__DIR__ . '/../customer_navbar.php'); ?>

    <link rel="stylesheet" href="manage_venues_styles.css">
    <div class="container">
        <h2 class="page-title">Manage Venues</h2>
        <a href="add_venue.php" class="btn btn-success mb-3">Add New Venue</a>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Capacity</th>
                        <th>Cost</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($venue = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $venue['V_ID']; ?></td>
                            <td><?php echo $venue['Type']; ?></td>
                            <td><?php echo $venue['Capacity']; ?></td>
                            <td><?php echo $venue['Cost']; ?></td>
                            <td>
                                <a href="edit_venue.php?V_ID=<?php echo $venue['V_ID']; ?>" class="btn btn-warning">Edit</a>
                                <form action="manage_venues.php" method="post" style="display:inline;">
                                    <input type="hidden" name="V_ID" value="<?php echo $venue['V_ID']; ?>">
                                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php include(__DIR__ . '/../includes/footer.php'); ?>
