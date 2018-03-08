<?php
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
		$row = mysqli_fetch_array($result);
		echo $count;
		if($count == 1){
			session_start();
			$_SESSION['loggedin'] = true;
			$_SESSION['email']=$email;
			$_SESSION['username']=$row['username'];
			header("Location:bike.php");
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
			$_SESSION['loggedin'] = true;
			$_SESSION['username']=$username;
			$_SESSION['email']=$email;
			header("Location:bike.php");
			exit();
		}
		else{
			echo "<script type='text/javascript'>alert('Username already exists')</script>";
		}
	}
	}
?>
<html>
<head>
<title>Bikes</title>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<link rel="stylesheet" type="text/css" href="bikecss.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<div id="container">
 <div id="header" class="bikebgimage">
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
 <div id="navbar" class="bikebgimage">
  <ul>
  <li><a href="home.php">Home</a></li>
  <li><a href="#date">Choose Date</a></li>
  <li><a href="#economy">Economy</a></li>
  <li><a href="#premium">Premium</a></li>
  <?php
  session_start();
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
  ?>
  <div class="user">
  <li><img src="img/user.png" class="userimage">&nbsp;<?php echo $_SESSION['username']?>&nbsp;<i class="fa fa-caret-down"></i></li>
  <div class="dropdown-content">
    <a href="#">My Profile</a>
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
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
  <script>
  $( function() {
    $(".datepicker").datepicker({
		dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true
    });

    $( ".datepicker" ).datepicker({
		onSelect: function(dateText, inst) {
            var today = new Date();
            today = Date.parse(today.getMonth()+1+'/'+today.getDate()+'/'+today.getFullYear());
            var selDate = Date.parse(dateText);
            if(selDate < today) {
                $('.datepicker').val('');
                $(inst).datepicker('show');
            }
        }
	});
	
	$(".timepicker").timepicker({
    timeFormat: 'HH:mm',
    interval: 60,
    minTime: '7:00am',
    maxTime: '9:00pm',
    startTime: '7:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
   });
  } );
  </script>
 <div id="date" class="bikebgimage">
 <div id = "from-date">
  <p class="myfont">From:&nbsp;<input type="text" id="from" class="datepicker"></p>
  </div>
  <div id = "to-date">
  <p class="myfont">To:&nbsp;<input type="text" id="to" class="datepicker"></p>
  </div>
  <div id = "pickuptime">
  <p class="myfont">PickUp Time:&nbsp;<input type="text" id="time" class="timepicker"></p>
  </div>
 </div>
 <div id="economy">
 <h1>Economy Bikes</h1>
 <br>
  <?php
		$link = mysqli_connect("localhost", "root", "root", "rental");
 
		if($link == false){ 
			die("ERROR: Could not connect. " . mysqli_connect_error());
			}
		$result = mysqli_query($link,"select * from bikes where type = 0 order by price;"); ?>
		<?php
		while($row = mysqli_fetch_array($result)){
        ?>
		<script>
		$('#economy').append('<div id="element">'+
								'<img src=<?php echo $row['photo'] ?> class="bike-img">'+
								'<p class="bike-desc" style="font-size:18px;"><?php echo $row['name'] ?></p>'+
								'<div id= <?php echo $row['name']?> class="availability"></div>'+
								'<div id="price">'+
									'<p class="bike-desc"><?php echo $row['price']?>/-</p>'+
									'<p class="bike-desc" style="color:#a9afb6;">per day</p>'+
								'</div>'+
								'</div>');
		$('.availability').addClass('.available');
		</script>
		<?php
		}
		?>
 </div>
 <div id="gap" class="bikebgimage">
 </div>
 <div id="premium">
 <h1>Premium Bikes</h1>
 <br>
 <?php
		$link = mysqli_connect("localhost", "root", "root", "rental");
 
		if($link == false){ 
			die("ERROR: Could not connect. " . mysqli_connect_error());
			}
		$result = mysqli_query($link,"select * from bikes where type = 1 order by price;"); 
		while($row = mysqli_fetch_array($result)){
        ?>
		<script>
		$('#premium').append('<div id="element">'+
								'<img src=<?php echo $row['photo'] ?> class="bike-img">'+
								'<p class="bike-desc" style="font-size:18px;"><?php echo $row['name'] ?></p>'+
								'<div id= <?php echo $row['name']?> class="availability"></div>'+
								'<div id="price">'+
									'<p class="bike-desc"><?php echo $row['price']?>/-</p>'+
									'<p class="bike-desc" style="color:#a9afb6;">per day</p>'+
								'</div>'+
								'</div>');
		</script>
		<?php
		}
		?>
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
	<form action="bike.php" method="post">
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
	<form action="bike.php" method="post">
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