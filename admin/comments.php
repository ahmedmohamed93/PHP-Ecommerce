<?php
/*
   ====================================================
   ** Manage Comments Page
   ** you can  Edit | Delete | Approve Comments Form Here
   ====================================================
*/
ob_start();

session_start();
$pageTitle = 'Members';

if (isset($_SESSION['us'])) {
	include 'init.php';
		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		// Start Manage Page
	if ($do == 'Manage') { // Manage Members Page

	  
		
		// Select All Users Except Admin 
		$stmt = $con->prepare("SELECT comments.*, users.Username, items.Name FROM comments
		                       INNER JOIN users ON users.UserID = comments.User_id
		                       INNER JOIN items ON items.Item_ID = comments.Item_id 
		                       ORDER BY C_id DESC");
		// Execute The Statement
		$stmt->execute();
		// Assign To Variable 
		$rows = $stmt->fetchAll();

		if(!empty($rows)){

		
	?>

			<h1 class="text-center">Manage Comments</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table manage-members text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Comment</td>
							<td>Item Name</td>
							<td>User Name</td>
							<td>Added Date</td>
							<td>Control</td>
						</tr>
						<?php
							foreach($rows as $row) {
								echo "<tr>";
									echo "<td>" . $row['C_id'] . "</td>";
									echo "<td>" . $row['Comment'] . "</td>";
									echo "<td>" . $row['Name'] . "</td>";
									echo "<td>" . $row['Username'] . "</td>";
									echo "<td>" . $row['Comment_date'] ."</td>";
									echo "<td>
										<a href='comments.php?do=Edit&comid=" . $row['C_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
										<a href='comments.php?do=Delete&comid=" . $row['C_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete 
										</a>";

										if($row['Status'] == 0){
											echo "<a href='comments.php?do=Approve&comid=" .$row['C_id'] . "' class='btn btn-info activate'><i class='fa fa-check'></i> Approve </a>";
										}
									echo "</td>";
								echo "</tr>";
							}
						?>
						
					</table>
				</div>
				
			</div>
<?php
		}else{
			echo "<div class='container'>";
			    echo "<div class='nice-message'>There's Is No Commnets To Show</div>";
			echo "</div>";
	    }
?>

	<?php 
	}elseif ($do == 'Edit') {
			// Check If Get Request userid Is Numeric & Get Its Integer Value
			$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
			// Select All Data Depend On This ID
			$stmt = $con->prepare("SELECT * FROM comments WHERE C_id = ?");
			// Execute Query
			$stmt->execute(array($comid));
			// Fetch The Data
			$row = $stmt->fetch();
			// The Row Count
			$count = $stmt->rowCount();
			// If There's Such ID Show The Form
			if ($count > 0) { ?>

				<h1 class="text-center">Edit Comment</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="comid" value="<?php echo $comid ?>" />
						<!-- Start Comment Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Comment</label>
							<div class="col-sm-10 col-md-6">
								<textarea class="form-control" name="comment"><?php echo $row['Comment'] ?></textarea>
							</div>
						</div>
						<!-- End Comment Field -->
						
						<!-- Start Submit Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save" class="btn btn-primary btn-lg" />
							</div>
						</div>
						<!-- End Submit Field -->
					</form>
				</div>

			<?php
			// If There's No Such ID Show Error Message
			} else {
				echo "<div class='container'>";
				$theMsg = '<div class="alert alert-danger">Theres No Such ID</div>';
				redirectHome($theMsg);
				echo "</div>";
			}


	}elseif ($do == 'Update') { // Update Page
			echo "<h1 class='text-center'>Update Comment</h1>";
			echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				// Get Variables From The Form
				$id 	    = $_POST['comid'];
				$comment 	= $_POST['comment'];
				

				
				
				

				// Update The Database With This Info
				$stmt = $con->prepare("UPDATE comments SET Comment = ? WHERE C_id = ?");
				$stmt->execute(array($comment, $id));
				// Echo Success Message
				$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
				redirectHome($theMsg, 'back');
					
				
			} else {
				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
				redirectHome($theMsg);
			}
			echo "</div>";


	}elseif ($do == 'Delete') { // Delete Member Page
			echo "<h1 class='text-center'>Delete Comment</h1>";
			echo "<div class='container'>";
				// Check If Get Request userid Is Numeric & Get The Integer Value Of It
				$comid= isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
				// Select All Data Depend On This ID
				$check = checkItem('C_id', 'comments', $comid);
				// If There's Such ID Show The Form
				if ($check > 0) {
					$stmt = $con->prepare("DELETE FROM comments WHERE C_id = :zid");
					$stmt->bindParam(":zid", $comid);
					$stmt->execute();
					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
					redirectHome($theMsg, 'back');
				} else {
					$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';
					redirectHome($theMsg);
				}
			echo '</div>';

	}elseif($do == 'Approve'){
		    echo "<h1 class='text-center'>Approve Comment</h1>";
			echo "<div class='container'>";
				// Check If Get Request userid Is Numeric & Get The Integer Value Of It
				$comid= isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
				// Select All Data Depend On This ID
				$check = checkItem('C_id', 'comments', $comid);
				// If There's Such ID Show The Form
				if ($check > 0) {
					$stmt = $con->prepare("UPDATE comments SET Status = 1 WHERE C_id = ?");
					$stmt->execute(array($comid));
					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Activated
					          </div>';
					redirectHome($theMsg, 'back');
				} else {
					$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';
					redirectHome($theMsg);
				}
			echo '</div>';
	}else{
		header('Location:members.php');
	}









	include $templ.'footer.php';

}else {
		header('Location: index.php');
		exit();
}
ob_end_flush();