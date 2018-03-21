<?php
session_start();
$_SESSION['logout']=0;
$link = mysqli_connect("localhost", "root", "root", "rental");
 
	if($link == false){ 
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
if(isset($_POST['upload']))
{
	    include "imagevalidation.php";
		if($_FILES["propic"]["error"] != 4) {
			$propic = uploadImage("propic", "uploads/");
			$sql= "UPDATE profiles SET profilepic='$propic' WHERE email='".$_SESSION['email']."'";
			$result=mysqli_query($link,$sql);
		}
		if($_FILES["lipic"]["error"] != 4) {
			$lipic = uploadImage("lipic", "uploads/");
			$sql= "UPDATE profiles SET license='$lipic' WHERE email='".$_SESSION['email']."'";
			$result=mysqli_query($link,$sql);
		}
		if($_FILES["aapic"]["error"] != 4) {
			$aapic = uploadImage("aapic", "uploads/");
			$sql= "UPDATE profiles SET aadhar='$aapic' WHERE email='".$_SESSION['email']."'";
			$result=mysqli_query($link,$sql);
		}
}	
?>
<html>
<head>
<title>My Profile</title>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<link rel="stylesheet" type="text/css" href="profilecss.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<div id="container">
 <div id="header" class="profilebgimage">
 <center><h1>KCRM</h1></center>
 </div>
 <script>
$(document).ready(function() {
  var stickyNavTop = $('#navbar').offset().top;

  var stickyNav = function(){
    var scrollTop = $(window).scrollTop();

    if (scrollTop > stickyNavTop) { 
      $('#navbar').addClass('sticky');
    } else {
      $('#navbar').removeClass('sticky'); 
    }
  };

  stickyNav();

  $(window).scroll(function() {
    stickyNav();
  });
 
  $(document).on('click', 'a[href^="#"]', function (event) {
    event.preventDefault();

    $('html, body').animate({
        scrollTop: $($.attr(this, 'href')).offset().top
    }, 500);
});
});
</script>
 <div id="navbar" class="profilebgimage">
  <ul>
  <li><a href="home.php">Home</a></li>
  <?php
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
	  $sql= "SELECT profilepic FROM profiles WHERE email='".$_SESSION['email']."'";
	  $result = mysqli_query($link,$sql);
	  $profilepic = mysqli_fetch_array($result);
  ?>
  <div class="user">
  <li><img src = <?php echo $profilepic[0] ?> class="userimage">&nbsp;<?php echo $_SESSION['username']?>&nbsp;<i class="fa fa-caret-down"></i></li>
  <div class="dropdown-content">
    <a href="profile.php">My Profile</a>
    <a href="#">My Bookings</a>
    <a href="logout.php">Logout</a>
  </div>
  </div>
  <?php
  }
  else{
  ?>
  <li><a onclick="document.getElementById('dropscreen').style.display='block'" style="width:auto; float:right; cursor:pointer;">Login</a></li>
  <?php 
  }
  ?>
  </ul>
 </div>
 <div id="profilebody">
 <button class="myfont backbutton"><i class="fa fa-angle-double-left"></i>&nbsp;Back</button>
 <br><br>
 <form id="form" method="post" action="profile.php" enctype="multipart/form-data">
 <?php
	$link = mysqli_connect("localhost", "root", "root", "rental");
 
		if($link == false){ 
			die("ERROR: Could not connect. " . mysqli_connect_error());
			}
		$result = mysqli_query($link,"select * from profiles where email='".$_SESSION['email']."'"); 
		$row = mysqli_fetch_array($result);
  ?>
 <h1>Profile Photo</h1><br>
  <div id="profilepic">
   <img src=<?php echo $row['profilepic']?> height="240px" width="240px">
  </div>
  <br>
  <input type="file" name="propic" accept="image/*">
  <br><br>
  <h1>Driving License</h1>
  <div id="license">
  <img src=<?php echo $row['license']?> class="def" height="240px" width="240px">
  </div>
  <br>
  <input type="file" name="lipic" accept="image/*">
  <br><br>
   <h1>Aadhar Card</h1>
  <div id="aadhar">
  <img src=<?php echo $row['aadhar']?> class="def" height="240px" width="240px">
  </div>
  <br>
  <input type="file" name="aapic" accept="image/*">
  <br><br><br>
  <input type="submit" class="mybutton myfont" name="upload" value="Submit" style="width:100px; background-color:black;">
  <br><br>
 </form>
 </div>
 </div>
</body>
</html>
