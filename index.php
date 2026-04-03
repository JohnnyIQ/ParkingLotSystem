<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "parking_lot_db";

// Connect
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Vehicles
$vehicles = $conn->query("SELECT * FROM Vehicle");

// Fetch Parking Spots
$spots = $conn->query("SELECT * FROM ParkingSpot");

// Fetch Tickets with Payments
$tickets = $conn->query("
    SELECT t.ticket_id, t.status, v.plate_number, p.amount, p.payment_time
    FROM Ticket t
    JOIN EntryLog el ON t.log_id = el.log_id
    JOIN Vehicle v ON el.vehicle_id = v.vehicle_id
    LEFT JOIN Payment p ON t.ticket_id = p.ticket_id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Parking Lot Management System</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background-color: #f2f2f2; }
        h2 { margin-top: 40px; }
    </style>
</head>
<body>

<h1>Parking Lot Management System</h1>

<h2>Vehicles</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Plate Number</th>
        <th>Type</th>
    </tr>
    <?php while($row = $vehicles->fetch_assoc()): ?>
    <tr>
        <td><?= $row['vehicle_id'] ?></td>
        <td><?= $row['plate_number'] ?></td>
        <td><?= $row['vehicle_type'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<h2>Parking Spots</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Spot Number</th>
        <th>Type</th>
        <th>Available</th>
    </tr>
    <?php while($row = $spots->fetch_assoc()): ?>
    <tr>
        <td><?= $row['spot_id'] ?></td>
        <td><?= $row['spot_number'] ?></td>
        <td><?= $row['spot_type'] ?></td>
        <td><?= $row['is_available'] ? 'Yes' : 'No' ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<h2>Tickets & Payments</h2>
<table>
    <tr>
        <th>Ticket ID</th>
        <th>Plate Number</th>
        <th>Status</th>
        <th>Payment Amount</th>
        <th>Payment Time</th>
    </tr>
    <?php while($row = $tickets->fetch_assoc()): ?>
    <tr>
        <td><?= $row['ticket_id'] ?></td>
        <td><?= $row['plate_number'] ?></td>
        <td><?= $row['status'] ?></td>
        <td><?= $row['amount'] ?? '-' ?></td>
        <td><?= $row['payment_time'] ?? '-' ?></td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>