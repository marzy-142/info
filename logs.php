<?php
require 'database.php'; // Include the database connection file

$logs = fetchLogs($conn);
if (!$logs) {
    die("Error fetching logs: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Logs</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }

        .navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background-color: #d2b8f2; /* Powdery lavender */
    padding: 15px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

/* Navbar Buttons */
.navbar button {
    background-color: #e9d7ff; /* Soft button color */
    border: none;
    padding: 8px 15px;
    border-radius: 20px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s ease;
}
    </style>
</head>
<body>
<div class="navbar">
        <div class="logo">My Hotel</div>
        <div class="menu">
            <a href="home.php">Home</a>
            <a href="addGuests.php">Add Guest</a>
            <a href="myGuests.php">Guests List</a>
        </div>
    </div>
    <h2>Error Logs</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Error Message</th>
            <th>Error Time</th>
        </tr>
        <?php if ($logs->num_rows > 0): ?>
            <?php while ($row = $logs->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['error_message']); ?></td>
                    <td><?php echo htmlspecialchars($row['error_time']); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No logs available</td>
            </tr>
        <?php endif; ?>
    </table>

    <?php $conn->close(); ?> <!-- Closing the database connection -->
</body>
</html>
