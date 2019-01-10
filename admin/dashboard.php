<?php
ob_start();
session_start();



if(isset($_SESSION['us'])){
	$pageTitle = 'Dashboard';
   	include 'init.php';

   	/* Start Dashboard */
?>
    <div class="home-stat">
	    <div class="container text-center">
	    	<h1>Dashboard</h1>
	    	<div class="row">
	    		<div class="col-md-3">
	    			<div class="stat st-members">
	    				<i class="fa fa-users"></i>
						<div class="info">
							Total Members
						     <span>
						     	<a href="members.php"><?php echo countItems('UserId','users') ?></a>
						     </span>
						</div>
	    		    </div>
	    		</div>
	    		<div class="col-md-3">
	    			<div class="stat st-pending">
	    				<i class="fa fa-user-plus"></i>
		    			
		    			<div class="info">
		    				Pending Members
			    			<span>
			    				<a href="members.php?do=Manage&page=Pending">
			    				     <?php echo checkItem('RegStatus','users',0)?></a>
			    		    </span>
		    		    </div>
	    		    </div>
	    		</div>
	    		<div class="col-md-3">
	    			<div class="stat st-items">
	    				<i class="fa fa-tag"></i>
	    				<div class="info">
			    			Total Items
			    			<span>
			    				<a href="items.php"><?php echo countItems('Item_ID','items') ?></a>
			    		    </span>
			    		</div>
	    		    </div>
	    		</div>
	    		<div class="col-md-3">
	    			<div class="stat st-comments">
	    				<i class="fa fa-comments"></i>
	    				<div class="info">
		    				Total Comments
			    			<span>
			    				<a href="comments.php"><?php echo countItems('C_id','comments') ?></a>
			    		    </span>
		    		    </div>
	    			</div>
	    		</div>
	    	</div>
	    </div>
    </div>

    <div class="container latest">
	    <div class="container latest">
	    	<div class="row">
	    		<div class="col-sm-6">
	    			<div class="panel panel-default">
	    				<?php $numUsers = 4; ?>
	    				<div class="panel-heading">
	    					<i class="fa fa-users"></i> Latest <?php echo $numUsers?> Registered Users
	    					<span class="toggle-info pull-right">
	    						<i class="fa fa-plus fa-lg"></i>
	    					</span>
	    				</div>
	    				<div class="panel-body">
		    				  <ul class="list-unstyled latest-users">
		<?php
			                        $theLatestUsers = getLatest("*", "users", "UserID", $numUsers);
			                        if(!empty($theLatestUsers)){
				                        foreach ($theLatestUsers as $user) {
				                        	echo '<li>';
				                        	    echo $user['Username'];
				                        	    echo '<a href="members.php?do=Edit&userid='.$user['UserID'].'">';
				                        	    echo  "<span class='btn btn-success pull-right'>";
				                        	        echo '<i class="fa fa-edit"></i> Edit';
				                        	        if($user['RegStatus'] == 0){
														echo "<a href='members.php?do=Activate&userid=" . 
														     $user['UserID'] . "' class='btn btn-info activate pull-right'>
														     <i class='fa fa-close'></i> Activate </a>";
													}
													echo "<a href='members.php?do=Delete&userid=" .
													       $user['UserID'] . "' class='btn btn-danger confirm pull-right'>
													       <i class='fa fa-close'></i> Delete </a>";
				                        	    echo '</span>';
				                        	    echo '</a>';
				                        	echo '</li>'; 
				                        }
			                        }else{
			                        	echo 'Ther\'s No Users To Show';
			                        }
		?>                         
		                      </ul>
	    				</div>
	    				
	    			</div>
	    		</div>

	    		<div class="col-sm-6">
	    			<div class="panel panel-default">
	    				<?php $numItems = 4; ?>
	    				<div class="panel-heading">
	    					<i class="fa fa-tag"></i> Latest <?php echo $numItems; ?> Items
	    					<span class="toggle-info pull-right">
	    						<i class="fa fa-plus fa-lg"></i>
	    					</span>
	    				</div>
	    				<div class="panel-body">
	    					<ul class="list-unstyled latest-users">
<?php
	    						$theLatestItems = getLatest("*", "items", "Item_ID", $numItems);
	    						if(!empty($theLatestItems)){
		    						foreach ($theLatestItems as $item) {
		    						 	echo '<li>';
				                        	    echo $item['Name'];
				                        	    echo '<a href="items.php?do=Edit&itemid='.$item['Item_ID'].'">';
				                        	    echo  "<span class='btn btn-success pull-right'>";
				                        	        echo '<i class="fa fa-edit"></i> Edit';
				                        	        if($item['Approve'] == 0){
														echo "<a href='items.php?do=Approve&itemid=" . 
														     $item['Item_ID'] . "' class='btn btn-info activate pull-right'>
														     <i class='fa fa-check'></i> Approve </a>";
													}
													echo "<a href='items.php?do=Delete&itemid=" .
													       $item['Item_ID'] . "' class='btn btn-danger confirm pull-right'>
													       <i class='fa fa-close'></i> Delete </a>";
				                        	    echo '</span>';
				                        	    echo '</a>';
				                        	echo '</li>'; 
				                        }
				                    }else{
				                    	echo 'Ther\'s No Items To Show';
				                    }
?>
	    					</ul>
	    				</div>
	    				
	    			</div>
	    		</div>
	    	</div>


    	<!-- start latest comments row -->
	    	<div class="row">
	    		<div class="col-sm-6">
	    			<div class="panel panel-default">
	    				<?php $numComments= 4; ?>
	    				<div class="panel-heading">
	    					<i class="fa fa-comments-o"></i> Latest <?php echo $numComments;?> Comments
	    					<span class="toggle-info pull-right">
	    						<i class="fa fa-plus fa-lg"></i>
	    					</span>
	    				</div>
	    				<div class="panel-body">
<?php
								$stmt = $con->prepare("SELECT comments.*, users.Username AS Member FROM comments INNER JOIN users ON users.UserID = comments.User_id
									ORDER BY C_id DESC LIMIT $numComments");
								$stmt->execute();
								$comments = $stmt->fetchAll();
								if(!empty($comments)){
									foreach ($comments as $comment) {
										echo "<div class='comment-box'>";
										      echo "<a style='text-decoration:none' href='members.php?do=Edit=".$comment['User_id']."'  class='member-n'>".$comment['Member'] ."</a>";
										      echo "<p class='member-c'>".$comment['Comment'] ."</p>";
										echo "</div>";
									}
							    }else{
							    	echo 'Ther\'s No Comments To Show';
							    }
								
?>
	    				</div>
	    				
	    			</div>
	    		</div>
	    <!-- end latest comments row -->
	    </div>
    </div>
<?php
   	/* End Dashboard */
   	include $templ .'footer.php';
}else {
	header('Location:index.php');
	exit();
}
ob_end_flush();