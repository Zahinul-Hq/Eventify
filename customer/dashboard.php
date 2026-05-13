<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit();
}
?>
<?php include(__DIR__ . '/../customer_navbar.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="dashboard_styles.css">
</head>
<body>
    <div class="container">
        <h2>Customer Dashboard</h2>
        <div class="card-container">
            <a href="create_reservation.php" class="card">
                <h3>Create Reservation</h3>
            </a>
            <a href="view_reservations.php" class="card">
                <h3>View Reservations</h3>
            </a>
        </div>
    </div>
</body>
</html>
