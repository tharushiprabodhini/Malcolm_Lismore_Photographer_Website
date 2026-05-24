<?php
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

// Connect
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get and sanitize inputs
$name = trim($_POST["name"]);
$email = trim($_POST["email"]);
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

// Validation
if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
    header("Location: register.html?msg=empty");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: register.html?msg=invalidemail");
    exit;
}

if ($password !== $confirm_password) {
    header("Location: register.html?msg=passwordmismatch");
    exit;
}

// Check if user exists
$check = $conn->prepare("SELECT * FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    header("Location: register.html?msg=exists");
    exit;
}
$check->close();

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user
$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $hashed_password);

if ($stmt->execute()) {
    header("Location: login.html?msg=registered");
} else {
    header("Location: register.html?msg=error");
}

$stmt->close();
$conn->close();
?>
