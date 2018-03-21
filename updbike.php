<?php
$link = mysqli_connect("localhost", "root", "root", "rental");
 
	if($link == false){ 
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	if(isset($_COOKIE['choosedbike']) && $_COOKIE['choosedbike'] != ""){
		$bike=$_COOKIE['choosedbike'];
		$sql="delete from bikes where bid = '$bike'";
		mysqli_query($link,$sql); ?>
		<script>document.cookie = "choosedbike=;expires=Thu, 01 Jan 1970 00:00:01 GMT;";</script>
	<?php }
?>
<html>
<head>
<title>Update Bike</title>
<style>
#search{
	width:100%;
	height:90px;
	padding-left:32px;
	padding-right:32px;
	display:inline-block;
}
#result{
	width:100%;
	height:auto; 
	overflow:auto;
	padding:40px 40px;
}
.choose{
	cursor:pointer;
}
</style>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<link rel="stylesheet" type="text/css" href="bikecss.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<div id="container">
 <div id="header" class="bgimage">
 <center><h1>KCRM</h1></center>
 </div>
 <div id="search" class="bgimage">
 <form  method="get" action="delbike.php" style="display:inline-block; float:left;">
	<input type="text" placeholder="Search..." name="bname" style="width:500px; float:left;" <?php if(isset($_GET['search'])){ ?> value=<?php echo $_GET['bname']; }?>>&nbsp;
	<button class="mybutton" type="submit" name="search"style="width:auto; height:47px; background-color:black; padding-top:4"><i class="fa fa-search" aria-hidden="true" style="font-size:36px"></i></button>
 </form>
     <button id="back" class="myfont mybutton" onclick="location.href='admin.php'" style="background-color:#203264; width:auto; float:right; margin-right:50px;"><i class="fa fa-angle-double-left"></i>&nbsp;Back</button>
</div>
<script>
 $(document).on("click",".choose", function(){
   if(confirm("Are you sure you want to delete this bike?")){
    document.cookie = "choosedbike = " + $(this).attr('id');
	window.location.href = "delbike.php";
   }
 });
</script>
 <div id="result">
 <?php
  if(isset($_GET['search'])){
		$bike=strtolower(preg_replace('/\s+/', '', $_GET['bname']));
		$sql="select * from bikes where lower(replace(name,' ','')) like '%" . $bike . "%' order by price";
		$result = mysqli_query($link,$sql);
		if($result){
		while($row = mysqli_fetch_array($result)){
        ?>
		<script>
		$('#result').append('<div id="element" style="height:340px">'+
								'<div id=<?php echo $row['bid']?> class="choose">'+
								'<img src=<?php echo $row['photo'] ?> class="bike-img">'+
								'<p class="bike-desc" style="font-size:18px;"><?php echo $row['name'] ?></p>'+
								'<div id="price">'+
									'<p class="bike-desc"><?php echo $row['price']?>/-</p>'+
									'<p class="bike-desc" style="color:#a9afb6;">per day</p>'+
								'</div>'+
								'</div>'+
								'</div>');
		</script>
		<?php
		}
		}
	}
	?>
 </div>
</div>
</body>
</html>