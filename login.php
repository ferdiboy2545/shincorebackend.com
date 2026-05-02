<?php
session_start();

if(isset($_POST['login'])){
$user = $_POST['username'];
$pass = $_POST['password'];

if($user=="admin" && $pass=="12345"){
$_SESSION['admin']=true;
header("Location: admin.php");
exit;
}else{
$error="Login gagal!";
}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login Admin</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
body{
margin:0;
background:#0b1220;
font-family:sans-serif;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
color:white;
}
.box{
background:#111827;
padding:30px;
border-radius:15px;
width:320px;
box-shadow:0 0 20px rgba(0,0,0,.4);
}
h2{
text-align:center;
color:#f5c542;
}
input{
width:100%;
padding:12px;
margin:8px 0;
border:none;
border-radius:8px;
}
button{
width:100%;
padding:12px;
border:none;
border-radius:8px;
background:#f5c542;
font-weight:bold;
cursor:pointer;
}
p{
color:red;
text-align:center;
}
</style>
</head>
<body>

<div class="box">
<h2>🔥 LOGIN ADMIN</h2>

<?php if(isset($error)){ ?>
<p><?= $error; ?></p>
<?php } ?>

<form method="POST">
<input type="text" name="username" placeholder="Username">
<input type="password" name="password" placeholder="Password">
<button name="login">MASUK</button>
</form>
</div>

</body>
</html>