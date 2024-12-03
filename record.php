<?php

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "hotel_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $roomType = htmlspecialchars($_POST['roomType']); 
    $roomCode = htmlspecialchars($_POST['roomCode']);
    $checkin = htmlspecialchars($_POST['checkin']);
    $checkout = htmlspecialchars($_POST['checkout']);


    if (empty($name) || empty($email) || empty($roomType) || empty($roomCode) || empty($checkin) || empty($checkout)) {
        echo "All fields are required!";
        exit;
    }

    // validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit;
    }

    // Check for room availability
    $stmt = $conn->prepare("SELECT COUNT(*) FROM name WHERE roomCode = ? AND (checkinDate < ? AND checkoutDate > ?)");
    $stmt->bind_param("sss", $roomCode, $checkout, $checkin);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // Redirect to index.html with a conflict message
        header("Location: index.html?error=conflict");
        exit;
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO name (`Full Name`, email, roomType, roomCode, checkinDate, checkoutDate) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $roomType, $roomCode, $checkin, $checkout);

    // Execute the statement
    if ($stmt->execute()) {
        // Start the session and store booking details
        session_start();
        $_SESSION['bookingDetails'] = [
            'name' => $name,
            'email' => $email,
            'roomType' => $roomType,
            'roomCode' => $roomCode,
            'checkin' => $checkin,
            'checkout' => $checkout,
        ];
        // Redirect to confirmation page
        header("Location: confirm.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If the form is not submitted, redirect to the homepage or show an error
    header("Location: index.html");
    exit;
}
?>