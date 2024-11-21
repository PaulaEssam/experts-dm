<?php
include 'connect.php';
// عملت سيشن بوقت بالماينص يعني خرجت من السيشن قبل ما تبدأ, كأني عملت ديستروي
setcookie('admin_id', '', time() - 1 ,'/');
header("Location: ../admin/index.php");

?>