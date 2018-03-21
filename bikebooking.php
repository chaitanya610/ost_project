<?php
	$link = mysqli_connect("localhost", "root", "root", "rental");
 
	if($link == false){ 
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	session_start();
	$_COOKIE['bikeid']="";
	function noOfDays($from, $to)
	{
		$date1 = new DateTime($from);
		$date2 = new DateTime($to);
		$diff = $date2->diff($date1)->format("%a");
		return $diff;
	}
	if(isset($_GET['booknow']))
	{
		$from=date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['from'])));
		$to=date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['to'])));
		$pickup=$_SESSION['pickup'];
		$email=$_SESSION['email'];
		$bid=$_SESSION['bike'];
		$days = noOfDays($from, $to);
		$sql= "SELECT price FROM bikes WHERE bid='$bid'";
		$result=mysqli_query($link,$sql);
		$price=mysqli_fetch_array($result);
		$sql="insert into bikebookings values('$email','$bid', '$from', '$to', '$pickup', '$price[0]'*'$days')";
		if(mysqli_query($link,$sql) or die(mysqli_error($link))){
			echo "Success";
		}
		else{
			echo "Booking Failed";
		}
	}
?>
<html>
<head>
<title>Admin</title>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<link rel="stylesheet" type="text/css" href="bikecss.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body class="bgimage">
<div id="dropscreen" class="modal" style="display:block; padding-top:25px; overflow:hidden">
 <div  id="card" class="modal-content" style="height:auto">
 <?php 
		 $id=$_SESSION['bike'];
         $sql="select * from bikes where bid='$id'";
		 $result = mysqli_query($link,$sql); 
		 $row = mysqli_fetch_array($result);
    ?>
    <div class="imgcontainer">
      <img src=<?php echo $row['photo'] ?> alt="Avatar" class="bike-img">
    </div>
    <div class="formcontainer">
      <p class="myfont" style="font-size:22px; color:black"><?php echo $row['name'] ?></p>
		<br>
	<div style="display:inline-block">
      <p class="bike-desc" style="font-size:18px; text-align:left; float:left">From: <?php echo $_SESSION['from'] ?></p>
	  <p class="bike-desc" style="font-size:18px; text-align:left; float:left">To: <?php echo $_SESSION['to'] ?></p>
	  <p class="bike-desc" style="font-size:18px; text-align:left; float:left">Pickup Time: <?php echo $_SESSION['pickup'] ?></p>
		<br><br>
		</div>
		<form action="bikebooking.php" method="get">
      <button class="myfont mybutton" name="booknow" style="background-color:#000" type="submit">Book Now</button>
	  </form>
	  <button id="back" onclick="location.href='bike.php'" class="myfont mybutton" style="background-color:#138B61">Back</button>
	  <br><br>
  </div>
  </div>
</div>
</body>
</html>