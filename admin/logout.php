<?php
session_start();
session_destroy();
// Sesuaikan arah redirect ke halaman login utama kamu (misal di luar folder admin)
header("Location: ../login-admin.php"); 
exit();
?>