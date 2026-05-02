<?php
include "config.php";

$id = $_GET['id'];

mysqli_query($conn,"UPDATE orders SET status='Success' WHERE id='$id'");

header("Location: admin.php");
?>