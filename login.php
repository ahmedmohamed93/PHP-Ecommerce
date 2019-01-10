<?php 
    ob_start();
    session_start();
    $pageTitle = 'Login';

    if(isset($_SESSION['username'])){
   	   header('Location:index.php'); // if found register session and redirect
       
    }
    include 'init.php';


      //check if user coming from http request
	   if($_SERVER['REQUEST_METHOD'] === 'POST'){

        if(isset($_POST['login'])){
      	   	$user   = $_POST['user'];
      	   	$pass   = $_POST['pass'];
      	   	
      	   	$hashedPass = sha1($pass);


      	   	   // check if the user exist in database
      	   	$stm =$con->prepare('SELECT UserID, Username, Password FROM users WHERE Username=? AND Password=? ');
      	   	$stm->execute(array($user , $hashedPass));
            $get = $stm->fetch();
      	   	$count = $stm->rowCount();

      	   	   // check if count >0  this mean the db contain record about this username
      	   	if($count > 0){
      	   		$_SESSION['username'] = $user ;      // register session name )(or loggedin)
              $_SESSION['uid'] = $_GET['UserID'];      // register session id )(or loggedin)
      	   		header('Location:index.php'); // if found register session and redirect
      	   	}

        }else{
             
            $formErrors = array();
            $username   = $_POST['username'];
            $password   = $_POST['password'];
            $password2  = $_POST['password2'];
            $email      = $_POST['email'];
            

          // username filter
            if(isset($username)){
              $filteredUser = filter_var($username, FILTER_SANITIZE_STRING);
              if(strlen($filteredUser) < 3 ){
                $formErrors[] = "Username Must Br larger Than 2 Characters";
              }
            }

          // password filter
             if(isset($password) && isset($password2)){
              if(empty($password)){
                $formErrors[] = "Sorry , Password Can't Be Empty";
              }
              
              $pass1  = sha1($password);
              $pass2  = sha1($password2);
              if($pass1 !== $pass2 ){
                $formErrors[] = "Sorry , Password Is Not Match";
              }
            }

          //email filter
             if(isset($email)){
              $filteredEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

              if(filter_var($filteredEmail, FILTER_VALIDATE_EMAIL) != true ){  // if email not valide
                $formErrors[] = "Sorry , This Email Is Not Valid";
              }
            }

          // Check If There's No Error Proceed The Update Operation
        if (empty($formErrors)) {
          
          // Check If User Exist in Database
          $check = checkItem("Username", "users", $username);
          if ($check == 1) {
            $formErrors[] = "Sorry , This User Is Exist";
          } else {
              // Insert Userinfo In Database
              $stmt = $con->prepare("INSERT INTO 
                          users(Username, Password, Email, RegStatus, Date)
                        VALUES(:zuser, :zpass, :zmail, 0, now())");
              $stmt->execute(array(
                'zuser' => $username,
                'zpass' => sha1($password),
                'zmail' => $email
              ));
              // Echo Success Message
              $succesMsg = 'Congrats You Are Now Registerd User';
            } 
        }


      }
   }
   

 
?>
<!--*********************************************************************************************-->
   <div class="container login-page">
      <h1 class="text-center">
      	 <span class="selected" data-class="login">Login</span> | <span data-class="signup">SignUp</span>
      </h1>
                   <!-- Login Form -->
   	  <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
   	  	<div class="input-container">
	   	  	<input class="form-control" type="text" name="user" autocomplete="off"
	   	  	       placeholder="Type Your Name" required="required">
   	  	</div>
   	  	<div class="input-container">
	   	  	<input class="form-control" type="password" name="pass" autocomplete="new-password"
	   	  	       placeholder="Type Your Password" required="required">
	   	</div>
   	  	<input class="btn btn-primary btn-block" name="login" type="submit" value="Login">
   	  </form>

<!--*********************************************************************************************-->
                  <!-- SignUp Form -->
   	  <form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

   	  	<div class="input-container">
	   	  	<input class="form-control" type="text" name="username" autocomplete="off" required 
	   	  	       placeholder="Type Your Name" pattern=".{3,15}" title="Username Must be Between 2 & 15 Characters" >
	     	</div>

	   	  <div class="input-container">
	   	  	<input minlength="3" class="form-control" type="password" name="password" 
                 autocomplete="new-password" placeholder="Type a Complex Password" required >
   	  	</div>

   	  	<div class="input-container">
	   	  	<input minlength="3" class="form-control" type="password" name="password2"
                 autocomplete="new-password" placeholder="Type a Password Again" required >
   	  	</div>

   	  	<div class="input-container">
	   	  	<input class="form-control" type="email" name="email"
	   	  	       placeholder="Type a Valid Email">
   	  	</div>
   	  	

   	  	<input class="btn btn-success btn-block" name="signup" type="submit" value="SignUp">
   	  </form>
<!--*********************************************************************************************-->
      <div class="the-errors text-center">
<?php 
      if (!empty($formErrors)) {
        foreach ($formErrors as $error) {
          echo '<div class="msg error">' . $error . '</div>';
        }
      }
      if (isset($succesMsg)) {
        echo '<div class="msg success">' . $succesMsg . '</div>';
      }
?>
  </div>
   </div>
   
  

<?php include $templ .'footer.php'; 
ob_end_flush();
      
?>