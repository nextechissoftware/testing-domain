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

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Change Password | Admin Panel</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black min-h-screen flex items-center justify-center text-white">

<div class="w-full max-w-md bg-gray-800/80 backdrop-blur rounded-2xl shadow-2xl border border-gray-700 p-8">

  <!-- Header -->
  <div class="text-center mb-6">
    <img src="../assets/logo.jpeg"
         class="w-20 h-20 mx-auto rounded-full border-2 border-yellow-400">
    <h1 class="text-2xl font-bold text-yellow-400 mt-4">
      Shaheed RNS Education Academy
    </h1>
    <p class="text-sm text-gray-400">Change Admin Password</p>
  </div>

  <!-- Messages -->
  <?php if (isset($error)) : ?>
    <div class="bg-red-500/20 border border-red-500 text-red-400 px-4 py-2 rounded mb-4 text-center">
      <?= $error ?>
    </div>
  <?php endif; ?>

  <?php if (isset($success)) : ?>
    <div class="bg-green-500/20 border border-green-500 text-green-400 px-4 py-2 rounded mb-4 text-center">
      <?= $success ?>
    </div>
  <?php endif; ?>

  <!-- Form -->
  <form method="post" class="space-y-5">

    <div>
      <label class="block text-sm text-gray-300 mb-1">Current Password</label>
      <input
        type="password"
        name="current"
        required
        placeholder="Enter current password"
        class="w-full px-4 py-3 rounded-lg bg-gray-900 border border-gray-700
               focus:outline-none focus:ring-2 focus:ring-yellow-500">
    </div>

    <div>
      <label class="block text-sm text-gray-300 mb-1">New Password</label>
      <input
        type="password"
        name="new"
        required
        placeholder="Enter new password"
        class="w-full px-4 py-3 rounded-lg bg-gray-900 border border-gray-700
               focus:outline-none focus:ring-2 focus:ring-yellow-500">
    </div>

    <div>
      <label class="block text-sm text-gray-300 mb-1">Confirm New Password</label>
      <input
        type="password"
        name="confirm"
        required
        placeholder="Confirm new password"
        class="w-full px-4 py-3 rounded-lg bg-gray-900 border border-gray-700
               focus:outline-none focus:ring-2 focus:ring-yellow-500">
    </div>

    <button
      type="submit"
      name="change"
      class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-semibold
             py-3 rounded-full transition shadow-lg">
      Update Password
    </button>

  </form>

  <!-- Back -->
  <div class="text-center mt-6">
    <a href="upload.php" class="text-sm text-gray-400 hover:text-yellow-400">
      ← Back to Dashboard
    </a>
  </div>

</div>

</body>
</html>
