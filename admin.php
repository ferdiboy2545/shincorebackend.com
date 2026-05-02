<?php
session_start();

if(!isset($_SESSION['admin'])){
header("Location: login.php");
exit;
}

include "config.php";

$search = isset($_GET['search']) ? $_GET['search'] : '';

if($search != ''){
$data = mysqli_query($conn,"
SELECT * FROM orders
WHERE player_id LIKE '%$search%'
OR game LIKE '%$search%'
OR payment LIKE '%$search%'
OR diamond LIKE '%$search%'
ORDER BY id DESC
");
}else{
$data = mysqli_query($conn,"SELECT * FROM orders ORDER BY id DESC");
}

$total = mysqli_query($conn,"SELECT SUM(price) as income FROM orders WHERE status='Success'");
$rowTotal = mysqli_fetch_assoc($total);
$income = $rowTotal['income'] ? $rowTotal['income'] : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Admin Shincore</title>

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
background:#0b1220;
color:white;
font-family:sans-serif;
padding:15px;
}

.container{
max-width:1400px;
margin:auto;
}

h1{
color:#f5c542;
text-align:center;
margin-bottom:20px;
font-size:28px;
}

.search-box{
display:flex;
gap:10px;
flex-wrap:wrap;
justify-content:center;
margin-bottom:20px;
}

.search-box input{
padding:12px;
width:300px;
max-width:100%;
border:none;
border-radius:8px;
outline:none;
}

.search-box button,
.search-box a{
padding:12px 16px;
border:none;
border-radius:8px;
font-weight:bold;
text-decoration:none;
cursor:pointer;
font-size:14px;
}

.search-box button{
background:#f5c542;
color:black;
}

.search-box a{
background:red;
color:white;
}

.card{
background:#111827;
padding:18px;
border-radius:12px;
margin-bottom:20px;
text-align:center;
border:1px solid rgba(245,197,66,0.2);
}

.card h2{
color:#f5c542;
font-size:22px;
margin-bottom:10px;
}

.card p{
font-size:28px;
font-weight:bold;
color:lime;
}

.card small{
color:#aaa;
font-size:13px;
}

.table-wrap{
overflow-x:auto;
border-radius:12px;
}

table{
width:100%;
min-width:1000px;
border-collapse:collapse;
background:#111827;
overflow:hidden;
}

th,td{
padding:12px;
border-bottom:1px solid #222;
text-align:center;
font-size:14px;
white-space:nowrap;
}

th{
background:#f5c542;
color:black;
}

tr:hover{
background:#1f2937;
}

.pending{
color:orange;
font-weight:bold;
}

.success{
color:lime;
font-weight:bold;
}

.btn{
padding:7px 12px;
color:white;
text-decoration:none;
border-radius:7px;
font-size:12px;
font-weight:bold;
display:inline-block;
}

.green{
background:limegreen;
}

.red{
background:red;
}

@media(max-width:768px){

body{
padding:10px;
}

h1{
font-size:22px;
}

.search-box{
flex-direction:column;
align-items:stretch;
}

.search-box input,
.search-box button,
.search-box a{
width:100%;
text-align:center;
}

.card h2{
font-size:18px;
}

.card p{
font-size:22px;
}

th,td{
font-size:12px;
padding:10px;
}

}

@media(max-width:480px){

h1{
font-size:18px;
}

.card{
padding:15px;
}

.card p{
font-size:18px;
}

}

.topbar{
display:flex;
justify-content:space-between;
align-items:center;
gap:10px;
margin-bottom:20px;
background:#111827;
padding:12px 15px;
border-radius:14px;
border:1px solid rgba(245,197,66,.15);
width:100%;
overflow:hidden;
}

.brand{
display:flex;
align-items:center;
gap:10px;
min-width:0;
flex:1;
}

.brand img{
width:42px;
height:42px;
object-fit:contain;
flex-shrink:0;
}

.brand-text{
min-width:0;
overflow:hidden;
}

.brand-text h1{
margin:0;
font-size:22px;
color:#f5c542;
font-weight:900;
line-height:1;
white-space:nowrap;
overflow:hidden;
text-overflow:ellipsis;
}

.brand-text p{
margin:2px 0 0;
font-size:11px;
color:#fff;
letter-spacing:1px;
font-weight:bold;
white-space:nowrap;
}

.logout-btn{
padding:9px 14px;
background:red;
color:white;
text-decoration:none;
border-radius:8px;
font-weight:bold;
font-size:13px;
white-space:nowrap;
flex-shrink:0;
}

/* HP KECIL */
@media(max-width:480px){

.topbar{
padding:10px;
}

.brand img{
width:36px;
height:36px;
}

.brand-text h1{
font-size:18px;
}

.brand-text p{
font-size:9px;
}

.logout-btn{
padding:8px 10px;
font-size:12px;
}

}
</style>

</head>
<body>

<div class="container">

<div class="topbar">

<div class="brand">
<img src="logo.png">

<div class="brand-text">
<h1>SHINCORE</h1>
<p>ADMIN PANEL</p>
</div>
</div>

<a href="logout.php" class="logout-btn">Logout</a>

</div>


</div>

<form method="GET" class="search-box">

<input type="text" name="search" placeholder="Cari ID / Game / Payment"
value="<?= $search; ?>">

<button>Cari</button>

<a href="admin.php">Reset</a>

</form>

<div class="card">
<h2>💰 TOTAL INCOME</h2>
<p>Rp <?= number_format($income); ?></p>
<small>Hanya dari pesanan Success</small>
</div>

<div class="table-wrap">
<table>

<tr>
<th>ID</th>
<th>Game</th>
<th>Player</th>
<th>Diamond</th>
<th>Payment</th>
<th>Harga</th>
<th>Status</th>
<th>Aksi</th>
<th>Hapus</th>
<th>Tanggal</th>
</tr>

<?php while($row=mysqli_fetch_assoc($data)){ ?>

<tr>
<td><?= $row['id']; ?></td>
<td><?= $row['game']; ?></td>
<td><?= $row['player_id']; ?></td>
<td><?= $row['diamond']; ?></td>
<td><?= $row['payment']; ?></td>
<td>Rp <?= number_format($row['price']); ?></td>

<td class="<?= strtolower($row['status']); ?>">
<?= $row['status']; ?>
</td>

<td>
<?php if($row['status']=="Pending"){ ?>
<a href="approve.php?id=<?= $row['id']; ?>" class="btn green">
Approve
</a>
<?php } else { ?>
✔️ Done
<?php } ?>
</td>

<td>
<a href="hapus.php?id=<?= $row['id']; ?>"
onclick="return confirm('Yakin hapus order ini?')"
class="btn red">
Hapus
</a>
</td>

<td><?= $row['created_at']; ?></td>
</tr>

<?php } ?>

</table>
</div>

</div>

<script>
let lastCount = <?= mysqli_num_rows($data); ?>;
let soundOn = false;

/* tombol aktifkan suara */
const btn = document.createElement("button");
btn.innerText = "🔔 ORDER MASUK";

btn.style.position = "fixed";
btn.style.bottom = "20px";
btn.style.right = "20px";
btn.style.padding = "12px 16px";
btn.style.background = "#f5c542";
btn.style.color = "black";
btn.style.border = "none";
btn.style.borderRadius = "10px";
btn.style.fontWeight = "bold";
btn.style.cursor = "pointer";
btn.style.zIndex = "9999";
btn.style.boxShadow = "0 0 15px rgba(0,0,0,0.3)";

document.body.appendChild(btn);

/* aktifkan suara */
btn.onclick = function(){

let audio = new Audio("notif.mp3");
audio.play();

soundOn = true;

btn.innerText = "✅ Suara Aktif";
btn.style.background = "limegreen";

setTimeout(()=>{
btn.style.display = "none";
},1500);

};

/* cek order baru */
setInterval(function(){

fetch("count.php")
.then(res => res.text())
.then(total => {

if(parseInt(total) > lastCount){

if(soundOn){
let audio = new Audio("notif.mp3");
audio.play();
}

lastCount = parseInt(total);
location.reload();

}

});

},5000);
</script>

</body>
</html>