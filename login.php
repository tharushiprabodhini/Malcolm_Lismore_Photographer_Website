<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo "Method Not Allowed";
    exit;
}

// Database config
$servername = "localhost";
$username = "root";
$password = "";
$database = "Wdd_website";

// Connect to DB
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get and sanitize input
$email = trim($_POST['email']);
$password = trim($_POST['password']);

if (empty($email) || empty($password)) {
    header("Location: login.html?msg=error");
    exit;
}

// Fetch user from DB
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verify password hash
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_email'] = $email;
        header("Location: booking page.html");
        exit;
    }
}

// If invalid
header("Location: login.html?msg=error");
exit;

$stmt->close();
$conn->close();
?>
