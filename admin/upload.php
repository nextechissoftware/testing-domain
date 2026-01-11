<?php
session_start();
include "../config/db.php";

/* 🔐 Login protection */
if (!isset($_SESSION['admin_id'])) {
    header("Location: login");
    exit;
}

/* 📥 Download Enquiries */
if (isset($_GET['download']) && $_GET['download'] === 'enquiries') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=student_enquiries.csv');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Name','Email','Phone','Message','Date']);

    $enq = mysqli_query($conn,"SELECT * FROM enquiries ORDER BY id DESC");
    while($row=mysqli_fetch_assoc($enq)){
        fputcsv($output, [$row['name'],$row['email'],$row['phone'],$row['message'],$row['created_at']]);
    }
    fclose($output);
    exit;
}

/* 📤 Upload Image */
if (isset($_POST['upload'])) {
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext,['jpg','jpeg','png','webp'])) {
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
<title>Admin Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
.menu{
  width:100%;
  padding:10px;
  border-radius:8px;
  text-align:left;
  transition: all 0.3s ease;
  color:#e5e7eb;
}

/* HOVER */
.menu:hover{
  background: linear-gradient(90deg, #22c55e, #3b82f6);
  color: #ffffff;
  transform: translateX(4px);
}

/* ACTIVE */
.menu.active{
  background: linear-gradient(90deg, #facc15, #22c55e);
  color: #000000;
  font-weight: 600;
}
</style>
</head>

<body class="bg-gray-900 text-white min-h-screen flex">

<!-- SIDEBAR -->
<aside class="w-64 bg-black fixed inset-y-0 left-0 border-r border-gray-700 flex flex-col">

  <!-- Logo -->
  <div class="p-6 text-center border-b border-gray-700">
    <img src="../assets/logo.jpeg"
         class="w-20 h-20 mx-auto rounded-full border-2 border-yellow-400">
    <h2 class="text-sm font-semibold mt-3 text-yellow-400">
      Shaheed RNS Education Academy
    </h2>
    <p class="text-xs text-gray-400">Admin Panel</p>
  </div>

  <!-- Menu -->
  <nav class="flex-1 p-4 space-y-2 text-sm">
    <button onclick="showSection(this,'dashboard')" class="menu active">Dashboard</button>
    <button onclick="showSection(this,'gallery')" class="menu">Gallery</button>
    <button onclick="showSection(this,'enquiries')" class="menu">Student Enquiries</button>
    <a href="change-password" class="menu block">Change Password</a>
  </nav>

  <!-- Logout -->
  <div class="p-4 border-t border-gray-700">
    <a href="logout"
       class="block bg-red-500 hover:bg-red-600 text-center rounded-lg py-2 transition">
      Logout
    </a>
  </div>
</aside>

<!-- MAIN -->
<main class="ml-64 flex-1 p-8 space-y-10">

<?php if(isset($error)): ?>
<div class="bg-red-500/20 border border-red-500 text-red-400 p-3 rounded">
  <?= $error ?>
</div>
<?php endif; ?>

<?php if(isset($success)): ?>
<div class="bg-green-500/20 border border-green-500 text-green-400 p-3 rounded">
  <?= $success ?>
</div>
<?php endif; ?>

<!-- DASHBOARD -->
<section id="dashboard">
  <h1 class="text-2xl font-bold text-yellow-400 mb-6">Dashboard</h1>

  <!-- Upload -->
  <div class="bg-gray-800 p-6 rounded-lg border border-gray-700 mb-8">
    <h2 class="text-lg font-semibold mb-3">Quick Upload</h2>
    <form method="post" enctype="multipart/form-data" class="flex gap-3">
      <input type="file" name="image" required class="flex-1 bg-gray-900 p-2 rounded">
      <button name="upload"
              class="bg-yellow-500 hover:bg-yellow-600 px-6 py-2 rounded text-black font-semibold">
        Upload
      </button>
    </form>
  </div>

  <!-- Enquiries -->
  <div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
    <div class="flex justify-between mb-4">
      <h2 class="text-lg font-semibold text-green-400">Student Enquiries</h2>
      <a href="?download=enquiries"
         class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded text-white font-semibold">
        Download Excel
      </a>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <tr class="bg-gray-700">
          <th class="p-2">Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Message</th>
          <th>Date</th>
        </tr>
        <?php
        $enq = mysqli_query($conn,"SELECT * FROM enquiries ORDER BY id DESC");
        while($row=mysqli_fetch_assoc($enq)){
        ?>
        <tr class="border-t border-gray-700 hover:bg-gray-700/40">
          <td class="p-2"><?= $row['name'] ?></td>
          <td><?= $row['email'] ?></td>
          <td><?= $row['phone'] ?></td>
          <td><?= $row['message'] ?></td>
          <td><?= $row['created_at'] ?></td>
        </tr>
        <?php } ?>
      </table>
    </div>
  </div>
</section>

<!-- GALLERY -->
<section id="gallery" class="hidden">
  <h1 class="text-2xl font-bold text-yellow-400 mb-4">Gallery</h1>
</section>

<!-- ENQUIRIES -->
<section id="enquiries" class="hidden">
  <h1 class="text-2xl font-bold text-yellow-400 mb-4">Student Enquiries</h1>
</section>

</main>

<script>
function showSection(el,id){
  document.querySelectorAll("main section").forEach(s=>s.classList.add("hidden"));
  document.getElementById(id).classList.remove("hidden");

  document.querySelectorAll(".menu").forEach(m=>m.classList.remove("active"));
  el.classList.add("active");
}
</script>

</body>
</html>
