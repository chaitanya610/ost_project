<?php
	$link = mysqli_connect("localhost", "root", "root", "rental");
 
	if($link == false){ 
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	if(isset($_POST['login']))
	{
		$email=($_POST['email']);
		$password=md5($_POST['password']);
		$sql= "SELECT * FROM admin WHERE email='$email' AND password='$password'";
		$result=mysqli_query($link,$sql);
		$count=mysqli_num_rows($result);
		if($count >= 1){
			header("Location:admin.php");
			exit();
		}
		else{
			echo "<script type='text/javascript'>alert('Invalid username or password' . $count)</script>";
		}
	}
?>
<html>
<head>
<title>Admin</title>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body class="bgimage">
<div id="dropscreen" class="modal" style="display:block; padding-top:25px; overflow:hidden">
 <div  id="card" class="modal-content" >
  <div id="login">
    <div class="imgcontainer">
      <img src="img/adminavatar.png" alt="Avatar" class="avatar">
    </div>
    <div class="formcontainer">
	<form action="adminlogin.php" method="post">
      <input type="text" placeholder="Email ID" name="email" required style="width: 600px;">
		<br></br>
      <input type="password" placeholder="Password" name="password" required style="width: 600px;">
        <br></br>
		<label>
        <input type="checkbox" name="remember"> Remember me
      </label>
      <button type="submit" class="myfont mybutton" name="login" style="background-color:#138B61">Login</button>
	   </form>
    </div>
  </div>
  </div>
</div>
</body>
</html>