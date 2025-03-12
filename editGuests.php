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
      /* Container Styles */
.container {
    width: 50%;
    margin: 20px auto;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Form Styles */
form {
    display: flex;
    flex-direction: column;
}

.form-group {
    margin-bottom: 15px;
}

label {
    font-weight: 600;
    color: #6a5acd;
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="email"],
input[type="file"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

button {
    background-color: #6a5acd;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #5a4db8;
}

a {
    display: inline-block;
    margin-top: 10px;
    text-decoration: none;
    color: #6a5acd;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
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

    <h1 style="text-align: center;">Update Guest Information</h1>

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
