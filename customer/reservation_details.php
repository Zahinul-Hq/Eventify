<?php
session_start();

if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit();
}

include(__DIR__ . '/../includes/db.php');
$R_ID = $_GET['R_ID'];

$reservation_sql = "
    SELECT reservation.R_ID, reservation.Status, reservation.Date AS ReservedDate,
           event.Event_Type, event.Menu, event.Total_Guests,
           venue.V_Name,
           payment.Amount
    FROM reservation
    left JOIN event ON reservation.E_ID = event.E_ID
    left JOIN venue ON reservation.V_ID = venue.V_ID
    left JOIN payment ON reservation.R_ID = payment.R_ID
    WHERE reservation.R_ID='$R_ID'";
$reservation_result = $conn->query($reservation_sql);
$reservation = $reservation_result->fetch_assoc();

$staff_sql = "
    SELECT staff.Name, staff.Designation
    FROM assign
    JOIN staff ON assign.Staff_ID = staff.Staff_ID
    WHERE assign.R_ID='$R_ID'";
$staff_result = $conn->query($staff_sql);
$staff_by_designation = [];
while ($staff = $staff_result->fetch_assoc()) {
    $staff_by_designation[$staff['Designation']][] = $staff['Name'];
}
?>
<?php include(__DIR__ . '/../customer_navbar.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Details</title>
    <link rel="stylesheet" href="reservation_details.css">
</head>
<body>
    <div class="container">
        <h2>Reservation Details</h2>
        <div class="details-box">
            <h3>Reservation Information</h3>
            <p><strong>ID:</strong> <?php echo $reservation['R_ID']; ?></p>
            <p><strong>Status:</strong> <?php echo $reservation['Status']; ?></p>
            <p><strong>Reserved Date:</strong> <?php echo $reservation['ReservedDate']; ?></p>
        </div>
        <div class="details-box">
            <h3>Event Information</h3>
            <p><strong>Event Type:</strong> <?php echo $reservation['Event_Type']; ?></p>
            <p><strong>Menu:</strong> <?php echo $reservation['Menu']; ?></p>
            <p><strong>Total Guests:</strong> <?php echo $reservation['Total_Guests']; ?></p>
        </div>
        <div class="details-box">
            <h3>Venue Information</h3>
            <p><strong>Venue Name:</strong> <?php echo $reservation['V_Name']; ?></p>
        </div>
        <div class="details-box">
            <h3>Payment Information</h3>
            <?php if ($reservation['Amount']): ?>
                <p><strong>Amount:</strong> <?php echo $reservation['Amount']; ?></p>
            <?php else: ?>
                <p>Payment Pending</p>
            <?php endif; ?>
        </div>
        <div class="details-box">
            <h3>Assigned Staff</h3>
            <?php foreach ($staff_by_designation as $designation => $names): ?>
                <p><strong><?php echo $designation; ?>:</strong> <?php echo implode(', ', $names); ?></p>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
