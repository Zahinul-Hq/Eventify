<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit();
}

include(__DIR__ . '/../includes/db.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $C_ID = $_SESSION['customer_id'];
    $V_ID = $_POST['V_ID'];
    $Event_type = $_POST['Event_type'];
    $status = 'Pending';
    $date = $_POST['date'];
    $total_guests = $_POST['total_guests'];
    $menu = $_POST['menu'];

    // Insert into event table
    $event_sql = "INSERT INTO event (Event_Type, Menu, Total_Guests, zip_code) VALUES ('$Event_type', '$menu', '$total_guests', (SELECT Zip_code FROM venue WHERE V_ID='$V_ID'))";

    if ($conn->query($event_sql) === TRUE) {
        // Get the newly inserted event ID
        $E_ID = $conn->insert_id;
        
        // Insert into reservation table
        $reservation_sql = "INSERT INTO reservation (C_ID, V_ID, E_ID, Date, Status) VALUES ('$C_ID', '$V_ID', '$E_ID', '$date', '$status')";
        
        if ($conn->query($reservation_sql) === TRUE) {
            header('Location: view_reservations.php');
            exit();
        } else {
            echo "Error: " . $reservation_sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $event_sql . "<br>" . $conn->error;
    }
}

$zip_code = isset($_GET['zip_code']) ? $_GET['zip_code'] : '';
$venues_sql = "SELECT * FROM venue";
if (!empty($zip_code)) {
    $venues_sql .= " WHERE Zip_code = '$zip_code'";
}
$venues = $conn->query($venues_sql);
$events = $conn->query("SELECT * FROM event");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Reservation</title>
    <link rel="stylesheet" href="create_reservation_styles.css">
    <script>
        function filterVenues() {
            const zipCode = document.getElementById('zip_code').value;
            window.location.href = 'create_reservation.php?zip_code=' + zipCode;
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Create Reservation</h2>
        <form action="create_reservation.php" method="post">
            <div class="form-group">
                <label for="zip_code" class="form-label">Zip Code</label>
                <input type="text" class="form-control small-input" id="zip_code" name="zip_code" value="<?php echo $zip_code; ?>" onchange="filterVenues()">
            </div>
            <div class="form-group">
                <label for="V_ID" class="form-label">Venue</label>
                <select class="form-control" id="V_ID" name="V_ID" required>
                    <option value="">Select Venue</option>
                    <?php while ($venue = $venues->fetch_assoc()): ?>
                        <option value="<?php echo $venue['V_ID']; ?>"><?php echo $venue['V_Name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="Event_type" class="form-label">Event Type</label>
                <input type="text" class="form-control" id="Event_type" name="Event_type" required>
            </div>
            <div class="form-group">
                <label for="total_guests" class="form-label">Total Guests</label>
                <input type="number" class="form-control small-input" id="total_guests" name="total_guests" required>
            </div>
            <div class="form-group">
                <label for="menu" class="form-label">Menu</label>
                <select class="form-control medium-input" id="menu" name="menu" required>
                    <option value="Simple">Simple</option>
                    <option value="Delux">Delux</option>
                    <option value="Super Delux">Super Delux</option>
                    <option value="VIP">VIP</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control medium-input" id="date" name="date" required>
            </div>
            <button type="submit" class="btn">Create Reservation</button>
        </form>
    </div>
</body>
</html>

