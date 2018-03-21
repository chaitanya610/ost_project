<?php
	$link = mysqli_connect("localhost", "root", "root", "rental");
 
	if($link == false){ 
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	include "imagevalidation.php";
	if(isset($_POST['add']))
	{
		$name=$_POST['bname'];
		$price=intval($_POST['price']);
		$selectedtype = $_POST['type'];
		if($selectedtype == "Economy"){
			$type=0;
		}
		else if($selectedtype == "Premium"){
			$type=1;
		}
		$photo = uploadImage("bikephoto", "img/bikes/");
		$sql= "INSERT INTO bikes(name, photo, price, type) values('$name','$photo','$price','$type')";
		if(mysqli_query($link,$sql)){
			$_POST=array();
		}			
	}
?>
<html>
<head>
<title>Add Bike</title>
<style>

</style>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body class="bgimage">
<div id="dropscreen" class="modal" style="display:block;">
  <div  id="card" class="modal-content">
    <div class="formcontainer">
	<form action="addbike.php" method="post" enctype="multipart/form-data">
	  <p class="myfont" style="color:black;">Photo: </p><input type="file" name="bikephoto" accept="image/*" style="width:600px;"><br><br>
      <input type="text" placeholder="Name" name="bname" required style="width: 600px;" required><br><br>
      <input type="text" placeholder="Price" name="price" required style="width: 600px;" required><br><br>
	  <input type="radio" name="type" value="Economy" required>Economy
	  <input type="radio" name="type" value="Premium">Premium
      <button type="submit" class="myfont mybutton" name="add" style="background-color:black">Add</button>
	</form>
    </div>
	<button id="back" class="myfont mybutton" onclick="location.href='admin.php'" style="background-color:#203264; width:auto; margin-left:32px;"><i class="fa fa-angle-double-left"></i>&nbsp;Back</button>
    <br><br>
  </div>
</div>
</body>
</html>