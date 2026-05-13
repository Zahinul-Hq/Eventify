<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit();
}

include(__DIR__ . '/../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $R_ID = $_POST['R_ID'];
    $card_no = $_POST['card_no'];
    $amount = $_POST['amount'];

    $sql = "INSERT INTO payment (R_ID, Card_No, Amount) VALUES ('$R_ID', '$card_no', '$amount')";
    if ($conn->query($sql) === TRUE) {
        header('Location: view_reservations.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
