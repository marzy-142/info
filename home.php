<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - My Hotel</title>
    <style>
     body {
    font-family: 'Arial', sans-serif;
    background-color: #eaeaea;
    margin: 0;
    padding: 0;
    color: #444;
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #4caf50; /* Changed color */
    padding: 15px 30px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.navbar .logo {
    font-size: 32px;
    font-weight: bold;
    color: #fff;
    letter-spacing: 2px; /* Added letter-spacing */
}

.navbar .menu {
    display: flex;
    gap: 30px; /* Increased gap */
}

.navbar .menu a {
    color: #fff;
    text-decoration: none;
    font-size: 18px; /* Increased font size */
    padding: 10px 20px;
    border-radius: 25px; /* Changed border-radius */
    transition: background 0.3s, transform 0.2s; /* Added transform */
}

.navbar .menu a:hover {
    background: rgba(255, 255, 255, 0.4);
    transform: scale(1.1); /* Added scaling effect on hover */
}

.hero {
    background-image: url('https://images.unsplash.com/photo-1603791442286-2e8cd0b8ff4b'); /* Changed image */
    background-size: cover;
    background-position: center;
    height: 70vh; /* Increased height */
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.6); /* Enhanced text-shadow */
    padding: 0 30px;
    text-align: center;
}

.hero h1 {
    font-size: 58px; /* Increased font size */
    margin: 0;
    font-weight: 700; /* Increased font weight */
}

.hero p {
    font-size: 24px; /* Increased font size */
}

.actions {
    margin-top: 40px;
}

.actions a {
    text-decoration: none;
    color: white;
    background-color: #4caf50;
    padding: 12px 30px;
    border-radius: 8px;
    margin: 12px;
    transition: background 0.3s, transform 0.2s;
    display: inline-block;
}

.actions a:hover {
    background-color: #45a049;
    transform: translateY(-3px); /* Added subtle lift effect on hover */
}

.content {
    padding: 60px 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.content h2 {
    color: #4caf50; /* Changed color */
    margin-bottom: 30px;
    font-size: 32px; /* Increased font size */
    font-weight: 600;
}

.footer {
    background-color: #222; /* Darkened footer */
    color: #ddd; /* Lighter text */
    padding: 20px 0;
    text-align: center;
    margin-top: 40px;
    font-size: 14px;
}

.footer a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
}

.footer a:hover {
    color: #4caf50;
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

    <div class="hero">
        <div>
            <h1>Welcome to My Hotel</h1>
            <p>Manage your guests with ease and style.</p>
        </div>
    </div>

    <div class="content">
        <h2>Get Started</h2>
        <div class="actions">
            <a href="addGuests.php">Add New Guest</a>
            <a href="myGuests.php">View Guests List</a>
        </div>
    </div>

    <div class="footer">
        &copy; <?php echo date("Y"); ?> My Hotel. All rights reserved.
    </div>
</body>
</html>