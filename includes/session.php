<?php
require "init.php";

$admin = getAdminInfo($conn);

if (!$admin) {
    header("Location: signin.php");
    exit();
}
?>
