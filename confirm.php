<?php
// Start the session to retrieve booking details
session_start();

// Check if booking details are set in the session
if (!isset($_SESSION['bookingDetails'])) {
    header("Location: index.html"); // Redirect to homepage if no booking details
    exit;
}

// Retrieve booking details from session
$bookingDetails = $_SESSION['bookingDetails'];

// Clear session data after retrieving
unset($_SESSION['bookingDetails']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="styleconfirm.css"> <!-- Optional: Link to CSS for styling -->
</head>
<body>
    <div class="container">
        <h1>Booking Confirmation</h1>
        <p>Thank you, <?php echo htmlspecialchars($bookingDetails['name']); ?>! Your booking has been confirmed.</p>
        <h2>Booking Details:</h2>
        <ul>
            <li><strong>Name:</strong> <?php echo htmlspecialchars($bookingDetails['name']); ?></li>
            <li><strong>Email:</strong> <?php echo htmlspecialchars($bookingDetails['email']); ?></li>
            <li><strong>Room Type:</strong> <?php echo htmlspecialchars($bookingDetails['roomType']); ?></li>
            <li><strong>Room Code:</strong> <?php echo htmlspecialchars($bookingDetails['roomCode']); ?></li>
            <li><strong>Check-in Date:</strong> <?php echo htmlspecialchars($bookingDetails['checkin']); ?></li>
            <li><strong>Check-out Date:</strong> <?php echo htmlspecialchars($bookingDetails['checkout']); ?></li>
        </ul>
        <a href="index.html">Go to Homepage</a>
    </div>
</body>
</html>