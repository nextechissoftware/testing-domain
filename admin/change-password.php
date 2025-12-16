<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}

if (isset($_POST['change'])) {
  $current = $_POST['current'];
  $new = $_POST['new'];
  $confirm = $_POST['confirm'];

  if ($new !== $confirm) {
    $error = "New passwords do not match";
  } else {
    $id = $_SESSION['admin_id'];
    $q = mysqli_query($conn, "SELECT password FROM admins WHERE id=$id");
    $row = mysqli_fetch_assoc($q);

    if (password_verify($current, $row['password'])) {
      $hash = password_hash($new, PASSWORD_DEFAULT);
      mysqli_query($conn, "UPDATE admins SET password='$hash' WHERE id=$id");
      $success = "Password updated successfully";
    } else {
      $error = "Current password incorrect";
    }
  }
}
?>

<form method="post">
  <input type="password" name="current" placeholder="Current Password" required>
  <input type="password" name="new" placeholder="New Password" required>
  <input type="password" name="confirm" placeholder="Confirm New Password" required>
  <button name="change">Change Password</button>
</form>

<?= isset($error) ? $error : "" ?>
<?= isset($success) ? $success : "" ?>
