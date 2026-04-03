<?php
include(__DIR__ . '/includes/db.php');

if(isset($_POST['create_ticket'])){
    $vehicle_id = (int)$_POST['vehicle_id'];
    $spot_id = (int)$_POST['spot_id'];

    // Insert EntryLog
    $conn->query("INSERT INTO EntryLog (vehicle_id, spot_id) VALUES ($vehicle_id, $spot_id)");
    $log_id = $conn->insert_id;

    // Insert Ticket
    $conn->query("INSERT INTO Ticket (log_id) VALUES ($log_id)");

    // Update ParkingSpot availability
    $conn->query("UPDATE ParkingSpot SET is_available=0 WHERE spot_id=$spot_id");

    header("Location: index.php");
    exit;
}

// Fetch vehicles and available spots
$vehicles = $conn->query("SELECT * FROM Vehicle");
$spots = $conn->query("SELECT * FROM ParkingSpot WHERE is_available=1");
?>

<h2>Create Ticket</h2>
<form method="POST">
    Vehicle: 
    <select name="vehicle_id" required>
        <?php while($v = $vehicles->fetch_assoc()): ?>
        <option value="<?= $v['vehicle_id'] ?>"><?= $v['plate_number'] ?> (<?= $v['vehicle_type'] ?>)</option>
        <?php endwhile; ?>
    </select>

    Spot: 
    <select name="spot_id" required>
        <?php while($s = $spots->fetch_assoc()): ?>
        <option value="<?= $s['spot_id'] ?>"><?= $s['spot_number'] ?> (<?= $s['spot_type'] ?>)</option>
        <?php endwhile; ?>
    </select>

    <button type="submit" name="create_ticket">Create Ticket</button>
</form>