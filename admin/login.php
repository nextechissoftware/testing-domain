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
    header("Location: dashboard");
    exit;
  } else {
    $error = "Invalid username or password";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login | Shaheed RNS Education Academy</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 min-h-screen flex items-center justify-center">

  <!-- Background -->
  <div class="absolute inset-0">
    <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1600&q=80"
         class="w-full h-full object-cover opacity-20">
  </div>

  <!-- Login Card -->
  <div class="relative z-10 w-full max-w-md bg-gray-800 rounded-2xl shadow-2xl p-8 border border-gray-700">

    <!-- Logo -->
    <div class="text-center mb-6">
      <img src="../assets/logo.jpeg" class="w-20 h-20 rounded-full mx-auto border-2 border-white">
      <h1 class="text-2xl font-bold text-white mt-4">Admin Login</h1>
      <p class="text-gray-400 text-sm">Shaheed RNS Education Academy</p>
    </div>

    <!-- Error Message -->
    <?php if (isset($error)) : ?>
      <div class="bg-red-500/20 border border-red-500 text-red-400 px-4 py-2 rounded mb-4 text-center">
        <?= $error ?>
      </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="post" class="space-y-5">

      <div>
        <label class="block text-sm text-green-400 mb-1">Username</label>
        <input
          type="text"
          name="user"
          required
          placeholder="Enter username"
          class="w-full px-4 py-3 rounded-lg bg-gray-900 border border-gray-700 text-white
                 focus:outline-none focus:ring-2 focus:ring-yellow-500">
      </div>

      <div>
        <label class="block text-sm text-green-400 mb-1">Password</label>
        <input
          type="password"
          name="pass"
          required
          placeholder="Enter password"
          class="w-full px-4 py-3 rounded-lg bg-gray-900 border border-gray-700 text-white
                 focus:outline-none focus:ring-2 focus:ring-yellow-500">
      </div>

      <button
        type="submit"
        name="login"
        class="w-full bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold
               py-3 rounded-full transition transform hover:scale-105 shadow-lg">
        Login
      </button>

    </form>

    <!-- Footer -->
    <p class="text-center text-gray-500 text-xs mt-6">
      © <?= date('Y') ?> Shaheed RNS Education Academy
    </p>

  </div>

</body>
</html>
