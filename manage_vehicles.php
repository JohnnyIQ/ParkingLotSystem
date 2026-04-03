<?php
include(__DIR__ . '/includes/db.php');

// Handle Add Vehicle
if(isset($_POST['add_vehicle'])){
    $plate_number = $_POST['plate_number'];
    $vehicle_type = $_POST['vehicle_type'];

    $stmt = $conn->prepare("INSERT INTO Vehicle (plate_number, vehicle_type) VALUES (?, ?)");
    $stmt->bind_param("ss", $plate_number, $vehicle_type);
    $stmt->execute();
    header("Location: manage_vehicles.php");
    exit;
}

// Handle Delete Vehicle
if(isset($_GET['delete'])){
    $vehicle_id = (int)$_GET['delete'];
    $conn->query("DELETE FROM Vehicle WHERE vehicle_id=$vehicle_id");
    header("Location: manage_vehicles.php");
    exit;
}

// Fetch Vehicles
$vehicles = $conn->query("SELECT * FROM Vehicle");
?>

<h1>Manage Vehicles</h1>

<h2>Add Vehicle</h2>
<form method="POST">
    Plate Number: <input type="text" name="plate_number" required>
    Vehicle Type: 
    <select name="vehicle_type" required>
        <option value="Car">Car</option>
        <option value="Truck">Truck</option>
        <option value="Motorcycle">Motorcycle</option>
    </select>
    <button type="submit" name="add_vehicle">Add Vehicle</button>
</form>

<h2>Existing Vehicles</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Plate Number</th>
        <th>Type</th>
        <th>Action</th>
    </tr>
    <?php while($row = $vehicles->fetch_assoc()): ?>
    <tr>
        <td><?= $row['vehicle_id'] ?></td>
        <td><?= $row['plate_number'] ?></td>
        <td><?= $row['vehicle_type'] ?></td>
        <td>
            <a href="manage_vehicles.php?delete=<?= $row['vehicle_id'] ?>" onclick="return confirm('Delete this vehicle?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>