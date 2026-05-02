<?php
include "config.php";

$data = mysqli_query($conn,"SELECT id FROM orders");
echo mysqli_num_rows($data);
?>