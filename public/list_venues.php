<?php
include(__DIR__ . '/../includes/db.php');

$sql = "SELECT * FROM venues";
$result = $conn->query($sql);
?>
<?php include(__DIR__ . '/../includes/header.php'); ?>
    <h2>List of Venues</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Capacity</th>
                <th>Cost</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($venue = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $venue['V_ID']; ?></td>
                    <td><?php echo $venue['Type']; ?></td>
                    <td><?php echo $venue['Capacity']; ?></td>
                    <td><?php echo $venue['Cost']; ?></td>
                    <td><?php echo $venue['V_Name']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php include(__DIR__ . '/../includes/footer.php'); ?>
