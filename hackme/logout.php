<?php
setcookie(hackme, "", time() - 3600, '/');
header("Location: index.php");
?>
