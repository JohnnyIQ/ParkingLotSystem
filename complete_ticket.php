<?php
include(__DIR__ . '/includes/db.php');

if(isset($_POST['complete_ticket'])){
    $ticket_id = (int)$_POST['ticket_id'];
    $amount = (float)$_POST['amount'];
    $method = $_POST['payment_method'];

    // Update Ticket status and EntryLog exit_time, free parking spot
    $conn->query("UPDATE Ticket t
        JOIN EntryLog el ON t.log_id = el.log_id
        JOIN ParkingSpot ps ON el.spot_id = ps.spot_id
        SET t.status='PAID', ps.is_available=1, el.exit_time=NOW()
        WHERE t.ticket_id=$ticket_id");

    // Insert Payment
    $conn->query("INSERT INTO Payment (ticket_id, amount, payment_method) VALUES ($ticket_id, $amount, '$method')");

    header("Location: index.php");
    exit;
}

// Fetch unpaid tickets
$tickets = $conn->query("
    SELECT t.ticket_id, v.plate_number
    FROM Ticket t
    JOIN EntryLog el ON t.log_id = el.log_id
    JOIN Vehicle v ON el.vehicle_id = v.vehicle_id
    WHERE t.status != 'PAID'
");
?>

<h2>Complete Ticket / Payment</h2>
<form method="POST">
    Ticket:
    <select name="ticket_id" required>
        <?php while($t = $tickets->fetch_assoc()): ?>
        <option value="<?= $t['ticket_id'] ?>"><?= $t['ticket_id'] ?> - <?= $t['plate_number'] ?></option>
        <?php endwhile; ?>
    </select>

    Amount: <input type="number" step="0.01" name="amount" required>
    Payment Method: 
    <select name="payment_method" required>
        <option value="Cash">Cash</option>
        <option value="Credit Card">Credit Card</option>
        <option value="Mobile Payment">Mobile Payment</option>
    </select>

    <button type="submit" name="complete_ticket">Complete Ticket</button>
</form>