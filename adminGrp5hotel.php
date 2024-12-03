<?php
session_start();
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "hotel_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = null;
$name = '';
$email = '';
$roomType = '';
$roomCode = '';
$checkin = '';
$checkout = '';
$action = 'create'; 

// form submissions for creating and updating records
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $roomType = htmlspecialchars($_POST['roomType']); 
    $roomCode = htmlspecialchars($_POST['roomCode']);
    $checkin = htmlspecialchars($_POST['checkin']);
    $checkout = htmlspecialchars($_POST['checkout']);
    $action = htmlspecialchars($_POST['action']);
    $id = isset($_POST['id']) ? intval($_POST['id']) : null; 

    if ($action === 'create') {
        // Insert new record
        $stmt = $conn->prepare("INSERT INTO name (`Full Name`, email, roomType, roomCode, checkinDate, checkoutDate) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $roomType, $roomCode, $checkin, $checkout);
        if ($stmt->execute()) {
            echo "Reservation created successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } elseif ($action === 'update' && $id !== null) {
        // Update existing record
        $stmt = $conn->prepare("UPDATE name SET `Full Name` = ?, email = ?, roomType = ?, roomCode = ?, checkinDate = ?, checkoutDate = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $name, $email, $roomType, $roomCode, $checkin, $checkout, $id);
        if ($stmt->execute()) {
            echo "Reservation Updated successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// delete record
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM name WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// get record
$result = $conn->query("SELECT * FROM name");
$records = [];                                      //make array for the record

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;                          // Store records in array
    }
}

// Check if edit is requested
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM name WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $record = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($record) {
        // auto fill form for edit
        $name = $record['Full Name'];
        $email = $record['email'];
        $roomType = $record['roomType'];
        $roomCode = $record['roomCode'];
        $checkin = $record['checkinDate'];
        $checkout = $record['checkoutDate'];
        $action = 'update';                         // update record
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin.css"> 
    <script src="admin.js"></script>
    <script>
        <?php if (isset($_GET['edit'])): ?>
        window.onload = function() {
            showSection('editSection');
        };
    <?php endif; ?>
    </script>
</head>
<body>
    <header>
        <h1>CasaGrande Hotel</h1>
    </header>
    <div class="main">

    <div class="sidebar">
        <h2>Menu</h2>
        <ul>
            <li><a href="javascript:void(0);" onclick="showSection('tableSection')">Current Booking</a></li>
            <li><a href="javascript:void(0);" onclick="showSection('addSection')">Add Booking</a></li>
            <li><a href="javascript:void(0);" onclick="showSection('editSection')">Edit Bookings</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Admin Panel</h2>

        <div id="tableSection" class="hidden">
            <h3 id="current-bookings">Current Bookings</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Room Type</th>
                    <th>Room Code</th>
                    <th>Check-in Date</th>
                    <th>Check-out Date</th>
                </tr>
                <?php foreach ($records as $row): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['Full Name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['roomType']; ?></td>
                        <td><?php echo $row['roomCode']; ?></td>
                        <td><?php echo $row['checkinDate']; ?></td>
                        <td><?php echo $row['checkoutDate']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div id="addSection" class="hidden">
            <h3 id="add-booking">Add Booking</h3>
            <form method="POST" action="adminGrp5hotel.php">
                <input type="hidden" name="action" value="create">
                <label>Name: <input type="text" name="name" required></label><br>
                <label>Email: <input type="email" name="email" required></label><br>
                <label>Room Type: <input type="text" name="roomType" required></label><br>
                <label>Room Code: <input type="text" name="roomCode" required></label><br>
                <label>Check-in Date: <input type="date" name="checkin" required></label><br>
                <label>Check-out Date: <input type="date" name="checkout" required></label><br>
                <input type="submit" value="Add Booking">
            </form>
        </div>

        <div id="editSection" class="hidden">
            <h3 id="edit-bookings"> Edit Bookings</h3>
            <form method="POST" action="adminGrp5hotel.php">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="action" value="update">
                <label>Name: <input type="text" name="name" value="<?php echo $name; ?>" required></label><br>
                <label>Email: <input type="email" name="email" value="<?php echo $email; ?>" required></label><br>
                <label>Room Type: <input type="text" name="roomType" value="<?php echo $roomType; ?>" required></label><br>
                <label>Room Code: <input type="text" name="roomCode" value="<?php echo $roomCode; ?>" required></label><br>
                <label>Check-in Date: <input type="date" name="checkin" value="<?php echo $checkin; ?>" required></label><br>
                <label>Check-out Date: <input type="date" name="checkout" value="<?php echo $checkout; ?>" required></label><br>
                <input type="submit" value="Update Booking">
            </form>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Room Type</th>
                    <th>Room Code</th>
                    <th>Check-in Date</th>
                    <th>Check-out Date</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($records as $row): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['Full Name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['roomType']; ?></td>
                        <td><?php echo $row['roomCode']; ?></td>
                        <td><?php echo $row['checkinDate']; ?></td>
                        <td><?php echo $row['checkoutDate']; ?></td>
                        <td>
                            <a href="adminGrp5hotel.php?edit=<?php echo $row['id']; ?>">Edit</a>
                            <a href="adminGrp5hotel.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
            </table>
        </div>
        
    </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>