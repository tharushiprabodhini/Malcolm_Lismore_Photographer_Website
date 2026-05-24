<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo "Method Not Allowed";
    exit;
}

// DB config
$servername = "localhost";
$username = "root";
$password = "";
$database = "Wdd_website";

// Connect
$conn = new mysqli($servername, $username, $password, $database);

// Connection check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validate
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    echo "<script>alert('Please fill all required fields.'); window.history.back();</script>";
    exit;
}

// Insert
$sql = "INSERT INTO contact (name, email, subject, message) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $subject, $message);

if ($stmt->execute()) {
    header("Location: contact page.html?msg=success");
    exit;
} else {
    header("Location: contact page.html?msg=error");
    exit;
}

// Cleanup
$stmt->close();
$conn->close();
?>
