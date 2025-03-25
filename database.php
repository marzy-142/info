<?php

$db_server = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "im_semi";

// Create connection
$conn = new mysqli($db_server, $db_user, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    logError($conn, "Connection failed: " . $conn->connect_error);
    die("Connection failed. Check log for details.");
}

// Create tables
$tableSql = "CREATE TABLE IF NOT EXISTS MyGuests (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50),
    document VARCHAR(500),
    photo VARCHAR(500),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

$logTableSql = "CREATE TABLE IF NOT EXISTS ErrorLogs (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    error_message TEXT NOT NULL,
    error_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Create MyGuests table
if (!$conn->query($tableSql)) {
    logError($conn, "Error creating MyGuests table: " . $conn->error);
    die("MyGuests table creation failed. Check logs for details.");
}

// Create ErrorLogs table
if (!$conn->query($logTableSql)) {
    logError($conn, "Error creating ErrorLogs table: " . $conn->error);
    die("ErrorLogs table creation failed. Check logs for details.");
}

// Log error function
function logError($conn, $message) {
    $stmt = $conn->prepare("INSERT INTO ErrorLogs (error_message) VALUES (?)");
    if ($stmt) {
        $stmt->bind_param("s", $message);
        $stmt->execute();
    }
}

// Check and insert sample data if table is empty
$checkData = "SELECT COUNT(*) AS total FROM MyGuests";
$result = $conn->query($checkData);
$row = $result->fetch_assoc();

if ($row['total'] == 0) {
    $insertSql = "INSERT INTO MyGuests (firstname, lastname, email) VALUES
    ('John', 'Bacalla', 'john@gmail.com'),
    ('Joana Jean', 'Astacaan', 'joana@gmail.com'),
    ('Roger', 'Asombrado', 'roger@gmail.com')";

    if (!$conn->query($insertSql)) {
        logError($conn, "Error inserting initial data: " . $conn->error);
        die("Error inserting data. Check logs for details.");
    }
}

// Fetch guests
function fetchGuests($conn): mixed {
    $sql = "SELECT id, firstname, lastname, email, reg_date, photo, document FROM MyGuests ORDER BY id ASC";
    $result = $conn->query($sql);

    if (!$result) {
        logError($conn, "Error fetching data: " . $conn->error);
        die("Error fetching data.");
    }
    return $result;
}

// Add guest
function addGuest($conn, $firstname, $lastname, $email, $photo, $document) {
    $stmt = $conn->prepare("INSERT INTO MyGuests(firstname, lastname, email, photo, document) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        logError($conn, "Prepare failed in addGuest: " . $conn->error);
        return false;
    }

    $stmt->bind_param("sssss", $firstname, $lastname, $email, $photo, $document);

    if (!$stmt->execute()) {
        logError($conn, "Execute failed in addGuest: " . $stmt->error);
        return false;
    }
    return true;
}

// Get single guest
function getGuest($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM MyGuests WHERE id = ?");
    if (!$stmt) {
        logError($conn, "Prepare failed in getGuest: " . $conn->error);
        return false;
    }

    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        logError($conn, "Execute failed in getGuest: " . $stmt->error);
        return false;
    }

    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Delete guest
function deleteGuest($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM MyGuests WHERE id = ?");
    if (!$stmt) {
        logError($conn, "Prepare failed in deleteGuest: " . $conn->error);
        return false;
    }

    // $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        logError($conn, "Execute failed in deleteGuest: " . $stmt->error);
        return false;
    }
    return true;
}

// Update guest
function updateGuest($conn, $id, $firstname, $lastname, $email, $photo, $document) {
    $stmt = $conn->prepare("UPDATE MyGuests SET firstname = ?, lastname = ?, email = ?, photo = ?, document = ? WHERE id = ?");
    if (!$stmt) {
        logError($conn, "Prepare failed in updateGuest: " . $conn->error);
        return false;
    }

    $stmt->bind_param("sssssi", $firstname, $lastname, $email, $photo, $document, $id);
    if (!$stmt->execute()) {
        logError($conn, "Execute failed in updateGuest: " . $stmt->error);
        return false;
    }
    return true;
}

function fetchLogs($conn) {
    $sql = "SELECT * FROM ErrorLogs ORDER BY error_time DESC";
    return $conn->query($sql);

}

logError($conn, "Message");

?>
