<?php
include(__DIR__ . '/includes/db.php');

// Handle Add Spot
if(isset($_POST['add_spot'])){
    $spot_number = $_POST['spot_number'];
    $spot_type = $_POST['spot_type'];
    $is_available = isset($_POST['is_available']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO ParkingSpot (spot_number, spot_type, is_available) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $spot_number, $spot_type, $is_available);
    $stmt->execute();
    header("Location: manage_spots.php");
    exit;
}

// Handle Delete Spot
if(isset($_GET['delete'])){
    $spot_id = (int)$_GET['delete'];
    $conn->query("DELETE FROM ParkingSpot WHERE spot_id=$spot_id");
    header("Location: manage_spots.php");
    exit;
}

// Fetch Spots
$spots = $conn->query("SELECT * FROM ParkingSpot");
?>

<h1>Manage Parking Spots</h1>

<h2>Add Spot</h2>
<form method="POST">
    Spot Number: <input type="text" name="spot_number" required>
    Spot Type: 
    <select name="spot_type" required>
        <option value="Car">Car</option>
        <option value="Truck">Truck</option>
        <option value="Motorcycle">Motorcycle</option>
    </select>
    Available: <input type="checkbox" name="is_available" checked>
    <button type="submit" name="add_spot">Add Spot</button>
</form>

<h2>Existing Spots</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Spot Number</th>
        <th>Type</th>
        <th>Available</th>
        <th>Action</th>
    </tr>
    <?php while($row = $spots->fetch_assoc()): ?>
    <tr>
        <td><?= $row['spot_id'] ?></td>
        <td><?= $row['spot_number'] ?></td>
        <td><?= $row['spot_type'] ?></td>
        <td><?= $row['is_available'] ? 'Yes' : 'No' ?></td>
        <td>
            <a href="manage_spots.php?delete=<?= $row['spot_id'] ?>" onclick="return confirm('Delete this spot?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>