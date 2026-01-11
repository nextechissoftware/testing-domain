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

    $out = fopen('php://output', 'w');
    fputcsv($out, ['Name','Email','Phone','Message','Date']);

    $q = mysqli_query($conn,"SELECT * FROM enquiries ORDER BY id DESC");
    while($r = mysqli_fetch_assoc($q)){
        fputcsv($out, [$r['name'],$r['email'],$r['phone'],$r['message'],$r['created_at']]);
    }
    fclose($out);
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
    if($row){
        unlink("../assets/gallery/".$row['image']);
        mysqli_query($conn,"DELETE FROM gallery_images WHERE id=$id");
        $success = "Image deleted successfully";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white min-h-screen flex">

<!-- SIDEBAR -->
<aside class="w-64 fixed inset-y-0 left-0 bg-black border-r border-gray-700 flex flex-col">

  <div class="p-6 text-center border-b border-gray-700">
    <img src="../assets/logo.jpeg" class="w-20 h-20 mx-auto rounded-full border-2 border-yellow-400">
    <h2 class="text-sm font-semibold mt-3 bg-gradient-to-r from-yellow-400 via-green-400 to-blue-400 bg-clip-text text-transparent">
      Shaheed RNS Education Academy
    </h2>
    <p class="text-xs text-gray-400">Admin Panel</p>
  </div>

  <nav class="flex-1 p-4 space-y-2 text-sm">
    <button onclick="showSection('dashboard')" class="menu active">Dashboard</button>
    <button onclick="showSection('gallery')" class="menu">Gallery</button>
    <button onclick="showSection('enquiries')" class="menu">Student Enquiries</button>
    <a href="change-password" class="menu block">Change Password</a>
  </nav>

  <div class="p-4 border-t border-gray-700">
    <a href="logout" class="block text-center bg-red-500 hover:bg-red-600 py-2 rounded-lg">
      Logout
    </a>
  </div>
</aside>

<!-- MAIN -->
<main class="ml-64 flex-1 p-8 space-y-10">

<?php if(isset($error)): ?>
<div class="bg-red-500/20 text-red-400 border border-red-500 p-3 rounded"><?= $error ?></div>
<?php endif; ?>

<?php if(isset($success)): ?>
<div class="bg-green-500/20 text-green-400 border border-green-500 p-3 rounded"><?= $success ?></div>
<?php endif; ?>

<!-- DASHBOARD -->
<section id="dashboard">
  <h1 class="text-2xl font-bold text-yellow-400 mb-6">Dashboard</h1>

  <!-- Quick Upload -->
  <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 mb-8">
    <h2 class="text-lg font-semibold mb-3">Quick Upload</h2>
    <form method="post" enctype="multipart/form-data" class="flex gap-3">
      <input type="file" name="image" required class="flex-1 bg-gray-900 p-2 rounded">
      <button name="upload"
              class="bg-yellow-400 hover:bg-yellow-500 text-black px-6 py-2 rounded font-semibold">
        Upload
      </button>
    </form>
  </div>

  <!-- Latest Enquiries -->
  <div class="bg-gray-800 p-6 rounded-xl border border-gray-700">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-lg font-semibold">Latest Enquiries</h2>
      <a href="?download=enquiries"
         class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded font-semibold">
        Download Excel
      </a>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <tr class="bg-gray-700">
          <th class="p-2">Name</th><th>Email</th><th>Phone</th><th>Date</th>
        </tr>
        <?php
        $en = mysqli_query($conn,"SELECT * FROM enquiries ORDER BY id DESC LIMIT 5");
        while($row=mysqli_fetch_assoc($en)){
        ?>
        <tr class="border-t border-gray-700 hover:bg-gray-700/40">
          <td class="p-2"><?= $row['name'] ?></td>
          <td><?= $row['email'] ?></td>
          <td><?= $row['phone'] ?></td>
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
  <!-- Gallery content unchanged -->
</section>

<!-- ENQUIRIES -->
<section id="enquiries" class="hidden">
  <h1 class="text-xl font-bold text-blue-400 mb-4">Student Enquiries</h1>
  <!-- Full enquiry table remains -->
</section>

</main>

<script>
function showSection(id){
  document.querySelectorAll("main section").forEach(s=>s.classList.add("hidden"));
  document.getElementById(id).classList.remove("hidden");

  document.querySelectorAll(".menu").forEach(m=>m.classList.remove("active"));
  event.target.classList.add("active");
}
</script>

<style>
.menu{
  width:100%;
  padding:10px;
  border-radius:8px;
  text-align:left;
  transition:.3s;
}
.menu:hover{
  background:linear-gradient(90deg,#22c55e,#3b82f6);
}
.menu.active{
  background:linear-gradient(90deg,#facc15,#22c55e,#3b82f6);
  color:#000;
  font-weight:600;
}
</style>

</body>
</html>
