<?php
  session_start();
  if($_SESSION['logout']) {
	session_destroy();
	header('Location: '.$_SERVER['HTTP_REFERER']);  
} else if(isset($_SESSION['admin'])){
	session_destroy();
    header('Location: adminlogin.php');  
}
else {
	session_destroy();
    header('Location: home.php');  
}
exit;
?>