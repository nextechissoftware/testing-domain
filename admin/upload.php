<?php
session_start();
include "../config/db.php";

/* 🔐 Login protection */
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
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
        if (move_uploaded_file($tmpName,$uploadPath)) {
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
        if(file_exists($filePath)) unlink($filePath);
        mysqli_query($conn,"DELETE FROM gallery_images WHERE id=$id");
        $success = "Image deleted successfully";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white min-h-screen">

<!-- Header -->
<header class="bg-gray-800 px-6 py-4 flex justify-between items-center shadow">
  <h1 class="text-xl font-bold text-yellow-400">Admin Dashboard</h1>
  <div class="space-x-4">
    <a href="change-password.php" class="text-sm text-gray-300 hover:text-white">Change Password</a>
    <a href="logout.php" class="text-sm text-red-400 hover:text-red-500">Logout</a>
  </div>
</header>

<div class="p-6 max-w-7xl mx-auto space-y-10">

  <!-- Messages -->
  <?php if (isset($error)) : ?>
    <div class="bg-red-500/20 border border-red-500 text-red-400 px-4 py-3 rounded">
      <?= $error ?>
    </div>
  <?php endif; ?>

  <?php if (isset($success)) : ?>
    <div class="bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 rounded">
      <?= $success ?>
    </div>
  <?php endif; ?>

  <!-- Upload Section -->
  <section class="bg-gray-800 rounded-xl p-6 shadow">
    <h2 class="text-lg font-semibold mb-4 text-yellow-400">Upload Gallery Image</h2>

    <form method="post" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-4">
      <input
        type="file"
        name="image"
        accept="image/*"
        required
        class="flex-1 bg-gray-900 border border-gray-700 rounded-lg px-4 py-2"
      >
      <button
        type="submit"
        name="upload"
        class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold px-6 py-2 rounded-lg">
        Upload
      </button>
    </form>
  </section>

  <!-- Gallery -->
  <section>
    <h2 class="text-lg font-semibold mb-4 text-yellow-400">Gallery Images</h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
      <?php
      $result = mysqli_query($conn,"SELECT * FROM gallery_images ORDER BY id DESC");
      while($row = mysqli_fetch_assoc($result)){
      ?>
        <div class="bg-gray-800 rounded-lg overflow-hidden shadow">
          <img
            src="../assets/gallery/<?= $row['image'] ?>"
            class="w-full h-40 object-cover"
          >
          <div class="p-3 text-center">
            <a
              href="?delete=<?= $row['id'] ?>"
              onclick="return confirm('Are you sure?')"
              class="text-red-400 hover:text-red-500 text-sm">
              Delete
            </a>
          </div>
        </div>
      <?php } ?>
    </div>
  </section>

  <!-- Enquiries -->
  <section class="bg-gray-800 rounded-xl p-6 shadow">
    <h2 class="text-lg font-semibold mb-4 text-yellow-400">Form Submissions</h2>

    <div class="overflow-x-auto">
      <table class="min-w-full border border-gray-700 text-sm">
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

</body>
</html>
