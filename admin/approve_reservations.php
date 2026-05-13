<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

include(__DIR__ . '/../includes/db.php');

$sql = "SELECT reservation.R_ID, reservation.Status, reservation.Date,
        CASE WHEN payment.R_ID IS NOT NULL THEN 'Paid' ELSE 'Pending' END AS PaymentStatus
        FROM reservation 
        LEFT JOIN payment ON reservation.R_ID = payment.R_ID
        WHERE reservation.Status='Pending'";
$result = $conn->query($sql);
?>
<?php include(__DIR__ . '/../customer_navbar.php'); ?>

<link rel="stylesheet" href="approve_reservation_styles.css">
<div class="container">
    <h2>Approve Reservations</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Date</th>
                <th>Payment Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($reservation = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $reservation['R_ID']; ?></td>
                    <td><?php echo $reservation['Status']; ?></td>
                    <td><?php echo $reservation['Date']; ?></td>
                    <td><?php echo $reservation['PaymentStatus']; ?></td>
                    <td>
                        <?php if ($reservation['Status'] == 'Pending'): ?>
                            <a href="assign_staff.php?R_ID=<?php echo $reservation['R_ID']; ?>" class="btn btn-primary">Assign Staff & Approve Reservation</a>
                        <?php else: ?>
                            <span class="badge badge-success">Approved</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include(__DIR__ . '/../includes/footer.php'); ?>
