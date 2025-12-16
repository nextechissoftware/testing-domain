<?php
session_start();
include "../config/db.php";

if (isset($_POST['login'])) {
  $user = $_POST['user'];
  $pass = $_POST['pass'];

  $q = mysqli_query($conn, "SELECT * FROM admins WHERE username='$user'");
  $admin = mysqli_fetch_assoc($q);

  if ($admin && password_verify($pass, $admin['password'])) {
    $_SESSION['admin_id'] = $admin['id'];
    header("Location: upload.php");
    exit;
  } else {
    $error = "Invalid username or password";
  }
}
?>

<form method="post">
  <input name="user" placeholder="Username" required>
  <input type="password" name="pass" placeholder="Password" required>
  <button name="login">Login</button>
  <?= isset($error) ? $error : "" ?>
</form>
