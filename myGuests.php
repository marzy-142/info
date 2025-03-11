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
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            color: #333;
        }
        
        .navbar {
            background-color: #007bff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .logo {
            font-size: 26px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .menu a {
            color: white;
            margin: 0 20px;
            text-decoration: none;
            font-size: 18px;
            text-transform: capitalize;
            transition: color 0.3s ease;
        }
        
        .menu a:hover {
            color: #ffc107;
        }
        
        h1 {
            text-align: center;
            margin-top: 40px;
            color: #007bff;
            font-size: 36px;
        }

        .table-container {
            max-width: 90%;
            margin: 30px auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #f1f1f1;
        }

        table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        .actions a {
            color: #28a745;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            background-color: #d4edda;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .actions a:hover {
            background-color: #218838;
            color: white;
        }

        .delete-link {
            color: #dc3545;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            background-color: #f8d7da;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .delete-link:hover {
            background-color: #c82333;
            color: white;
        }

        .rounded-circle {
            border-radius: 50%;
        }

        .table-responsive {
            max-width: 100%;
            overflow-x: auto;
        }

        .no-data {
            text-align: center;
            color: #777;
            font-size: 18px;
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

    <h1>Guest List</h1>

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
