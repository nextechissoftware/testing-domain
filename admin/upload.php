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
    fputcsv($output, ['Name','Email','Phone','Message','Date']);

    $enq = mysqli_query($conn,"SELECT * FROM enquiries ORDER BY id DESC");
    while($row = mysqli_fetch_assoc($enq)){
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

/* 📤 Upload Image */
if (isset($_POST['upload'])) {
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','webp'];

    if (!in_array($ext,$allowed)) {
        $error = "Only JPG, PNG, WEBP allowed";
    } else {
        $name = time().'_'.rand(1000,9999).'.'.$ext;
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/gallery/".$name);
        mysqli_query($conn,"INSERT INTO gallery_images (image) VALUES ('$name')");
        $success = "Image uploaded successfully";
    }
}

/* 🗑 Delete Image */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $row = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM gallery_images WHERE id=$id"));
    if ($row) {
        unlink("../assets/gallery/".$row['image']);
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

<!-- ========== SIDEBAR ========== -->
<aside class="w-64 fixed inset-y-0 left-0 bg-black border-r border-gray-700 flex flex-col">

  <!-- Profile -->
  <div class="p-6 text-center border-b border-gray-700">
    <img src="../assets/logo.jpeg" class="w-20 h-20 mx-auto rounded-full border-2 border-yellow-400">
    <h2 class="text-yellow-400 text-sm font-semibold mt-3">
      Shaheed RNS Education Academy
    </h2>
    <p class="text-xs text-gray-400">Admin Panel</p>
  </div>

  <!-- Menu -->
  <nav class="flex-1 p-4 space-y-2 text-sm">
    <a href="#dashboard" class="menu-item">Dashboard</a>
    <a href="#upload" class="menu-item">Upload Image</a>
    <a href="#gallery" class="menu-item">Gallery</a>
    <a href="#enquiries" class="menu-item">Student Enquiries</a>
    <a href="change-password" class="menu-item">Change Password</a>
  </nav>

  <!-- Logout -->
  <div class="p-4 border-t border-gray-700">
    <a href="logout"
       class="block text-center bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg">
       Logout
    </a>
  </div>

</aside>

<!-- ========== MAIN CONTENT ========== -->
<main class="ml-64 flex-1 px-8 py-8 space-y-12">

<!-- ALERTS -->
<?php if(isset($error)): ?>
<div class="bg-red-500/20 text-red-400 border border-red-500 px-4 py-3 rounded">
<?= $error ?>
</div>
<?php endif; ?>

<?php if(isset($success)): ?>
<div class="bg-green-500/20 text-green-400 border border-green-500 px-4 py-3 rounded">
<?= $success ?>
</div>
<?php endif; ?>

<!-- DASHBOARD -->
<section id="dashboard">
  <h1 class="text-2xl font-bold text-yellow-400 mb-4">Dashboard</h1>
  <p class="text-gray-400">Welcome Admin 👋</p>
</section>

<!-- UPLOAD -->
<section id="upload" class="bg-gray-800 p-6 rounded-xl border border-gray-700">
  <h2 class="text-xl font-semibold text-yellow-400 mb-4">Upload Gallery Image</h2>
  <form method="post" enctype="multipart/form-data" class="flex gap-4 flex-wrap">
    <input type="file" name="image" required
           class="flex-1 bg-gray-900 border border-gray-600 rounded px-4 py-2">
    <button name="upload"
            class="bg-yellow-500 hover:bg-yellow-600 text-black px-6 py-2 rounded font-semibold">
      Upload
    </button>
  </form>
</section>

<!-- GALLERY -->
<section id="gallery">
  <h2 class="text-xl text-yellow-400 font-semibold mb-4">Gallery</h2>
  <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
    <?php
    $res = mysqli_query($conn,"SELECT * FROM gallery_images ORDER BY id DESC");
    while($row = mysqli_fetch_assoc($res)){
    ?>
    <div class="bg-gray-800 rounded-lg overflow-hidden border border-gray-700">
      <img src="../assets/gallery/<?= $row['image'] ?>" class="h-40 w-full object-cover">
      <a href="?delete=<?= $row['id'] ?>"
         class="block text-center text-red-400 py-2 text-sm"
         onclick="return confirm('Delete image?')">
        Delete
      </a>
    </div>
    <?php } ?>
  </div>
</section>

<!-- ENQUIRIES -->
<section id="enquiries" class="bg-gray-800 p-6 rounded-xl border border-gray-700">
  <div class="flex justify-between mb-4">
    <h2 class="text-xl text-yellow-400 font-semibold">Student Enquiries</h2>
    <a href="?download=enquiries"
       class="bg-green-500 hover:bg-green-600 text-black px-4 py-2 rounded font-semibold">
       Download Excel
    </a>
  </div>

  <div class="overflow-x-auto">
  <table class="w-full text-sm border border-gray-700">
    <thead class="bg-gray-700">
      <tr>
        <th class="p-2">Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Message</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
    <?php
    $enq = mysqli_query($conn,"SELECT * FROM enquiries ORDER BY id DESC");
    while($row = mysqli_fetch_assoc($enq)){
    ?>
    <tr class="border-t border-gray-700 hover:bg-gray-700/40">
      <td class="p-2"><?= $row['name'] ?></td>
      <td><?= $row['email'] ?></td>
      <td><?= $row['phone'] ?></td>
      <td><?= $row['message'] ?></td>
      <td><?= $row['created_at'] ?></td>
    </tr>
    <?php } ?>
    </tbody>
  </table>
  </div>
</section>

</main>

<style>
.menu-item{
  display:block;
  padding:10px;
  border-radius:8px;
}
.menu-item:hover{ background:#374151; }
</style>

</body>
</html>
