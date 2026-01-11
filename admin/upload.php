<?php
session_start();
include "../config/db.php";

/* 🔐 Login protection */
if (!isset($_SESSION['admin_id'])) {
    header("Location: login");
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
<title>Admin Dashboard | Shaheed RNS Education Academy</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white min-h-screen flex">

<!-- ================= SIDEBAR ================= -->
<aside class="w-64 bg-black border-r border-gray-700 fixed inset-y-0 left-0">

  <!-- Profile -->
  <div class="p-6 text-center border-b border-gray-700">
    <img src="../assets/logo.jpeg"
         id="profileBtn"
         class="w-20 h-20 mx-auto rounded-full border-2 border-yellow-400 cursor-pointer">
    <h2 class="text-yellow-400 text-sm font-semibold mt-3">
      Shaheed RNS Education Academy
    </h2>

    <div id="profileMenu"
         class="hidden mt-4 bg-gray-800 rounded-lg border border-gray-700 text-sm">
      <a href="change-password" class="block px-4 py-2 hover:bg-gray-700">Change Password</a>
      <a href="logout" class="block px-4 py-2 text-red-400 hover:bg-gray-700">Logout</a>
    </div>
  </div>

  <!-- Menu -->
  <nav class="p-4 space-y-2 text-sm">
    <button onclick="showSection('dashboard')"
      class="w-full text-left px-4 py-3 rounded-lg bg-yellow-500 text-black font-semibold">
      Dashboard
    </button>
    <button onclick="showSection('gallery')"
      class="w-full text-left px-4 py-3 rounded-lg hover:bg-gray-700">
      Gallery
    </button>
    <button onclick="showSection('enquiries')"
      class="w-full text-left px-4 py-3 rounded-lg hover:bg-gray-700">
      Enquiries
    </button>
  </nav>
</aside>

<!-- ================= MAIN ================= -->
<main class="ml-64 flex-1 px-8 py-8 space-y-8">

<!-- ========== DASHBOARD OVERVIEW ========== -->
<section id="dashboardSection">

  <h1 class="text-2xl font-bold text-yellow-400 mb-6">Dashboard Overview</h1>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-gray-800 p-6 rounded-xl border border-gray-700">
      <h3 class="text-gray-400 text-sm">Total Gallery Images</h3>
      <p class="text-3xl font-bold text-yellow-400">
        <?= mysqli_num_rows(mysqli_query($conn,"SELECT id FROM gallery_images")) ?>
      </p>
    </div>

    <div class="bg-gray-800 p-6 rounded-xl border border-gray-700">
      <h3 class="text-gray-400 text-sm">Total Enquiries</h3>
      <p class="text-3xl font-bold text-green-400">
        <?= mysqli_num_rows(mysqli_query($conn,"SELECT id FROM enquiries")) ?>
      </p>
    </div>

    <div class="bg-gray-800 p-6 rounded-xl border border-gray-700">
      <h3 class="text-gray-400 text-sm">Admin Status</h3>
      <p class="text-xl font-semibold text-blue-400 mt-2">Active</p>
    </div>

  </div>

</section>

<!-- ========== GALLERY MANAGEMENT ========== -->
<section id="gallerySection" class="hidden">

  <h1 class="text-2xl font-bold text-yellow-400 mb-6">Gallery Management</h1>

  <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 mb-6">
    <form method="post" enctype="multipart/form-data" class="flex gap-4 flex-wrap">
      <input type="file" name="image" required
        class="flex-1 bg-gray-900 border border-gray-600 rounded-lg px-4 py-3">
      <button name="upload"
        class="bg-yellow-500 hover:bg-yellow-600 text-black px-8 py-3 rounded-lg font-semibold">
        Upload Image
      </button>
    </form>
  </div>

  <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
    <?php
    $res = mysqli_query($conn,"SELECT * FROM gallery_images ORDER BY id DESC");
    while($row = mysqli_fetch_assoc($res)){
    ?>
    <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
      <img src="../assets/gallery/<?= $row['image'] ?>" class="h-40 w-full object-cover">
      <div class="p-3 text-center bg-black/40">
        <a href="?delete=<?= $row['id'] ?>" class="text-red-400 text-sm"
           onclick="return confirm('Delete image?')">Delete</a>
      </div>
    </div>
    <?php } ?>
  </div>

</section>

<!-- ========== ENQUIRIES MANAGEMENT ========== -->
<section id="enquiriesSection" class="hidden">

  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold text-yellow-400">Student Enquiries</h1>
    <a href="?download=enquiries"
       class="bg-green-500 hover:bg-green-600 text-black px-4 py-2 rounded-lg font-semibold">
      Download Excel
    </a>
  </div>

  <div class="overflow-x-auto bg-gray-800 rounded-xl border border-gray-700">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-700">
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

</main>

<!-- JS -->
<script>
  function showSection(section) {
    document.getElementById('dashboardSection').classList.add('hidden');
    document.getElementById('gallerySection').classList.add('hidden');
    document.getElementById('enquiriesSection').classList.add('hidden');

    document.getElementById(section + 'Section').classList.remove('hidden');
  }

  document.getElementById("profileBtn").onclick = () => {
    document.getElementById("profileMenu").classList.toggle("hidden");
  };
</script>

</body>
</html>
