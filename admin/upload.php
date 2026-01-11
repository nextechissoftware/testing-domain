<?php
session_start();
include "../config/db.php";

/* 🔐 Login protection */
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

/* 📥 Download Enquiries as Excel (CSV) */
if (isset($_GET['download']) && $_GET['download'] === 'enquiries') {

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=student_enquiries.csv');

    $output = fopen('php://output', 'w');

    fputcsv($output, ['Name', 'Email', 'Phone', 'Message', 'Date']);

    $enq = mysqli_query($conn, "SELECT * FROM enquiries ORDER BY id DESC");
    while ($row = mysqli_fetch_assoc($enq)) {
        fputcsv($output, [
            $row['name'],
            $row['email'],
            $row['phone'],
            $row['message'],
            $row['created_at']
        ]);
    }

    fclose($output);
    exit;
}

/* 📤 Image Upload Logic */
if (isset($_POST['upload'])) {
    $file = $_FILES['image'];
    $fileName = $file['name'];
    $tmpName = $file['tmp_name'];
    $allowed = ['jpg','jpeg','png','webp'];
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        $error = "Only JPG, PNG, WEBP allowed";
    } else {
        $newName = time().'_'.rand(1000,9999).'.'.$ext;
        $uploadPath = "../assets/gallery/".$newName;

        if (move_uploaded_file($tmpName, $uploadPath)) {
            mysqli_query($conn,"INSERT INTO gallery_images (image) VALUES ('$newName')");
            $success = "Image uploaded successfully";
        } else {
            $error = "Upload failed";
        }
    }
}

/* 🗑️ Delete Image Logic */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $row = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM gallery_images WHERE id=$id"));

    if ($row) {
        $filePath = "../assets/gallery/".$row['image'];
        if (file_exists($filePath)) unlink($filePath);
        mysqli_query($conn,"DELETE FROM gallery_images WHERE id=$id");
        $success = "Image deleted successfully";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Panel | Shaheed RNS Education Academy</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black text-white min-h-screen">

<!-- HEADER -->
<header class="bg-black/70 backdrop-blur border-b border-gray-700">
  <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

    <div class="flex items-center gap-4">
      <img src="../assets/logo.jpeg" class="w-12 h-12 rounded-full border-2 border-yellow-400">
      <div>
        <h1 class="text-lg font-bold text-yellow-400">Shaheed RNS Education Academy</h1>
        <p class="text-xs text-gray-400">Admin Dashboard</p>
      </div>
    </div>

    <div class="space-x-4 text-sm">
      <a href="change-password.php" class="text-gray-300 hover:text-yellow-400">Change Password</a>
      <a href="logout.php" class="text-red-400 hover:text-red-500">Logout</a>
    </div>

  </div>
</header>

<div class="max-w-7xl mx-auto px-6 py-10 space-y-10">

  <!-- Alerts -->
  <?php if (isset($error)) : ?>
    <div class="bg-red-500/20 border border-red-500 text-red-400 px-5 py-3 rounded-xl">
      <?= $error ?>
    </div>
  <?php endif; ?>

  <?php if (isset($success)) : ?>
    <div class="bg-green-500/20 border border-green-500 text-green-400 px-5 py-3 rounded-xl">
      <?= $success ?>
    </div>
  <?php endif; ?>

  <!-- Upload Image -->
  <section class="bg-gray-800/80 backdrop-blur rounded-2xl p-6 shadow-xl border border-gray-700">
    <h2 class="text-xl font-semibold text-yellow-400 mb-4">Upload School Gallery Image</h2>

    <form method="post" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-4">
      <input type="file" name="image" accept="image/*" required
             class="flex-1 bg-gray-900 border border-gray-600 rounded-lg px-4 py-3">
      <button type="submit" name="upload"
              class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold px-8 py-3 rounded-lg shadow">
        Upload Image
      </button>
    </form>
  </section>

  <!-- Gallery -->
  <section>
    <h2 class="text-xl font-semibold text-yellow-400 mb-5">Gallery Images</h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
      <?php
      $result = mysqli_query($conn,"SELECT * FROM gallery_images ORDER BY id DESC");
      while($row = mysqli_fetch_assoc($result)){
      ?>
        <div class="bg-gray-800 rounded-xl overflow-hidden shadow border border-gray-700">
          <img src="../assets/gallery/<?= $row['image'] ?>"
               class="w-full h-40 object-cover hover:scale-105 transition">
          <div class="p-3 text-center bg-black/40">
            <a href="?delete=<?= $row['id'] ?>"
               onclick="return confirm('Are you sure?')"
               class="text-red-400 hover:text-red-500 text-sm">
               Delete
            </a>
          </div>
        </div>
      <?php } ?>
    </div>
  </section>

  <!-- Student Enquiries -->
  <section class="bg-gray-800/80 backdrop-blur rounded-2xl p-6 shadow-xl border border-gray-700">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-yellow-400">Student Enquiries</h2>
      <a href="?download=enquiries"
         class="bg-green-500 hover:bg-green-600 text-black font-semibold px-4 py-2 rounded-lg shadow">
        Download Excel
      </a>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full text-sm border border-gray-700">
        <thead class="bg-gray-700 text-gray-300">
          <tr>
            <th class="p-3 text-left">Name</th>
            <th class="p-3 text-left">Email</th>
            <th class="p-3 text-left">Phone</th>
            <th class="p-3 text-left">Message</th>
            <th class="p-3 text-left">Date</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $enq = mysqli_query($conn, "SELECT * FROM enquiries ORDER BY id DESC");
        while ($row = mysqli_fetch_assoc($enq)) {
        ?>
          <tr class="border-t border-gray-700 hover:bg-gray-700/40">
            <td class="p-3"><?= $row['name'] ?></td>
            <td class="p-3"><?= $row['email'] ?></td>
            <td class="p-3"><?= $row['phone'] ?></td>
            <td class="p-3"><?= $row['message'] ?></td>
            <td class="p-3"><?= $row['created_at'] ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </section>

</div>

<footer class="text-center text-gray-500 text-xs py-6">
  © <?= date('Y') ?> Shaheed RNS Education Academy. All rights reserved.
</footer>

</body>
</html>
