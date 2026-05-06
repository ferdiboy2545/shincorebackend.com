<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode([
    "status" => "error",
    "message" => "Akses tidak valid"
  ]);
  exit;
}

include "config.php";

$game      = $_POST['game'];
$player_id = $_POST['player_id'];
$diamond   = $_POST['diamond'];
$payment   = $_POST['payment'];

$priceList = [
  100 => 15000,
  200 => 28000,
  500 => 65000,
  1000 => 120000
];

$price = $priceList[$diamond] ?? 0;

$order_id = "ORDER-" . time() . rand(100,999);

/* SIMPAN KE DATABASE (TANPA MIDTRANS) */
$query = mysqli_query($conn, "
INSERT INTO orders 
(order_id, game, player_id, diamond, payment, price, status)
VALUES 
('$order_id','$game','$player_id','$diamond','$payment','$price','Pending')
");

if($query){
    echo json_encode([
        "status" => "success",
        "message" => "Order berhasil dibuat",
        "order_id" => $order_id
    ]);
}else{
    echo json_encode([
        "status" => "error",
        "message" => "Gagal simpan ke database"
    ]);
}
?>