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

/* 📤 Image Upload */
if (isset($_POST['upload'])) {
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','webp'];

    if (!in_array($ext, $allowed)) {
        $error = "Only JPG, PNG, WEBP allowed";
    } else {
        $newName = time().'_'.rand(1000,9999).'.'.$ext;
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/gallery/".$newName);
        mysqli_query($conn,"INSERT INTO gallery_images (image) VALUES ('$newName')");
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
        $success = "Image deleted";
    }
}

/* 📊 Dashboard Stats */
$totalImages = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM gallery_images"));
$totalEnquiries = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM enquiries"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white min-h-screen flex">

<!-- SIDEBAR -->
<aside class="w-64 bg-black fixed inset-y-0 left-0 border-r border-gray-700">

  <div class="p-6 text-center border-b border-gray-700">
    <img src="../assets/logo.jpeg" id="profileBtn"
         class="w-20 h-20 mx-auto rounded-full border-2 border-yellow-400 cursor-pointer">
    <h2 class="text-yellow-400 text-sm font-semibold mt-3">
      Shaheed RNS Education Academy
    </h2>

    <div id="profileMenu" class="hidden mt-4 bg-gray-800 rounded-lg text-sm">
      <a href="change-password" class="block px-4 py-2 hover:bg-gray-700">Change Password</a>
      <a href="logout" class="block px-4 py-2 text-red-400 hover:bg-gray-700">Logout</a>
    </div>
  </div>

  <nav class="p-4 space-y-2 text-sm">
    <button onclick="showTab('dashboard')" class="menu-btn">Dashboard</button>
    <button onclick="showTab('gallery')" class="menu-btn">Gallery</button>
    <button onclick="showTab('enquiries')" class="menu-btn">Enquiries</button>
  </nav>
</aside>

<!-- MAIN -->
<main class="ml-64 flex-1 p-8 space-y-10">

<!-- DASHBOARD -->
<section id="dashboard">
  <h1 class="text-2xl font-bold text-yellow-400 mb-6">Dashboard Overview</h1>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-gray-800 p-6 rounded-xl border border-gray-700">
      <h3 class="text-gray-400">Gallery Images</h3>
      <p class="text-3xl font-bold text-yellow-400"><?= $totalImages ?></p>
    </div>
    <div class="bg-gray-800 p-6 rounded-xl border border-gray-700">
      <h3 class="text-gray-400">Student Enquiries</h3>
      <p class="text-3xl font-bold text-green-400"><?= $totalEnquiries ?></p>
    </div>
  </div>
</section>

<!-- GALLERY -->
<section id="gallery" class="hidden space-y-6">
  <h2 class="text-xl text-yellow-400 font-semibold">Gallery</h2>

  <form method="post" enctype="multipart/form-data" class="flex gap-4">
    <input type="file" name="image" required class="bg-gray-800 p-3 rounded">
    <button name="upload" class="bg-yellow-500 px-6 py-3 rounded text-black">Upload</button>
  </form>

  <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
    <?php
    $res = mysqli_query($conn,"SELECT * FROM gallery_images ORDER BY id DESC");
    while($row = mysqli_fetch_assoc($res)){
    ?>
    <div class="bg-gray-800 rounded-xl overflow-hidden">
      <img src="../assets/gallery/<?= $row['image'] ?>" class="h-40 w-full object-cover">
      <a href="?delete=<?= $row['id'] ?>" class="block text-red-400 text-center py-2">Delete</a>
    </div>
    <?php } ?>
  </div>
</section>

<!-- ENQUIRIES -->
<section id="enquiries" class="hidden space-y-6">
  <div class="flex justify-between">
    <h2 class="text-xl text-yellow-400 font-semibold">Student Enquiries</h2>
    <a href="?download=enquiries" class="bg-green-500 text-black px-4 py-2 rounded">Download Excel</a>
  </div>

  <table class="w-full text-sm border border-gray-700">
    <thead class="bg-gray-700">
      <tr>
        <th class="p-3">Name</th>
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
      <tr class="border-t border-gray-700">
        <td class="p-2"><?= $row['name'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['phone'] ?></td>
        <td><?= $row['message'] ?></td>
        <td><?= $row['created_at'] ?></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</section>

</main>

<script>
  function showTab(id){
    document.querySelectorAll("main section").forEach(s => s.classList.add("hidden"));
    document.getElementById(id).classList.remove("hidden");
  }

  document.getElementById("profileBtn").onclick = () =>
    document.getElementById("profileMenu").classList.toggle("hidden");
</script>

<style>
.menu-btn{
  width:100%;
  padding:12px;
  border-radius:8px;
  text-align:left;
}
.menu-btn:hover{ background:#374151; }
</style>

</body>
</html>
