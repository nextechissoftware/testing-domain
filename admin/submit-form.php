<?php
include "../config/db.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../includes/PHPMailer/Exception.php";
require "../includes/PHPMailer/PHPMailer.php";
require "../includes/PHPMailer/SMTP.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $name    = mysqli_real_escape_string($conn, $_POST['name']);
  $email   = mysqli_real_escape_string($conn, $_POST['email']);
  $phone   = mysqli_real_escape_string($conn, $_POST['phone']);
  $message = mysqli_real_escape_string($conn, $_POST['message']);

  mysqli_query($conn,
    "INSERT INTO enquiries (name,email,phone,message)
     VALUES ('$name','$email','$phone','$message')"
  );

  $mail = new PHPMailer(true);

  try {
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "saurabhsb88877@gmail.com";
    $mail->Password = "srpx skix pibe fuok";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom("saurabhsb88877@gmail.com", "Website Enquiry");
    $mail->addAddress("saurabhsb88877@gmail.com");

    $mail->isHTML(true);
    $mail->Subject = "New Enquiry Received";
    $mail->Body = "
      <h3>New Enquiry</h3>
      <p><b>Name:</b> $name</p>
      <p><b>Email:</b> $email</p>
      <p><b>Phone:</b> $phone</p>
      <p><b>Message:</b> $message</p>
    ";

    $mail->send();
  }  catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
    exit;
}

  header("Location: ../thank-you.php");
  exit;
}
