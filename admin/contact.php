<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "Wdd_website");
if ($conn->connect_error) {
  die("<p style='color:red;'>Connection failed: " . htmlspecialchars($conn->connect_error) . "</p>");
}

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_email'], $_POST['delete_subject'])) {
  $stmt = $conn->prepare("DELETE FROM contact WHERE email = ? AND subject = ?");
  $stmt->bind_param("ss", $_POST['delete_email'], $_POST['delete_subject']);
  $stmt->execute();
  $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Messages | Admin</title>
  <link rel="stylesheet" href="admin.css" />
</head>
<body>
  <nav class="admin-nav">
    <ul>
      <li><a href="dashboard.html">Dashboard</a></li>
      <li><a href="booking.php">Bookings</a></li>
      <li><a href="contact.php" class="active">Contacts</a></li>
      <li><a href="users.php">Users</a></li>
      <li><a href="login.html" class="logout-btn">Logout</a></li>
    </ul>
  </nav>

  <main class="admin-content">
    <h2>Contact Messages</h2>

    <?php
    $sql = "SELECT name, email, subject, message FROM contact ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
      echo "<table>
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Subject</th>
                  <th>Message</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>";
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['subject']) . "</td>
                <td>" . nl2br(htmlspecialchars($row['message'])) . "</td>
                <td>
                  <form method='POST' class='delete-form' onsubmit='return confirm(\"Delete this message?\");'>
                    <input type='hidden' name='delete_email' value='" . htmlspecialchars($row['email']) . "'>
                    <input type='hidden' name='delete_subject' value='" . htmlspecialchars($row['subject']) . "'>
                    <button type='submit' class='delete-btn'>Delete</button>
                  </form>
                </td>
              </tr>";
      }
      echo "</tbody></table>";
    } else {
      echo "<p>No contact messages found.</p>";
    }

    $conn->close();
    ?>
  </main>

  <footer class="admin-footer">
    <p>&copy; 2025 Malcolm Lismore Photography | Admin Panel</p>
  </footer>
</body>
</html>
