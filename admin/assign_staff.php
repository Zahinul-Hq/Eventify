<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

include(__DIR__ . '/../includes/db.php');

$R_ID = $_GET['R_ID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $R_ID = $_POST['R_ID'];
    $status = 'Approved';

    // Assign Staff
    foreach ($_POST['staff'] as $staff_id) {
        $assign_sql = "INSERT INTO assign (Staff_ID, R_ID) VALUES ('$staff_id', '$R_ID')";
        $conn->query($assign_sql);
    }

    // Update Reservation Status
    $update_sql = "UPDATE reservation SET Status='$status' WHERE R_ID='$R_ID'";
    $conn->query($update_sql);

    header('Location: approve_reservations.php');
    exit();
}

// Fetch available staff for the reservation date
$reservation_sql = "SELECT Date FROM reservation WHERE R_ID='$R_ID'";
$reservation_result = $conn->query($reservation_sql);
$reservation_date = $reservation_result->fetch_assoc()['Date'];

$staff_sql = "SELECT Staff_ID, Name, Designation FROM staff WHERE Staff_ID NOT IN (
                SELECT Staff_ID FROM assign WHERE R_ID IN (
                    SELECT R_ID FROM reservation WHERE Date='$reservation_date'))";
$staff_result = $conn->query($staff_sql);

$staff_by_designation = [];
while ($staff = $staff_result->fetch_assoc()) {
    $staff_by_designation[$staff['Designation']][] = $staff;
}
?>
<?php include(__DIR__ . '/../customer_navbar.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Staff</title>
    <link rel="stylesheet" href="assign_staff_styles.css">
</head>
<body>
    <div class="container">
        <h2>Assign Staff & Approve Reservation</h2>
        <form action="assign_staff.php" method="post">
            <input type="hidden" name="R_ID" value="<?php echo $R_ID; ?>">
            <div class="form-group">
                <label for="staff_manager">Manager</label>
                <select class="form-control" id="staff_manager" name="staff[]" required>
                    <option value="">Select Manager</option>
                    <?php foreach ($staff_by_designation['Manager'] as $staff): ?>
                        <option value="<?php echo $staff['Staff_ID']; ?>"><?php echo $staff['Name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="staff_cleaner">Cleaner</label>
                <select class="form-control" id="staff_cleaner" name="staff[]" multiple required>
                    <?php foreach ($staff_by_designation['Cleaner'] as $staff): ?>
                        <option value="<?php echo $staff['Staff_ID']; ?>"><?php echo $staff['Name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="staff_waiter">Waiter</label>
                <select class="form-control" id="staff_waiter" name="staff[]" multiple required>
                    <?php foreach ($staff_by_designation['Waiter'] as $staff): ?>
                        <option value="<?php echo $staff['Staff_ID']; ?>"><?php echo $staff['Name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="staff_decorator">Decorator</label>
                <select class="form-control" id="staff_decorator" name="staff[]" multiple required>
                    <?php foreach ($staff_by_designation['Decorator'] as $staff): ?>
                        <option value="<?php echo $staff['Staff_ID']; ?>"><?php echo $staff['Name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Assign Staff & Approve Reservation</button>
        </form>
    </div>
</body>
</html>
