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
        if(file_exists($filePath)) unlink($filePath); // delete file
        mysqli_query($conn,"DELETE FROM gallery_images WHERE id=$id"); // delete DB row
        $success = "Image deleted successfully";
    }
}
?>


<form method="post" enctype="multipart/form-data">
  <input type="file" name="image" accept="image/*" required>
  <button type="submit" name="upload">Upload</button>
</form>

<?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
<?php if (isset($success)) echo "<p style='color:green'>$success</p>"; ?>

<a href="change-password.php">Change Password</a> |
<a href="logout.php">Logout</a>

<h2>Gallery Images</h2>
<div style="display:flex; flex-wrap:wrap; gap:10px;">
<?php
$result = mysqli_query($conn,"SELECT * FROM gallery_images ORDER BY id DESC");
while($row = mysqli_fetch_assoc($result)){
?>
    <div style="text-align:center; border:1px solid #ccc; padding:10px;">
        <img src="../assets/gallery/<?= $row['image'] ?>" style="width:150px; height:150px; object-fit:cover;">
        <br>
        <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
    </div>
<?php } ?>
</div>

<hr>
<h2>Form Submissions</h2>

<table border="1" cellpadding="8">
  <tr>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Message</th>
    <th>Date</th>
  </tr>

<?php
$enq = mysqli_query($conn, "SELECT * FROM enquiries ORDER BY id DESC");
while ($row = mysqli_fetch_assoc($enq)) {
?>
  <tr>
    <td><?= $row['name'] ?></td>
    <td><?= $row['email'] ?></td>
    <td><?= $row['phone'] ?></td>
    <td><?= $row['message'] ?></td>
    <td><?= $row['created_at'] ?></td>
  </tr>
<?php } ?>
</table>
