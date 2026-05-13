<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Reservation System</title>
    <link rel="stylesheet" href="homepage_styles.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <header>
        <div class="logo">Event<span>ify</span></div>
        <nav>
            <a href="index.php" class="nav-link">Home</a>
            <a href="index.php" class="nav-link">About</a>
            <a href="index.php" class="nav-link">Services</a>
            <a href="index.php" class="nav-link">Contact</a>
        </nav>
        <a href="admin/login.php" class="admin-login-text">Admin Login</a>
    </header>

    <main>
        <section class="hero-section">
            <div class="hero-content">
                <h1>Welcome to Eventify</h1>
                <p>Your one-stop solution for effortless event planning and management.</p>
                <div class="buttons">
                    <a href="customer/register.php" class="btn btn-primary">Register as Customer</a>
                    <a href="staff/staff_register.php" class="btn btn-staff">Register as Staff</a>
                </div>
                <div class="login-section">
                    <p>Already a customer? <a href="customer/login.php" class="btn btn-primary btn-login">Login</a></p>
                </div>
            </div>
        </section>



        <section class="features-section">
            <div class="container">
                <div class="feature-card">
                    <img src="images/easy_booking.jpg" alt="Easy Booking">
                    <h2>Easy Booking</h2>
                    <p>Effortlessly book venues for your events with a user-friendly interface.</p>
                </div>
                <div class="feature-card">
                    <img src="images/manage_reservation.png" alt="Manage Reservations">
                    <h2>Manage Reservations</h2>
                    <p>Track and manage your event bookings with detailed reports and notifications.</p>
                </div>
                <div class="feature-card">
                    <img src="images/join_us.jpg" alt="Join Us as a Staff">
                    <h2>Join Us as a Staff</h2>
                    <p>Become part of our team to assist with event management and coordination.</p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
