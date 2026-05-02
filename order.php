<?php
include "config.php";

$serverKey = "Mid-server-W9fX-JUgksLia453D7FiqaT6";

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

/* 1. SIMPAN ORDER KE DATABASE */
mysqli_query($conn, "
INSERT INTO orders 
(order_id, game, player_id, diamond, payment, price, status)
VALUES 
('$order_id','$game','$player_id','$diamond','$payment','$price','pending')
");

/* 2. SET PAYMENT TYPE */
if($payment == "Bank"){
    $payment_type = "bank_transfer";
    $bank = "bca";
}

/* 3. REQUEST KE MIDTRANS CORE API */
$data = [
  "payment_type" => $payment_type,
  "transaction_details" => [
    "order_id" => $order_id,
    "gross_amount" => (int)$price
  ],
  "bank_transfer" => [
    "bank" => $bank
  ]
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.midtrans.com/v2/charge");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$headers = [
  "Content-Type: application/json",
  "Authorization: Basic " . base64_encode($serverKey . ":")
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);

if(curl_errno($ch)){
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "error",
        "message" => curl_error($ch)
    ]);
    exit;
}

curl_close($ch);

/* kirim ke frontend sebagai JSON valid */
header('Content-Type: application/json');
echo $result;
?>