<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Registered Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 800px;
            text-align: center;
        }
        .container h2 {
            margin-bottom: 20px;
        }
        .user-info {
            text-align: left;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if (isset($_SESSION['username'])) {
            $current_username = $_SESSION['username'];

            // Check if the current user is the first registered user
            $sql = "SELECT username FROM users ORDER BY id ASC LIMIT 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($current_username == $row['username']) {
                    $sql = "SELECT username, email, first_name, last_name FROM users";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<h2>Registered Users</h2>";
                        while($row = $result->fetch_assoc()) {
                            echo "<div class='user-info'>";
                            echo "<strong>Username:</strong> " . $row['username'] . "<br>";
                            echo "<strong>Email:</strong> " . $row['email'] . "<br>";
                            echo "<strong>Name:</strong> " . $row['first_name'] . " " . $row['last_name'] . "<br>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No registered users found.</p>";
                    }
                } else {
                    echo "<p>Access denied.</p>";
                }
            }
        }
        ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
