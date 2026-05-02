<?php
include "config.php";

$json = file_get_contents("php://input");
$data = json_decode($json, true);

$order_id = $data['order_id'];
$status = $data['transaction_status'];
$midtrans_id = $data['transaction_id'];

if($status == "settlement"){

    mysqli_query($conn, "
    UPDATE orders 
    SET status='success',
    midtrans_transaction_id='$midtrans_id'
    WHERE order_id='$order_id'
    ");

} else {

    mysqli_query($conn, "
    UPDATE orders 
    SET status='$status',
    midtrans_transaction_id='$midtrans_id'
    WHERE order_id='$order_id'
    ");

}
?>