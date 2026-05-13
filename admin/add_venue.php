<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

include(__DIR__ . '/../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    $capacity = $_POST['capacity'];
    $cost = $_POST['cost'];
    $zip_code = $_POST['zip_code'];
    $v_name = $_POST['v_name'];
    
    // Handle file upload
    $image = $_FILES['image']['name'];
    $image_temp = $_FILES['image']['tmp_name'];
    $image_path = 'uploads/' . basename($image);
    
    // Move the uploaded file to the 'uploads' directory
    if (move_uploaded_file($image_temp, $image_path)) {
        // Insert the venue details into the database
        $sql = "INSERT INTO venue (Type, Capacity, Cost, Image, Zip_code, V_Name) VALUES ('$type', '$capacity', '$cost', '$image_path', '$zip_code', '$v_name')";
        if ($conn->query($sql) === TRUE) {
            header('Location: manage_venues.php');
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Failed to upload image.";
    }
}
?>
<?php include(__DIR__ . '/../customer_navbar.php'); ?>


    <link rel="stylesheet" href="add_venue.css">
    <div class="container">
        <h2 class="page-title">Add New Venue</h2>
        <form action="add_venue.php" method="post" enctype="multipart/form-data" class="venue-form">
            <div class="form-group">
                <label for="type" class="form-label">Event Type</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="" disabled selected>Select Event Type</option>
                    <option value="Conference">Conference</option>
                    <option value="Seminar">Seminar</option>
                    <option value="Wedding">Wedding</option>
                    <option value="Birthday">Birthday</option>
                    <option value="Anniversary">Anniversary</option>
                    <option value="Fair">Fair</option>
                    <option value="Exhibition">Exhibition</option>
                    <option value="Concert">Concert</option>
                </select>
            </div>
            <div class="form-group">
                <label for="capacity" class="form-label">Capacity</label>
                <input type="number" class="form-control" id="capacity" name="capacity" required>
            </div>
            <div class="form-group">
                <label for="cost" class="form-label">Cost</label>
                <input type="number" class="form-control" id="cost" name="cost" required>
            </div>
            <div class="form-group">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="zip_code" class="form-label">Zip Code</label>
                <input type="text" class="form-control" id="zip_code" name="zip_code" required>
            </div>
            <div class="form-group">
                <label for="v_name" class="form-label">Venue Name</label>
                <input type="text" class="form-control" id="v_name" name="v_name" required>
            </div>
            <button type="submit" class="btn">Add Venue</button>
        </form>
    </div>
<?php include(__DIR__ . '/../includes/footer.php'); ?>
