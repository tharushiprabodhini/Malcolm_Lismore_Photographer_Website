<?php
$conn = new mysqli("localhost", "root", "", "Wdd_website");
if ($conn->connect_error) {
  die("Connection failed: " . htmlspecialchars($conn->connect_error));
}

// Handle status update
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'], $_POST['status'])) {
  $id = intval($_POST['id']);
  $status = $_POST['status'];

  if (in_array($status, ['Accepted', 'Rejected'])) {
    $stmt = $conn->prepare("UPDATE booking SET status = ? WHERE booking_id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    $stmt->close();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bookings | Admin Panel</title>
  <link rel="stylesheet" href="admin.css" />
  <style>
    .status-actions form {
      display: inline;
    }
    .status-actions button {
      margin: 4px 4px 0 0;
      padding: 6px 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
    }
    .accept-btn {
      background-color: #28a745;
      color: white;
    }
    .reject-btn {
      background-color: #dc3545;
      color: white;
    }
  </style>
</head>
<body>
  <nav class="admin-nav">
    <ul>
      <li><a href="dashboard.html">Dashboard</a></li>
      <li><a href="booking.php" class="active">Bookings</a></li>
      <li><a href="contact.php">Contacts</a></li>
      <li><a href="users.php">Users</a></li>
      <li><a href="login.html" class="logout-btn">Logout</a></li>
    </ul>
  </nav>

  <main class="admin-content">
    <h2>Booking Records</h2>

    <?php
    $sql = "SELECT booking_id, Full_name, email, locationa, phone_number, photography_type, photography_package, additional_package, additional_message, status 
            FROM booking 
            ORDER BY booking_id DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
      echo "<table>
              <thead>
                <tr>
                  <th>Full Name</th>
                  <th>Email</th>
                  <th>Location</th>
                  <th>Phone</th>
                  <th>Type</th>
                  <th>Package</th>
                  <th>Additional Package</th>
                  <th>Additional Message</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>";
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['Full_name']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['locationa']) . "</td>
                <td>" . htmlspecialchars($row['phone_number']) . "</td>
                <td>" . htmlspecialchars($row['photography_type']) . "</td>
                <td>" . htmlspecialchars($row['photography_package']) . "</td>
                <td>" . htmlspecialchars($row['additional_package']) . "</td>
                <td>" . nl2br(htmlspecialchars($row['additional_message'])) . "</td>
                <td class='status-actions'>
                  <strong>" . htmlspecialchars($row['status']) . "</strong><br>
                  <form method='POST'>
                    <input type='hidden' name='id' value='" . $row['booking_id'] . "'>
                    <input type='hidden' name='status' value='Accepted'>
                    <button class='accept-btn' type='submit'>Accept</button>
                  </form>
                  <form method='POST'>
                    <input type='hidden' name='id' value='" . $row['booking_id'] . "'>
                    <input type='hidden' name='status' value='Rejected'>
                    <button class='reject-btn' type='submit'>Reject</button>
                  </form>
                </td>
              </tr>";
      }
      echo "</tbody></table>";
    } else {
      echo "<p>No booking records found.</p>";
    }

    $conn->close();
    ?>
  </main>

  <footer class="admin-footer">
    <p>&copy; 2025 Malcolm Lismore Photography | Admin Panel</p>
  </footer>
</body>
</html>
