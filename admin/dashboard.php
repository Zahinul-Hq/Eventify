<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

 include(__DIR__ . '/../customer_navbar.php'); 
 ?>

<link rel="stylesheet" href="dashboard_styles.css">
<div class="container">
    <h2 class="dashboard-title">Admin Dashboard</h2>
    <div class="dashboard-cards">
        <a href="manage_venues.php" class="dashboard-card">
            <div class="card-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="card-content">
                <h3 class="card-title">Manage Venues</h3>
                <p class="card-description">Add, Edit, and Delete venues</p>
            </div>
        </a>
        <a href="approve_reservations.php" class="dashboard-card">
            <div class="card-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="card-content">
                <h3 class="card-title">Approve Reservations</h3>
                <p class="card-description">Review and approve reservations</p>
            </div>
        </a>
    </div>
</div>

