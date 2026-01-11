<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login");
    exit;
}

/* Download enquiries */
if (isset($_GET['download']) && $_GET['download'] === 'enquiries') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=student_enquiries.csv');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['Name','Email','Phone','Message','Date']);
    $q = mysqli_query($conn,"SELECT * FROM enquiries ORDER BY id DESC");
    while($r=mysqli_fetch_assoc($q)){
        fputcsv($out, [$r['name'],$r['email'],$r['phone'],$r['message'],$r['created_at']]);
    }
    fclose($out);
    exit;
}

/* Upload */
if (isset($_POST['upload'])) {
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','webp'];
    if(!in_array($ext,$allowed)){
        $error = "Only JPG, PNG, WEBP allowed";
    } else {
        $name = time().'_'.rand(1000,9999).'.'.$ext;
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/gallery/".$name);
        mysqli_query($conn,"INSERT INTO gallery_images (image) VALUES ('$name')");
        $success = "Image uploaded successfully";
    }
}

/* Delete image */
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
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-slate-900 via-gray-900 to-black text-white min-h-screen flex">

<!-- SIDEBAR -->
<aside class="w-64 fixed inset-y-0 left-0 bg-gradient-to-b from-slate-900 via-gray-900 to-black border-r border-gray-700 flex flex-col">

  <!-- Profile -->
  <div class="p-6 text-center border-b border-gray-700">
    <img src="../assets/logo.jpeg"
         class="w-20 h-20 mx-auto rounded-full border-2 border-yellow-400">
    <h2 class="mt-3 text-sm font-semibold bg-gradient-to-r from-yellow-400 via-green-400 to-blue-400 bg-clip-text text-transparent">
      Shaheed RNS Education Academy
    </h2>
    <p class="text-xs text-gray-400">Admin Panel</p>
  </div>

  <!-- Menu -->
  <nav class="flex-1 p-4 space-y-2 text-sm">
    <button onclick="showSection('dashboard')" class="side-menu active">Dashboard</button>
    <button onclick="showSection('gallery')" class="side-menu">Gallery</button>
    <button onclick="showSection('enquiries')" class="side-menu">Student Enquiries</button>
    <a href="change-password" class="side-menu block">Change Password</a>
  </nav>

  <!-- Logout -->
  <div class="p-4 border-t border-gray-700">
    <a href="logout"
       class="block text-center py-2 rounded-lg bg-gradient-to-r from-red-500 to-pink-500 hover:opacity-90">
      Logout
    </a>
  </div>
</aside>

<!-- MAIN -->
<main class="ml-64 flex-1 p-8 space-y-10">

<?php if(isset($error)): ?>
<div class="bg-red-500/20 border border-red-500 text-red-400 p-3 rounded"><?= $error ?></div>
<?php endif; ?>

<?php if(isset($success)): ?>
<div class="bg-green-500/20 border border-green-500 text-green-400 p-3 rounded"><?= $success ?></div>
<?php endif; ?>

<!-- DASHBOARD -->
<section id="dashboard">
  <h1 class="text-2xl font-bold mb-4 bg-gradient-to-r from-yellow-400 via-green-400 to-blue-400 bg-clip-text text-transparent">
    Dashboard
  </h1>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Upload -->
    <div class="bg-gray-800 p-6 rounded-xl border border-gray-700">
      <h2 class="font-semibold mb-3 text-green-400">Quick Upload</h2>
      <form method="post" enctype="multipart/form-data" class="flex gap-3">
        <input type="file" name="image" required class="flex-1 bg-gray-900 p-2 rounded">
        <button name="upload"
                class="px-5 py-2 rounded font-semibold text-black
                       bg-gradient-to-r from-yellow-400 to-green-400 hover:from-green-400 hover:to-blue-400">
          Upload
        </button>
      </form>
    </div>

    <!-- Enquiry summary -->
    <div class="bg-gray-800 p-6 rounded-xl border border-gray-700">
      <h2 class="font-semibold text-blue-400 mb-2">Total Enquiries</h2>
      <?php
        $r = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM enquiries"));
      ?>
      <p class="text-4xl font-bold text-green-400"><?= $r['total'] ?></p>
    </div>
  </div>
</section>

<!-- GALLERY -->
<section id="gallery" class="hidden space-y-6">
  <h1 class="text-2xl font-bold text-yellow-400">Gallery</h1>

  <form method="post" enctype="multipart/form-data"
        class="bg-gray-800 p-6 rounded-xl border border-gray-700 flex gap-4">
    <input type="file" name="image" required class="flex-1 bg-gray-900 p-2 rounded">
    <button name="upload"
            class="px-6 py-2 rounded font-semibold text-black
                   bg-gradient-to-r from-yellow-400 to-green-400 hover:to-blue-400">
      Upload
    </button>
  </form>

  <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
    <?php
    $res = mysqli_query($conn,"SELECT * FROM gallery_images ORDER BY id DESC");
    while($row=mysqli_fetch_assoc($res)){
    ?>
    <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden">
      <img src="../assets/gallery/<?= $row['image'] ?>" class="h-40 w-full object-cover">
      <a href="?delete=<?= $row['id'] ?>"
         onclick="return confirm('Delete image?')"
         class="block text-center text-red-400 py-2 hover:text-red-300">
        Delete
      </a>
    </div>
    <?php } ?>
  </div>
</section>

<!-- ENQUIRIES -->
<section id="enquiries" class="hidden bg-gray-800 p-6 rounded-xl border border-gray-700">
  <div class="flex justify-between mb-4">
    <h1 class="text-xl font-bold text-blue-400">Student Enquiries</h1>
    <a href="?download=enquiries"
       class="px-4 py-2 rounded font-semibold text-black
              bg-gradient-to-r from-green-400 to-blue-400 hover:opacity-90">
      Download Excel
    </a>
  </div>

  <table class="w-full text-sm">
    <tr class="bg-gray-700">
      <th class="p-2">Name</th><th>Email</th><th>Phone</th><th>Message</th><th>Date</th>
    </tr>
    <?php
    $e = mysqli_query($conn,"SELECT * FROM enquiries ORDER BY id DESC");
    while($row=mysqli_fetch_assoc($e)){
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
</section>

</main>

<script>
function showSection(id){
  document.querySelectorAll("main section").forEach(s=>s.classList.add("hidden"));
  document.getElementById(id).classList.remove("hidden");

  document.querySelectorAll(".side-menu").forEach(m=>m.classList.remove("active"));
  event.target.classList.add("active");
}
</script>

<style>
.side-menu{
  width:100%;
  padding:10px;
  border-radius:8px;
  text-align:left;
  transition:.3s;
}
.side-menu:hover{
  background:linear-gradient(90deg,#22c55e,#3b82f6);
  color:#fff;
}
.side-menu.active{
  background:linear-gradient(90deg,#facc15,#22c55e,#3b82f6);
  color:#000;
  font-weight:600;
}
</style>

</body>
</html>
