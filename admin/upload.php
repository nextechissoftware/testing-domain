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

<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black text-white min-h-screen flex">

<!-- ================= SIDEBAR ================= -->
<aside class="w-64 fixed inset-y-0 left-0 bg-black border-r border-gray-700">

  <div class="p-6 text-center border-b border-gray-700">
    <img src="../assets/logo.jpeg"
         id="profileBtn"
         class="w-20 h-20 mx-auto rounded-full border-2 border-yellow-400 cursor-pointer">
    <h2 class="text-yellow-400 text-sm font-semibold mt-3">
      Shaheed RNS Education Academy
    </h2>
    <p class="text-xs text-gray-400">Admin Panel</p>

    <!-- Profile Dropdown -->
    <div id="profileMenu" class="hidden mt-4 bg-gray-800 rounded-lg border border-gray-700 text-sm">
      <a href="change-password" class="block px-4 py-2 hover:bg-gray-700">
        Change Password
      </a>
      <a href="logout" class="block px-4 py-2 text-red-400 hover:bg-gray-700">
        Logout
      </a>
    </div>
  </div>

  <!-- Sidebar Menu -->
  <nav class="p-4 space-y-2 text-sm">
    <a href="#dashboard"
       class="block px-4 py-3 rounded-lg bg-yellow-500 text-black font-semibold">
       Dashboard
    </a>
    <a href="#gallery"
       class="block px-4 py-3 rounded-lg hover:bg-gray-700">
       Gallery Images
    </a>
    <a href="#enquiries"
       class="block px-4 py-3 rounded-lg hover:bg-gray-700">
       Student Enquiries
    </a>
  </nav>

  <p class="absolute bottom-4 w-full text-center text-xs text-gray-500">
    © <?= date('Y') ?>
  </p>
</aside>

<!-- ================= MAIN CONTENT ================= -->
<main class="ml-64 flex-1 px-8 py-10 space-y-12">

<!-- Dashboard -->
<section id="dashboard">
  <h1 class="text-2xl font-bold text-yellow-400 mb-6">
    Admin Dashboard
  </h1>

  <?php if (isset($error)) : ?>
    <div class="bg-red-500/20 border border-red-500 text-red-400 px-5 py-3 rounded-xl mb-6">
      <?= $error ?>
    </div>
  <?php endif; ?>

  <?php if (isset($success)) : ?>
    <div class="bg-green-500/20 border border-green-500 text-green-400 px-5 py-3 rounded-xl mb-6">
      <?= $success ?>
    </div>
  <?php endif; ?>
</section>

<!-- Upload Section -->
<section class="bg-gray-800/80 backdrop-blur rounded-2xl p-6 border border-gray-700 shadow">
  <h2 class="text-xl font-semibold text-yellow-400 mb-4">
    Upload School Gallery Image
  </h2>

  <form method="post" enctype="multipart/form-data" class="flex gap-4 flex-wrap">
    <input type="file" name="image" required
           class="flex-1 bg-gray-900 border border-gray-600 rounded-lg px-4 py-3">
    <button type="submit" name="upload"
            class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold px-8 py-3 rounded-lg">
      Upload Image
    </button>
  </form>
</section>

<!-- Gallery -->
<section id="gallery">
  <h2 class="text-xl font-semibold text-yellow-400 mb-5">
    Gallery Images
  </h2>

  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
    <?php
    $res = mysqli_query($conn,"SELECT * FROM gallery_images ORDER BY id DESC");
    while($row = mysqli_fetch_assoc($res)){
    ?>
      <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
        <img src="../assets/gallery/<?= $row['image'] ?>"
             class="w-full h-40 object-cover">
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

<!-- Enquiries -->
<section id="enquiries" class="bg-gray-800/80 backdrop-blur rounded-2xl p-6 border border-gray-700 shadow">
  <div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-semibold text-yellow-400">
      Student Enquiries
    </h2>
    <a href="?download=enquiries"
       class="bg-green-500 hover:bg-green-600 text-black px-4 py-2 rounded-lg font-semibold">
      Download Excel
    </a>
  </div>

  <div class="overflow-x-auto">
    <table class="min-w-full text-sm border border-gray-700">
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
  document.getElementById("profileBtn").onclick = () => {
    document.getElementById("profileMenu").classList.toggle("hidden");
  };
</script>

</body>
</html>
