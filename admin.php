<?php
  session_start();
  $_SESSION['admin'] = 1;
  ?>
<html>
<head>
<title>Admin</title>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<link rel="stylesheet" type="text/css" href="admincss.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
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
  <li><a>Home</a></li>
  <div id="addvehicle" class="menu">
  <li><a>Add Vehicle</a></li>
  <div class="dropdown-content" id="addmenu" style="left:90; width:100px;">
   <a href="addbike.php">Bike</a>
    <a href="#">Car</a>
  </div>
  </div>
  <div id="delvehicle" class="menu">
  <li><a>Delete Vehicle</a></li>
  <div class="dropdown-content" id="delmenu" style="left:240; width:100px;">
    <a href="delbike.php">Bike</a>
    <a href="#">Car</a>
  </div>
  </div>
  <div id="updvehicle" class="menu">
  <li><a>Update Vehicle</a></li>
  <div class="dropdown-content" id="updmenu" style="left:400; width:100px;">
    <a href="updbike.php">Bike</a>
    <a href="#">Car</a>
  </div>
  </div>
  <li><a>View Profiles</a></li>
  <li style="float:right"><a href="logout.php">Logout</a></li>
  </ul>
  </div>
 <div id="pagebody" class="bgimage">
 </div>
 </body>
 </html>