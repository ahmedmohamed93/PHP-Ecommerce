<?php

session_start();
$noNavbar = '';
$pageTitle = 'Login';


if(isset($_SESSION['us'])){
   	header('Location:dashboard.php'); // if found register session and redirect
}
   include 'init.php';


      //check if user coming from http request
   if($_SERVER['REQUEST_METHOD'] === 'POST'){
   	$username   = $_POST['user'];
   	$password   = $_POST['password'];
   	$hashedPass = sha1($password);


   	   // check if the user exist in database
   	$stm =$con->prepare('SELECT UserID, Username, Password FROM users WHERE Username=? AND Password=? AND GroupID=1 LIMIT 1');
   	$stm->execute(array($username , $hashedPass));
      $row   = $stm->fetch();
   	$count = $stm->rowCount();

   	   // check if count >0  this mean the db contain record about this username
   	if($count > 0){
   		$_SESSION['us'] = $username ;      // register session name )(or loggedin)
         $_SESSION['ID'] = $row['UserID'];  // register session id
   		header('Location:dashboard.php'); // if found register session and redirect
   	}
   }
   

?>

	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<h4 class="text-center">Admin Login</h4>
		<input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off" />
		<input class="form-control" type="password" name="password" placeholder="Password" 
		       autocomplete="new-password" />
		<input class="btn btn-primary btn-block" type="submit" value="Login" />
	</form>


<?php   include $templ .'footer.php'; ?>