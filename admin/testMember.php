<?php
/*
   ====================================================
   ** Manage Members Page
   ** you can Add | Edit | Delete Memebrs Form Here
   ====================================================
*/
session_start();


if(isset($_SESSION['us'])){
	$pageTitle = 'Members';
   	include 'init.php';
   	
   	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


   	// start manage page

    
   	if($do == 'Manage'){ // Manage Members Page

   		

   		//select All The users except admin
   		$stm = $con->prepare('SELECT * FROM users WHERE GroupID != 1');
   		$stm->execute();
   		$records = $stm->fetchAll();

?>
        <h2 class="text-center">Manage Members</h2>
        <div class="container">
	        <div class="table-resposive">
	        	<table class="main-table text-center table table-bordered">
	        		<tr>
	        			<td>#ID</td>
	        			<td>Username</td>
	        			<td>Email</td>
	        			<td>FullName</td>
	        			<td>Registred Date</td>
	        			<td>Control</td>
	        		</tr>
<?php

	        		foreach ($records as $record) {
	        			echo '<tr>';
	        			echo '<td>'.$record['UserID'].'</td>';
	        			echo '<td>'.$record['Username'].'</td>';
	        			echo '<td>'.$record['Email'].'</td>';
	        			echo '<td>'.$record['FullName'].'</td>';
	        			echo '<td>'.$record['Date'].'</td>';
	        			echo "<td>
	        			         <a href='members.php?do=Edit&userid=".$record['UserID']."'
	        			            class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
	        			         <a href='members.php?do=Delete&userid=".$record['UserID']."'
	        			            class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a> 	        				     
	        			     </td>";
	        			echo '</tr>';
	        		}
?>	        		
	        	</table>
	        </div>
	        <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>
	           New Member</a>
        </div>
        


<?php

   	}elseif($do == 'Add'){ // Add New Member

?>
        <h2 class="text-center">Add New Member</h2>
			   <div class="container">
			   	 <form class="form-horizontal" action="?do=Insert" method="POST">
			   	 	<!-- Start Username Field -->
			   	 	<div class="form-group form-group-lg">
			   	 		<label class="col-sm-2 control-label">Username</label>
			   	 		<div class="col-sm-10 col-md-6">
			   	 			<input type="text" name="username" class="form-control" required="required"
			   	 			       placeholder="Username To login Into Shop" autocomplete="off" />
			   	 		</div>
			   	 	</div>
			   	 	<!-- End Username field -->
			   	 	<!-- Start Password Field -->
			   	 	<div class="form-group form-group-lg">
			   	 		<label class="col-sm-2 control-label">Password</label>
			   	 		<div class="col-sm-10 col-md-6">
			   	 			<input type="password" name="password" class="password form-control"
			   	 			        required="required" autocomplete="new-password" 
			   	 			        placeholder="Password Must Be Hard And Complex" /> 
			   	 			<i class="show-pass fa fa-eye fa-2x"></i>
			   	 		</div>
			   	 	</div>
			   	 	<!-- End Password field -->
			   	 	<!-- Start Email Field -->
			   	 	<div class="form-group form-group-lg">
			   	 		<label class="col-sm-2 control-label">Email</label>
			   	 		<div class="col-sm-10 col-md-6">
			   	 			<input type="email" name="email" class="form-control" required="required" placeholder="Email Must Be Valid" />
			   	 		</div>
			   	 	</div>
			   	 	<!-- End Email field -->
			   	 	<!-- Start Fullname Field -->
			   	 	<div class="form-group form-group-lg">
			   	 		<label class="col-sm-2 control-label">Full Name</label>
			   	 		<div class="col-sm-10 col-md-6">
			   	 			<input type="text" name="full" class="form-control" required="required" 
			   	 			       placeholder="Full Name Appear In Your Profile"  />
			   	 		</div>
			   	 	</div>
			   	 	<!-- End Fullname field -->
			   	 	<!-- Start submit Field -->
			   	 	<div class="form-group form-group-lg">
			   	 		<div class="col-sm-offset-2 col-sm-10">
			   	 			<input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
			   	 		</div>
			   	 	</div>
			   	 	<!-- End submit field -->
			   	 </form>
			   </div>
<?php 		

   	}elseif($do == 'Edit'){      // Edit Page

        // check if Get request UserID is numeric & Get the Integr value Of It 
   		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
   		    // select All data depend of $userid
   			$stm = $con->prepare('SELECT * FROM users WHERE UserID =?');
   			$stm->execute(array($userid));
   			$row = $stm->fetch();          // fetch the ata
   			$count = $stm->rowCount();     // row count
   			if($count > 0){      // if there's such id show the form
?>
			   <h2 class="text-center">Edit Member</h2>
			   <div class="container">
			   	 <form class="form-horizontal" action="?do=Update" method="POST">
			   	 	<input type="hidden" name="userid" value="<?php echo $userid ?>">
			   	 	<!-- Start Username Field -->
			   	 	<div class="form-group form-group-lg">
			   	 		<label class="col-sm-2 control-label">Username</label>
			   	 		<div class="col-sm-10 col-md-6">
			   	 			<input type="text" name="username" class="form-control" required="required"
			   	 			       value="<?php echo $row['Username'] ?>" autocomplete="off" />
			   	 		</div>
			   	 	</div>
			   	 	<!-- End Username field -->
			   	 	<!-- Start Password Field -->
			   	 	<div class="form-group form-group-lg">
			   	 		<label class="col-sm-2 control-label">Password</label>
			   	 		<div class="col-sm-10 col-md-6">
			   	 			<input type="hidden" name="oldPassword" value="<?php echo $row['Password']?>">
			   	 			<input type="password" name="newPassword" class="form-control"
			   	 			       autocomplete="new-password" placeholder="Leave Blank If You Dont Want To Change" />
			   	 		</div>
			   	 	</div>
			   	 	<!-- End Password field -->
			   	 	<!-- Start Email Field -->
			   	 	<div class="form-group form-group-lg">
			   	 		<label class="col-sm-2 control-label">Email</label>
			   	 		<div class="col-sm-10 col-md-6">
			   	 			<input type="email" name="email" class="form-control"
			   	 			       value="<?php echo $row['Email'] ?>"  />
			   	 		</div>
			   	 	</div>
			   	 	<!-- End Email field -->
			   	 	<!-- Start Fullname Field -->
			   	 	<div class="form-group form-group-lg">
			   	 		<label class="col-sm-2 control-label">Full Name</label>
			   	 		<div class="col-sm-10 col-md-6">
			   	 			<input type="text" name="full" class="form-control" 
			   	 			       value="<?php echo $row['FullName'] ?>"  />
			   	 		</div>
			   	 	</div>
			   	 	<!-- End Fullname field -->
			   	 	<!-- Start submit Field -->
			   	 	<div class="form-group form-group-lg">
			   	 		<div class="col-sm-offset-2 col-sm-10">
			   	 			<input type="submit" value="Save" class="btn btn-primary btn-lg" />
			   	 		</div>
			   	 	</div>
			   	 	<!-- End submit field -->
			   	 </form>
			   </div>



<?php
		   }else{   // if there is no such id  show error message
		   	echo "<div class='container'>";
		   	    $theMsg =  "<div class='alert alert-danger'>No Such User Id</div>";
		   	    redirectHome($theMsg);
		   	echo "</div>";
		   } 	


   	}elseif ($do == 'Update') {     // Update Page

   		echo "<h2 class='text-center'>Update Member</h2>";
   		echo "<div class='container'>";
			if($_SERVER['REQUEST_METHOD'] == 'POST'){

				// GEt the Variables From Edit Form
				$id    = $_POST['userid']; 
				$user  = $_POST['username'];
				$email = $_POST['email'];
				$full  = $_POST['full'];

				//password Trick
				$pass ='';
				if(empty($_POST['newPassword'])){
					$pass = $_POST['oldPassword'];
				}else{
					$pass =sha1($_POST['newPassword']);
				}

				// validate all inputs
				$formErrors = array();
				if(strlen($user) < 3) {
					$formErrors[] = "Username cann\'t be Less Than 3 Characters";
				}
				if(strlen($user) > 20) {
					$formErrors[] = "Username cann\'t be More Than 4 Characters";
				}
				if(empty($user)) {
					$formErrors[] = "Username cann\'t be empty";
				}
				if(empty($email)) {
					$formErrors[] = "Email cann\'t be empty";
				}
				if(empty($full)) {
					$formErrors[] = "Full Name cann\'t be empty";
				}
				// loop into error array and echo it 
				foreach ($formErrors as $error) {
					echo "<div class='alert alert-danger'>". $error ."</div>"; ;
				}
				if(empty($formErrors)){
					// update the database
					$stm = $con->prepare('UPDATE users SET Username=?, Password=?, Email=?, FullName=?
					                      WHERE UserID=?');
					$stm->execute(array($user, $pass, $email, $full, $id));

					$theMsg= "<div class='alert alert-success'>".$stm->rowCount() .' Records Updated</div>';
					redirectHome($theMsg , 'back');
				}

			}else{
				$theMsg='<div class= "alert alert-danger">Sorry, You Cann\'t Browse This Page Directly
				        </div>';
				redirectHome($theMsg);
			}
		echo "</div>";



   	}/*elseif ($do ='Delete') {  // Delete Page

   		echo "<h2 class='text-center'>Delete Member</h2>";
   		echo "<div class='container'>";
   	        // check if Get request UserID is numeric & Get the Integr value Of It 
   		    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
   		    // select All data depend of $userid
   			//$stm = $con->prepare('SELECT * FROM users WHERE UserID =?');
   			//$stm->execute(array($userid));
   			//$count = $stm->rowCount();
   			$check = checkItem('UserID', 'users', $userid);

   			if($check > 0){
   				$stm = $con->prepare('DELETE FROM users WHERE UserID = :userid');
   				$stm->bindParam(':userid', $userid);
   				$stm->execute();
   				
   					$theMsg= "<div class='alert alert-success'>".$stm->rowCount() .  ' Records Deleted
   					        </div>';
   					redirectHome($theMsg);

   			} else {
   				echo "This ID Not Exist..";
   				redirectHome($theMsg); 
   			}
   		echo "</div>";

   		
   	}*/
   	elseif ($do = 'Insert') { // Inser Page
               
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				echo "<h2 class='text-center'>Insert New Member</h2>";
   		        echo "<div class='container'>";

				// GEt the Variables From Edit Form
				$user  = $_POST['username'];
				$pass  = $_POST['password']; 
				$email = $_POST['email'];
				$full  = $_POST['full'];

				$hashPass = sha1($_POST['password']);

				
				// validate all inputs
				$formErrors = array();
				if(strlen($user) < 3) {
					$formErrors[] = "Username cann\'t be Less Than 3 Characters";
				}
				if(strlen($user) > 20) {
					$formErrors[] = "Username cann\'t be More Than 4 Characters";
				}
				if(empty($user)) {
					$formErrors[] = "Username cann\'t be empty";
				}
				if(empty($pass)) {
					$formErrors[] = "Password cann\'t be empty";
				}
				if(empty($email)) {
					$formErrors[] = "Email cann\'t be empty";
				}
				if(empty($full)) {
					$formErrors[] = "Full Name cann\'t be empty";
				}
				// loop into error array and echo it 
				foreach ($formErrors as $error) {
					echo "<div class='alert alert-danger'>". $error ."</div>"; ;
				}
				if(empty($formErrors)){
					// check if user exist in Database before
					$check = checkItem("Username", "users", $user);
					if($check == 1){
					    $theMsg = "<div class='alert alert-danger'>Sorry This User Is Exist</div>";	
					    redirectHome($theMsg, 'back');				

					}else{
							// insert the database
						$stm = $con->prepare("INSERT INTO users (Username, Password, Email, FullName, Date)
						             Values (:username, :password, :email, :fullname, now()) ");
						$stm->execute(array(':username' => $user,
						                    ':password' => $hashPass,
						                    ':email'    => $email,
						                    ':fullname' => $full));

							$theMsg= "<div class='alert alert-success'>".$stm->rowCount() .' Records Inserted
							     </div>';
							redirectHome($theMsg, 'back');
					}

					
				}

			}else{
				echo "<div class='container'>";
					$theMsg='<div class="alert alert-danger">Sorry, You Cann\'t Browse This Page Directly
					        </div>';
					redirectHome($theMsg , 'back');
			    echo "</div>";
			
			}
		echo "</div>";

   	
   	}


   	include $templ .'footer.php';
}else {
	header('Location:index.php');
	exit();
}

 