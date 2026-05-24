<?php
$conn = new mysqli("localhost", "root", "", "Wdd_website");
if ($conn->connect_error) {
  die("<p style='color:red;'>Connection failed: " . htmlspecialchars($conn->connect_error) . "</p>");
}

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_email'])) {
  $delete_email = $_POST['delete_email'];
  $stmt = $conn->prepare("DELETE FROM users WHERE email = ?");
  $stmt->bind_param("s", $delete_email);
  $stmt->execute();
  $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Records | Admin</title>
  <link rel="stylesheet" href="admin.css" />
</head>
<body>
  <nav class="admin-nav">
    <ul>
      <li><a href="dashboard.html">Dashboard</a></li>
      <li><a href="booking.php">Bookings</a></li>
      <li><a href="contact.php">Contacts</a></li>
      <li><a href="users.php" class="active">Users</a></li>
      <li><a href="login.html" class="logout-btn">Logout</a></li>
    </ul>
  </nav>

  <main class="admin-content">
    <h2>Registered Users</h2>

    <?php
    $sql = "SELECT name, email, created_at FROM users ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
      echo "<table>
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Registered On</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>";
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . date("Y-m-d H:i", strtotime($row['created_at'])) . "</td>
                <td>
                  <form method='POST' class='delete-form' onsubmit='return confirm(\"Are you sure you want to delete this user?\");'>
                    <input type='hidden' name='delete_email' value='" . htmlspecialchars($row['email']) . "' />
                    <button type='submit' class='delete-btn'>Delete</button>
                  </form>
                </td>
              </tr>";
      }
      echo "</tbody></table>";
    } else {
      echo "<p>No users found.</p>";
    }

    $conn->close();
    ?>
  </main>

  <footer class="admin-footer">
    <p>&copy; 2025 Malcolm Lismore Photography | Admin Panel</p>
  </footer>
</body>
</html>
