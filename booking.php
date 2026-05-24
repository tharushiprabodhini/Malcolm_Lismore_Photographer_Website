<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo "405 - Method Not Allowed";
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "Wdd_website";

$conn = new mysqli($servername, $username, $password, $database);

// Check DB connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize & assign form inputs
$Full_name = isset($_POST['Full_name']) ? trim($_POST['Full_name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$locationa = isset($_POST['locationa']) ? trim($_POST['locationa']) : '';
$phone_number = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : '';
$photography_type = isset($_POST['photography_type']) ? trim($_POST['photography_type']) : '';
$photography_package = isset($_POST['photography_package']) ? trim($_POST['photography_package']) : '';
$additional_package = isset($_POST['additional_package']) ? trim($_POST['additional_package']) : '';
$additional_message = isset($_POST['additional_message']) ? trim($_POST['additional_message']) : '';
$status = "Pending";

// Validate required fields
if (
    empty($Full_name) || empty($email) || empty($locationa) ||
    empty($phone_number) || empty($photography_type) || empty($photography_package)
) {
    header("Location: booking page.html?error=1");
    exit;
}

// Prepare SQL statement
$sql = "INSERT INTO booking 
    (Full_name, email, locationa, phone_number, photography_type, photography_package, additional_package, additional_message, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    header("Location: booking page.html?error=1");
    exit;
}

// Bind parameters
$stmt->bind_param(
    "sssssssss",
    $Full_name,
    $email,
    $locationa,
    $phone_number,
    $photography_type,
    $photography_package,
    $additional_package,
    $additional_message,
    $status
);

// Execute
if ($stmt->execute()) {
    header("Location: booking page.html?success=1");
    exit;
} else {
    header("Location: booking page.html?error=1");
    exit;
}

// Clean up
$stmt->close();
$conn->close();
?>
