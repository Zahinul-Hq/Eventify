<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

include(__DIR__ . '/../includes/db.php');

$V_ID = $_GET['V_ID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    $capacity = $_POST['capacity'];
    $cost = $_POST['cost'];
    $image = $_POST['image'];
    $zip_code = $_POST['zip_code'];
    $v_name = $_POST['v_name'];

    $sql = "UPDATE venue SET Type='$type', Capacity='$capacity', Cost='$cost', Image='$image', Zip_code='$zip_code', V_Name='$v_name' WHERE V_ID='$V_ID'";
    if ($conn->query($sql) === TRUE) {
        header('Location: manage_venues.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    $sql = "SELECT * FROM venue WHERE V_ID='$V_ID'";
    $result = $conn->query($sql);
    $venue = $result->fetch_assoc();
}
?>
<?php include(__DIR__ . '/../customer_navbar.php'); ?>

<link rel="stylesheet" href="edit_venue_styles.css">
<div class="container">
    <h2 class="page-title">Edit Venue</h2>
    <form action="edit_venue.php?V_ID=<?php echo $V_ID; ?>" method="post" class="venue-form">
        <div class="form-group">
            <label for="type" class="form-label">Type</label>
            <input type="text" class="form-control" id="type" name="type" value="<?php echo $venue['Type']; ?>" required>
        </div>
        <div class="form-group">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" class="form-control" id="capacity" name="capacity" value="<?php echo $venue['Capacity']; ?>" required>
        </div>
        <div class="form-group">
            <label for="cost" class="form-label">Cost</label>
            <input type="number" class="form-control" id="cost" name="cost" value="<?php echo $venue['Cost']; ?>" required>
        </div>
        <div class="form-group">
            <label for="image" class="form-label">Image URL</label>
            <input type="text" class="form-control" id="image" name="image" value="<?php echo $venue['Image']; ?>" required>
        </div>
        <div class="form-group">
            <label for="zip_code" class="form-label">Zip Code</label>
            <input type="text" class="form-control" id="zip_code" name="zip_code" value="<?php echo $venue['Zip_code']; ?>" required>
        </div>
        <div class="form-group">
            <label for="v_name" class="form-label">Venue Name</label>
            <input type="text" class="form-control" id="v_name" name="v_name" value="<?php echo $venue['V_Name']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Venue</button>
    </form>
</div>

