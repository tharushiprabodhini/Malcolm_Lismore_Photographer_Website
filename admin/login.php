<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo "Method Not Allowed";
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "Wdd_website";

// Connect to DB
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = trim($_POST['email']);
$pwd = trim($_POST['password']);

// Basic validation
if (empty($email) || empty($pwd)) {
    header("Location: login.html?msg=error");
    exit;
}

// Query admin table
$sql = "SELECT * FROM admins WHERE email = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $pwd);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $_SESSION['admin_email'] = $email;
    header("Location: dashboard.html"); // Or your admin dashboard page
} else {
    header("Location: login.html?msg=error");
}

$stmt->close();
$conn->close();
?>
