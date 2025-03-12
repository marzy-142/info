<?php
require_once 'database.php';

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    deleteGuest($conn, $id);
    header("Location: myGuests.php");
    exit();
}

$dataResult = fetchGuests($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest List</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;600&display=swap');
       /* General Styles */
body {
    font-family: 'Quicksand', sans-serif; /* A modern and clean font */
    background-color: #f8f1ff; /* Light powdery background */
    margin: 0;
    padding-top: 70px; /* Prevents content from hiding behind navbar */
}

/* Navbar Styles */
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

.navbar button:hover {
    background-color: #c5a6e3;
}

/* Guest List Styles */
.table-container {
    max-width: 900px;
    margin: 40px auto;
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #e9d7ff;
    color: #5c3c92;
    font-weight: bold;
}

td {
    border-bottom: 1px solid #ddd;
}

/* Buttons */
button.edit, button.delete {
    border: none;
    padding: 8px 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

button.edit {
    background-color: #b28dff;
    color: white;
}

button.delete {
    background-color: #ff9aa2;
    color: white;
}

button.edit:hover {
    background-color: #9a74e8;
}

button.delete:hover {
    background-color: #ff7b8b;
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

    <h1 style="text-align: center;">Guest List</h1>

    <div class="table-container">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Photo</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Registration Date</th>
                        <th>Document</th> 
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($dataResult && $dataResult->num_rows > 0) {
                        while ($row = $dataResult->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['id']}</td>
                                <td>";
                            if (!empty($row['photo'])) {
                                echo "<img src='uploads/" . $row['photo'] . "' width='50' height='50' class='rounded-circle'>";
                            } else {
                                echo "No Photo";
                            }
                            echo "</td>
                                <td>{$row['firstname']}</td>
                                <td>{$row['lastname']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['reg_date']}</td>
                                <td>";

                            if (!empty($row['document'])) {
                                echo "<a href='uploads/" . $row['document'] . "' target='_blank'><i class='bi bi-file-earmark-arrow-down-fill'></i> Download</a>";
                            } else {
                                echo "No Document";
                            }
                            echo "</td>
                                <td class='actions'>
                                    <a href='editGuests.php?id={$row['id']}'>Edit</a> | 
                                    <a href='?delete={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this guest?\")' class='delete-link'>Delete</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='no-data'>No guests found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
