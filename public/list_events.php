<?php
include(__DIR__ . '/../includes/db.php');

$sql = "SELECT * FROM events";
$result = $conn->query($sql);
?>
<?php include(__DIR__ . '/../includes/header.php'); ?>
    <h2>List of Events</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Event Type</th>
                <th>Menu</th>
                <th>Total Guests</th>
                <th>Zip Code</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($event = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $event['E_ID']; ?></td>
                    <td><?php echo $event['Event_Type']; ?></td>
                    <td><?php echo $event['Menu']; ?></td>
                    <td><?php echo $event['Total_Guests']; ?></td>
                    <td><?php echo $event['Zip_code']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php include(__DIR__ . '/../includes/footer.php'); ?>
