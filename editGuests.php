<?php
require_once 'database.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $guest = getGuest($conn, $id);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($id)) {
    $firstname = $_POST['firstname'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $email = $_POST['email'] ?? '';
    $photo = $guest['photo'] ?? ''; 
    $document = $guest['document'] ?? ''; 

    if (!empty($_FILES['photo']['name'])) {
        $targetDir = "uploads/";
        $photo = basename($_FILES['photo']['name']);
        $targetFilePath = $targetDir . $photo;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowedImageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array(strtolower($fileType), $allowedImageTypes)) {
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFilePath)) {
                echo "<script>alert('Photo uploaded successfully.');</script>";
            } else {
                echo "<script>alert('Error uploading photo.');</script>";
            }
        } else {
            echo "<script>alert('Invalid image type. Only JPG, JPEG, PNG, GIF, WEBP files are allowed.');</script>";
        }
    }

    if (!empty($_FILES['document']['name'])) {
        $targetDir = "uploads/";
        $document = basename($_FILES['document']['name']);
        $targetFilePath = $targetDir . $document;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowedDocumentTypes = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'txt', 'xls', 'xlsx'];
        if (in_array(strtolower($fileType), $allowedDocumentTypes)) {
            if (move_uploaded_file($_FILES['document']['tmp_name'], $targetFilePath)) {
                echo "<script>alert('Document uploaded successfully.');</script>";
            } else {
                echo "<script>alert('Error uploading document.');</script>";
            }
        } else {
            echo "<script>alert('Invalid document type. Only PDF, DOC, DOCX, PPT, PPTX, TXT, XLS, XLSX files are allowed.');</script>";
        }
    }

    if (!empty($firstname) && !empty($lastname) && !empty($email)) {
        updateGuest($conn, $id, $firstname, $lastname, $email, $photo, $document); 
        header("Location: myGuests.php"); 
        exit();
    } else {
        echo "<script>alert('Please fill in all required fields.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Guest</title>
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

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-size: 16px;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="file"],
        button {
            padding: 12px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            width: 100%;
        }

        button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border: none;
        }

        button:hover {
            background-color: #0056b3;
        }

        input[type="file"] {
            padding: 10px;
        }

        a {
            text-decoration: none;
            color: #007bff;
            text-align: center;
            display: block;
            margin-top: 15px;
        }

        a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            font-size: 14px;
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

    <h1>Update Guest Information</h1>

    <div class="container">
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="firstname">First Name:</label>
                <input type="text" name="firstname" id="firstname" value="<?php echo htmlspecialchars($guest['firstname'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" name="lastname" id="lastname" value="<?php echo htmlspecialchars($guest['lastname'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($guest['email'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="photo">New Photo (Optional):</label>
                <input type="file" name="photo" accept=".jpg, .jpeg, .png, .gif, .webp">
            </div>

            <div class="form-group">
                <label for="document">New Document (Optional):</label>
                <input type="file" name="document" accept=".pdf, .doc, .docx, .ppt, .pptx, .txt, .xls, .xlsx">
            </div>

            <button type="submit">Update</button>
            <a href="myGuests.php">Cancel</a>
        </form>
    </div>
</body>

</html>
