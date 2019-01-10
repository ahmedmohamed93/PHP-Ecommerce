<?php

session_start();
$pageTitle = 'Profile';

   include 'init.php';

   if(isset($_SESSION['username'])){

   	$stat = $con->prepare('SELECT * FROM users WHERE Username = ?');
   	$stat->execute(array($sessionUser));
   	$info = $stat->fetch();

   	
?>
<h1 class="text-center">My Profile</h1>
<div class="information block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Information</div>
			<div class="panel-body">
				<ul class="list-unstyled">
					<li>
						<i class="fa fa-unlock-alt fa-fw"></i>
						<span>Login Name</span> : <?php echo $info['Username'] ?>
					</li>
					<li>
						<i class="fa fa-envelope-o fa-fw"></i>
						<span>Email</span> : <?php echo $info['Email'] ?>
					</li>
					<li>
						<i class="fa fa-user fa-fw"></i>
						<span>Full Name</span> : <?php echo $info['FullName'] ?>
					</li>
					<li>
						<i class="fa fa-calendar fa-fw"></i>
						<span>Registered Date</span> : <?php echo $info['Date'] ?>
					</li>
					<li>
						<i class="fa fa-tags fa-fw"></i>
						<span>Fav Category</span> :
					</li>
					
				</ul>
				<a class="btn btn-default" href="member.php?do=Edit&userid=<?= $_SESSION['ID'] ?>">Edit Profile</a>
			</div>
		</div>
	</div>
</div>
<div class="my-ads block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Ads</div>
			<div class="panel-body">
				
<?php
                      $allitems = getAllFrom("*" , "items", "WHERE Member_ID = {$info['UserID']}", "", 
                      	            "Item_ID");
                       if(!empty($allitems)){
				            echo '<div class="row">';  
					           foreach ($allitems as $item) {
						       	
						       	echo '<div class="col-sm-6 col-md-3">';
						       	   echo '<div class="thumbnail item-box">';
						       	   if($item['Approve'] == 0){
						       	   	   echo "<span class='approve-status'>Waiting Approval</span>";
						       	   	}
						       	       echo '<span class="price-tag">$'.$item['Price'].'</span>';
						       	       echo '<img class="img-responsive" src="layout/images/user_default.png" alt="">';
						       	       echo '<div class="caption">';
						       	            echo '<h3><a href="item.php?itemid='.$item['Item_ID'].'">'.
						       	                   $item['Name'].'</a></h3>';
						       	            echo '<p>'.$item['Description'].'</p>';
						       	            echo '<div class="date">'.$item['Add_Date'].'</div>';
						       	       echo '</div>';
						       	   echo '</div>';
						       	echo '</div>';
						       }
						    echo '</div>';
					    }else{
					       	echo "Sorry, There's No Ads To Show, Create <a href='newad.php'>New Add</a>";
					    }
		       
?>
	            
			</div>
		</div>
	</div>
</div>
<div id="my-ads" class="my-comments block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">Latest Comments</div>
			<div class="panel-body">
<?php
	        	
				$comments = $allitems = getAllFrom("Comment" , "comments", "WHERE User_id = {$info['UserID']}", "", "C_id");
				if(!empty($comments)){
					foreach ($comments as $comment) {
						echo "<p>". $comment['Comment']. "<p>";
					}
				}else{
					echo "There's No Comment To Show";
				}
?>
			</div>
		</div>
	</div>
</div>
<?php
  }else{
  	header('Location:login.php');
  	exit();
  }
   include $templ .'footer.php';

?>