<?php

$db_server = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "im_semi";

$conn = new mysqli(hostname: $db_server, username: $db_user, password: $db_password, database: $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tableSql = "CREATE TABLE IF NOT EXISTS MyGuests (
    id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50),
    document VARCHAR(500),
    photo VARCHAR(500),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";

if ($conn->query(query: $tableSql) === TRUE) {
} else {
    die("Error creating table: " . $conn->error);
}

$checkData = "SELECT COUNT(*) AS total FROM MyGuests";
$result = $conn->query(query: $checkData);
$row = $result->fetch_assoc();

if ($row['total'] == 0) {
    $insertSql = "INSERT INTO MyGuests (firstname, lastname, email) VALUES
    ('John', 'Bacalla', 'john@gmail.com'),
    ('Joana Jean', 'Astacaan', 'joana@gmail.com'),
    ('Roger', 'Asombrado', 'roger@gmail.com')";

    if ($conn->query(query: $insertSql) === TRUE) {
    } else {
        die("Error inserting data: " . $conn->error);
    }
}

function fetchGuests($conn): mixed {
    $sql = "SELECT id, firstname, lastname, email, reg_date, photo, document FROM MyGuests ORDER BY id ASC";
    return $conn->query($sql);
}

function addGuest($conn, $firstname, $lastname, $email, $photo, $document) {
    $stmt = $conn->prepare("INSERT INTO MyGuests(firstname, lastname, email, photo, document) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstname, $lastname, $email, $photo, $document);
    return $stmt->execute();
}

function getGuest($conn, $id) {
    $stmt = $conn->prepare(" SELECT * FROM MyGuests WHERE id= ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();

} 

function deleteGuest($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM MyGuests WHERE id=?");
    $stmt->bind_param("i", $id);

    return $stmt->execute();
}

function updateGuest($conn, $id, $firstname, $lastname, $email, $photo, $document) {
    $stmt = $conn->prepare("UPDATE MyGuests SET firstname = ?, lastname= ?, email= ?, photo=?, document=? WHERE id=?");
    $stmt->bind_param("sssssi", $firstname, $lastname, $email, $photo, $document, $id);

    return $stmt->execute();
}

?>