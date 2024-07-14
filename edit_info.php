<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    $sql = "UPDATE users SET 
            password = IF('$password' != '', '$password', password),
            email = IF('$email' != '', '$email', email),
            first_name = IF('$first_name' != '', '$first_name', first_name),
            last_name = IF('$last_name' != '', '$last_name', last_name)
            WHERE username = '$username'";

    if ($conn->query($sql) === TRUE) {
        echo "Information updated successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
