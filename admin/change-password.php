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

    if ($row && password_verify($current, $row['password'])) {
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
  <title>Change Password | Shaheed RNS Education Academy</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 min-h-screen flex items-center justify-center">

  <!-- Background -->
  <div class="absolute inset-0">
    <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1600&q=80"
         class="w-full h-full object-cover opacity-20">
  </div>

  <!-- Card -->
  <div class="relative z-10 w-full max-w-md bg-gray-800 rounded-2xl shadow-2xl p-8 border border-gray-700">

    <!-- Logo & Title -->
    <div class="text-center mb-6">
      <img src="../assets/logo.jpeg" class="w-20 h-20 rounded-full mx-auto border-2 border-white">
      <h1 class="text-2xl font-bold text-white mt-4">Change Password</h1>
      <p class="text-gray-400 text-sm">Shaheed RNS Education Academy</p>
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

      <!-- Current Password -->
      <div>
        <label class="block text-sm text-green-400 mb-1">Current Password</label>
        <div class="relative">
          <input type="password" name="current" id="current"
                 class="w-full px-4 py-3 pr-12 rounded-lg bg-gray-900 border border-gray-700 text-white
                        focus:outline-none focus:ring-2 focus:ring-yellow-500"
                 required>
          <i class="fas fa-eye absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 cursor-pointer"
             onclick="togglePassword('current', this)"></i>
        </div>
      </div>

      <!-- New Password -->
      <div>
        <label class="block text-sm text-green-400 mb-1">New Password</label>
        <div class="relative">
          <input type="password" name="new" id="new"
                 class="w-full px-4 py-3 pr-12 rounded-lg bg-gray-900 border border-gray-700 text-white
                        focus:outline-none focus:ring-2 focus:ring-yellow-500"
                 required>
          <i class="fas fa-eye absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 cursor-pointer"
             onclick="togglePassword('new', this)"></i>
        </div>
      </div>

      <!-- Confirm Password -->
      <div>
        <label class="block text-sm text-green-400 mb-1">Confirm New Password</label>
        <div class="relative">
          <input type="password" name="confirm" id="confirm"
                 class="w-full px-4 py-3 pr-12 rounded-lg bg-gray-900 border border-gray-700 text-white
                        focus:outline-none focus:ring-2 focus:ring-yellow-500"
                 required>
          <i class="fas fa-eye absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 cursor-pointer"
             onclick="togglePassword('confirm', this)"></i>
        </div>
      </div>

      <!-- Button -->
      <button
        type="submit"
        name="change"
        class="w-full bg-yellow-500 hover:bg-green-600 text-black font-semibold
               py-3 rounded-full transition-all duration-300
               shadow-lg hover:scale-[1.02]">
        Update Password
      </button>
    

    </form>
   <!-- Back -->
  <div class="text-center mt-6">
    <a href="upload.php" class="text-sm text-gray-400 hover:text-yellow-400">
      ← Back to Dashboard
    </a>
  </div>
    <!-- Footer -->
    <p class="text-center text-gray-500 text-xs mt-6">
      © <?= date('Y') ?> Shaheed RNS Education Academy
    </p>

  </div>

  <!-- JS: Toggle Password -->
  <script>
    function togglePassword(id, icon) {
      const input = document.getElementById(id);
      if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    }
  </script>

</body>
</html>
