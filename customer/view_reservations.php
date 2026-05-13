<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit();
}

include(__DIR__ . '/../includes/db.php');

$C_ID = $_SESSION['customer_id'];

$sql = "SELECT reservation.R_ID, reservation.Status, reservation.Date AS ReservedDate,
        CASE WHEN payment.R_ID IS NOT NULL THEN 'Paid' ELSE 'Pending' END AS PaymentStatus
        FROM reservation 
        LEFT JOIN payment ON reservation.R_ID = payment.R_ID
        WHERE reservation.C_ID='$C_ID'";
$result = $conn->query($sql);
?>
<?php include(__DIR__ . '/../customer_navbar.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reservations</title>
    <link rel="stylesheet" href="view_reservations.css">
</head>
<body>
    <div class="container">
        <h2>View Reservations</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Reserved Date</th>
                    <th>Payment Status</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($reservation = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $reservation['R_ID']; ?></td>
                        <td><?php echo $reservation['Status']; ?></td>
                        <td><?php echo $reservation['ReservedDate']; ?></td>
                        <td>
                            <?php if ($reservation['PaymentStatus'] == 'Paid'): ?>
                                Paid
                            <?php else: ?>
                                <a href="make_payment.php?R_ID=<?php echo $reservation['R_ID']; ?>" class="btn btn-primary">Make Payment</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="reservation_details.php?R_ID=<?php echo $reservation['R_ID']; ?>" class="btn btn-info">Details</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

