<?php
include(__DIR__ . '/../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = $_POST['phone'];
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_path = 'uploads/' . basename($image);

    if (move_uploaded_file($image_tmp, $image_path)) {
        $stmt = $conn->prepare("INSERT INTO staff (phone, image, name, designation) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $phone, $image_path, $name, $designation);

        if ($stmt->execute()) {
            $success_message = "Staff member registered successfully!";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error_message = "Failed to upload image.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="staff_register_styles.css">
</head>
<body>

    <div class="register-container">
        <div class="register-card">
            <h2>Staff Registration</h2>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <form action="staff_register.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                                <div class="mb-3">
                    <label for="designation" class="form-label">Designation</label>
                    <select id="designation" name="designation" class="form-control" required>
                        <option value="" disabled selected>Select Designation</option>
                        <option value="Manager">Manager</option>
                        <option value="Waiter">Waiter</option>
                        <option value="Decorator">Decorator</option>
                        <option value="Cleaner">Cleaner</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Upload Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept=".jpg, .jpeg, .png, .gif" required>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
</body>


