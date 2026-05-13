<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit();
}

include(__DIR__ . '/../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $R_ID = $_POST['R_ID'];
    $amount = $_POST['amount'];

    $sql = "SELECT c.name, c.email, c.phone_no
            FROM reservation r
            JOIN customer c ON r.C_ID = c.C_ID
            WHERE r.R_ID = '$R_ID'";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $customer_name = $row['name'];
        $customer_email = $row['email'];
        $customer_phone = $row['phone_no'];
    } else {
        echo "No customer details found.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Billing Details</h2>
        <p><strong>Customer Name:</strong> <?php echo $customer_name; ?></p>
        <p><strong>Email:</strong> <?php echo $customer_email; ?></p>
        <p><strong>Phone:</strong> <?php echo $customer_phone; ?></p>
        <p><strong>Total Amount:</strong> <?php echo $amount; ?></p>
        <form action="complete_payment.php" method="post">
            <input type="hidden" name="R_ID" value="<?php echo $R_ID; ?>">
            <input type="hidden" name="amount" value="<?php echo $amount; ?>">
            <div class="mb-3">
                <label for="card_no" class="form-label">Card Number</label>
                <input type="text" class="form-control" id="card_no" name="card_no" required>
            </div>
            <button type="submit" class="btn">Make Payment</button>
        </form>
    </div>
</body>
</html>
