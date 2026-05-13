<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit();
}

include(__DIR__ . '/../includes/db.php');

$R_ID = $_GET['R_ID'];

$sql = "SELECT e.total_guests, e.menu, v.cost, c.name, c.email, c.phone_no
        FROM reservation r
        JOIN event e ON r.E_ID = e.E_ID
        JOIN venue v ON r.V_ID = v.V_ID
        JOIN customer c ON r.C_ID = c.C_ID
        WHERE r.R_ID = '$R_ID'";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_guests = $row['total_guests'];
    $menu = $row['menu'];
    $cost = $row['cost'];
    $customer_name = $row['name'];
    $customer_email = $row['email'];
    $customer_phone = $row['phone_no'];
    $val = 320;

    switch($menu) {
        case 'Simple':
            $val = 320;
            break;
        case 'Delux':
            $val = 550;
            break;
        case 'Super Delux':
            $val = 760;
            break;
        case 'VIP':
            $val = 1000;
            break;
        case 'Buffet':
            $val = 800;
            break;
    }

    $amount = $total_guests * $val + $cost;
} else {
    echo "No reservation details found.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Payment</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Reservation Details</h2>
        <p><strong>Customer Name:</strong> <?php echo $customer_name; ?></p>
        <p><strong>Email:</strong> <?php echo $customer_email; ?></p>
        <p><strong>Phone:</strong> <?php echo $customer_phone; ?></p>
        <p><strong>Total Guests:</strong> <?php echo $total_guests; ?></p>
        <p><strong>Menu:</strong> <?php echo $menu; ?></p>
        <p><strong>Venue Cost:</strong> <?php echo $cost; ?></p>
        <p><strong>Total Amount:</strong> <?php echo $amount; ?></p>
        <form action="billing.php" method="post">
            <input type="hidden" name="R_ID" value="<?php echo $R_ID; ?>">
            <input type="hidden" name="amount" value="<?php echo $amount; ?>">
            <button type="submit" class="btn">Proceed to Billing</button>
        </form>
    </div>
</body>
</html>
