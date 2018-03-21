<?php
	session_start();
	$_SESSION['logout']=1;
	$link = mysqli_connect("localhost", "root", "root", "rental");
 
	if($link == false){ 
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	if(isset($_POST['login']))
	{
		$email=($_POST['email']);
		$password=md5($_POST['password']);
		$sql= "SELECT * FROM customers WHERE email='$email' AND password='$password'";
		$result=mysqli_query($link,$sql);
		$count=mysqli_num_rows($result);
		if($count >= 1){
			$row = mysqli_fetch_array($result);
			session_start();
			$_SESSION['loggedin'] = true;
			$_SESSION['email']=$email;
			$_SESSION['username']=$row['username'];
			header("Location:home.php");
			exit();
		}
		else{
			echo "<script type='text/javascript'>alert('Invalid username or password' . $count)</script>";
		}
	}
	else 
	{
	if(isset($_POST['signup']) && ($_POST["password"] ===  $_POST["re-password"]))
	{
		session_start();
		$username=($_POST['username']);
		$password=md5($_POST['password']);
		$email=($_POST['mail']);
		$sql="INSERT INTO customers(email,username,password)
        VALUES('$email','$username','$password')";
		if(mysqli_query($link, $sql)){
		  $sql="INSERT INTO profiles values('$email', 'img/user.png', 'img/defimg.png', 'img/defimg.png')";
		  if(mysqli_query($link, $sql)){
			$_SESSION['loggedin']=true;
			$_SESSION['username']=$username;
			$_SESSION['email']=$email;
			header("Location:home.php");
			exit();
		  }
		}
		else{
			echo "<script type='text/javascript'>alert('Username already exists')</script>";
		}
	}
	}
?>
<html>
<head>
<title>Vehicle Rentals</title>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<div id="container">
 <div id="header" class="bgimage">
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
 <div id="navbar" class="bgimage">
  <ul>
  <li><a href="#header">Home</a></li>
  <li><a href="#about">About Us</a></li>
  <li><a href="#location">Location</a></li>
  <li><a href="#contact">Contact Us</a></li>
  <?php
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
	$sql= "SELECT profilepic FROM profiles WHERE email='".$_SESSION['email']."'";
	$result = mysqli_query($link,$sql);
	$profilepic = mysqli_fetch_array($result);
  ?>
  <div class="user">
  <li><img src=<?php echo $profilepic[0] ?> class="userimage">&nbsp;<?php echo $_SESSION['username']?>&nbsp;<i class="fa fa-caret-down"></i></li>
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
 <div id="homebody">
 <div id="home" class="bgimage">
 <div id="navigation-icons">
 <button id="bike-button" onclick="location.href='bike.php';"><img src="img/bike.png" height="100px" width="100px"></button>
 <button id="car-button" onclick="location.href='student.php';"><img src="img/car.png" height="100px" width="100px"></button>
 </div>
 </div>
 <div id="about">
  <h1>About Us</h1>
 </div>
 <div id="gap" class="bgimage"></div>
 <div id="location">
  <h1>Location</h1>
  <div id="map">
  <script>
	function myMap() {
		 var pos = {lat: 17.7291872, lng: 83.3033571};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: pos
        });
        var marker = new google.maps.Marker({
          position: pos,
          map: map
        });
	}
   </script>
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJH_BczuTHw77LKzyPvnhSEL5Zigip1OQ&callback=myMap"></script>
  </div>
 </div>
 <div id="gap" class="bgimage"></div>
 <div id="contact">
  <h1>Contact Us</h1>
  <div>
  <img src="img/img1.jpg" width="210px" height="240px">
  </div>
  <div id="contact-details">
    <img src="img/phone-icon.png" height="18px" width="18px" style="float:left"><p>+91&nbsp;9121730961</p>
	<img src="img/whatsapp-icon.png" height="18px" width="18px" style="float:left"><p>&nbsp;+91&nbsp;8886275797</p>
	<img src="img/mail-icon.png" height="18px" width="18px" style="float:left"><p>&nbsp;saichaitanya080@gmail.com</p>
	<img src="img/address-icon.png" height="18px" width="18px" style="float:left"><p>&nbsp;3rd&nbsp;Lane,&nbsp;Diamond&nbsp;Park,&nbsp;Visakhapatnam.&nbsp;530016</p>

	</div>
 </div>
 </div>
</div>
<!--Login form-->
 <div id="dropscreen" class="modal" style="display:none;">
 <div  id="card" class="modal-content animate">
  <div id="login">
    <div class="imgcontainer">
      <span onclick="document.getElementById('dropscreen').style.display='none'" class="close" title="Close">&times;</span>
      <img src="img/loginavatar.png" alt="Avatar" class="avatar">
    </div>
    <div class="formcontainer">
	<form action="home.php" method="post">
      <input type="text" placeholder="Email ID" name="email" required style="width: 600px;">
		<br></br>
      <input type="password" placeholder="Password" name="password" required style="width: 600px;">
        <br></br>
		<label>
        <input type="checkbox" name="remember"> Remember me
      </label>
      <button type="submit" class="myfont mybutton" name="login" style="background-color:#203264">Login</button>
	   </form>
    </div>
	<div class="extrabutton">
  <button id="createnew" class="myfont mybutton" style="background-color:#000">Create New Account</button>
  </div>
  </div>
  </div>
</div>
<!--SignUp form-->
  <div id="dropscreen1" class="modal" style="display:none;">
  <div  id="card" class="modal-content animate"> 
  <div id="signup">
     <div class="imgcontainer">
      <span onclick="document.getElementById('dropscreen1').style.display='none'" class="close" title="Close">&times;</span>
      <img src="img/signupavatar.png" alt="Avatar" class="avatar">
    </div>
    <div class="formcontainer">
	<form action="home.php" method="post">
      <input type="text" placeholder="Username" name="username" required style="width: 600px;">
		<br></br>
	  <input type="text" placeholder="Email ID" name="mail" required style="width: 600px;">
		<br></br>
      <input type="password" placeholder="Password" name="password" required style="width: 600px;">
        <br></br>
		<input type="password" placeholder="Re-enter Password" name="re-password" required style="width: 600px;">
        <br></br>
      <button type="submit" class="myfont mybutton" name="signup" style="background-color:#000">Create New Account</button>
	   </form>
    </div>
	<div class="extrabutton">
  <button id="log" class="myfont mybutton" style="background-color:#203264">Login</button>
  </div>
   </div>
  </div>
  </div>

	
<script>
$('input[type=checkbox]').removeAttr('checked');

var modal = document.getElementById('dropscreen');
var modal1 = document.getElementById('dropscreen1');
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
	if (event.target == modal1) {
        modal1.style.display = "none";
    }
}
var btn = document.getElementById('createnew');
btn.onclick = function() {
	document.getElementById('dropscreen').style.display = 'none';
	document.getElementById('dropscreen1').style.display = 'block';
}
var btn1 = document.getElementById('log');
btn1.onclick = function() {
	document.getElementById('dropscreen1').style.display = 'none';
	document.getElementById('dropscreen').style.display = 'block';
}
</script>
</body>
</html>
