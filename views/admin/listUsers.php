<?php
$title = 'Youdemy - Admin Dashboard';
ob_start();

foreach ($listUsers as  $user) {
  
    ?>
<div>
    <h1><?=$user["username"]?></h1>
    <p><?=$user["email"]?></p>
    
    </div>
    
    
    <?php
}
$content = ob_get_clean();
include 'views/layout.php';
?>

