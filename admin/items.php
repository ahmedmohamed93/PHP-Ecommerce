<?php
/*
   ====================================================
   ** Manage Items Page
   ** you can Add | Edit | Delete ....... Form Here
   ====================================================
*/
ob_start();  // Output Buffering Start

session_start();
$pageTitle = 'Items';

if (isset($_SESSION['us'])) {
	include 'init.php';
		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		
	if ($do == 'Manage') { // Manage items Page


        $stmt = $con->prepare("SELECT items.*, categories.Name AS Category, users.Username FROM items 
								INNER JOIN categories ON categories.ID = items.Cat_ID 
								INNER JOIN users ON users.UserID = items.Member_ID
								ORDER BY Item_ID DESC");
		// Execute The Statement
		$stmt->execute();
		// Assign To Variable 
		$items = $stmt->fetchAll();
		
		if(!empty($items)){
		?>

			<h1 class="text-center">Manage items</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table manage-members text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Item Name</td>
							<td>Description</td>
							<td>Price</td>
							<td>Adding Date</td>
							<td>Country Made</td>
							<td>Category</td>
							<td>Member</td>
							<td>Control</td>
						</tr>
						<?php
							foreach($items as $item) {
								echo "<tr>";
									echo "<td>" . $item['Item_ID'] . "</td>";
									echo "<td>" . $item['Name'] . "</td>";
									echo "<td>" . $item['Description'] . "</td>";
									echo "<td>" . $item['Price'] . "</td>";
									echo "<td>" . $item['Add_Date'] ."</td>";
									echo "<td>" . $item['Country_Made'] ."</td>";
									echo "<td>" . $item['Category'] ."</td>";
									echo "<td>" . $item['Username'] ."</td>";
									echo "<td>
										<a href='items.php?do=Edit&itemid=" . $item['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
										<a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
	                                    if($item['Approve'] == 0){
											echo "<a href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "'
											 class='btn btn-info activate'><i class='fa fa-check'></i> Approve </a>";
										}
										
									echo "</td>";
								echo "</tr>";
							}
						?>
						
					</table>
				</div>
				<a href="items.php?do=Add" class="btn btn-sm btn-primary">
					<i class="fa fa-plus"></i> New Item
				</a>
			</div>
<?php
		}else{
			echo "<div class='container'>";
			    echo "<div class='nice-message'>There's Is No Items To Show</div>";
			    echo '<a href="items.php?do=Add" class="btn btn-sm btn-primary">
					  <i class="fa fa-plus"></i> New Item
				      </a>';
			echo "</div>";
	    }
?>

	<?php 
	    
	}elseif ($do == 'Add') { // Add Page 
?>
            <h1 class="text-center">Add New Item</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="POST">
					<!-- Start Name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="name" class="form-control" 
							required="required" placeholder="Name Of The Item" />
						</div>
					</div>
					<!-- End Name Field -->
					<!-- Start Description Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="description" class="form-control"
							required="required" placeholder="Decribe The Item" />
						</div>
					</div>
					<!-- End Description Field -->
					<!-- Start Price Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Price</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="price" class="form-control" required="required"
							       placeholder="Number To Arrange The Categories" />
						</div>
					</div>
					<!-- End Price Field -->
					<!-- Start Country_Made Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Country</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="country" class="form-control" required="required"
							       placeholder="Country Of Made" />
						</div>
					</div>
					<!-- End Country_Made Field -->

					
					<!-- Start Status Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10 col-md-6">
							<select name="status">
								<option value="0">...</option>
								<option value="1">New</option>
								<option value="2">Like New</option>
								<option value="3">Used</option>
								<option value="4">Very Old</option>
							</select>
						</div>
					</div>
					<!-- End Status Field -->

					<!-- Start Members Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Members</label>
						<div class="col-sm-10 col-md-6">
							<select name="member">
								<option value="0">...</option>
<?php
                                     $users = getAllFrom("*","users","","","UserId","ASC");
                                     foreach ($users as $user) {
                                     	echo "<option value='".$user['UserID']."'>".$user['Username']."</option>";                                    }
?>
							</select>
						</div>
					</div>
					<!-- End Members Field -->


					<!-- Start Categories Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Categories</label>
						<div class="col-sm-10 col-md-6">
							<select name="category">
								<option value="0">...</option>
<?php
                                     $cats = getAllFrom("*","categories","WHERE Parent=0","","ID");
                                     foreach ($cats as $cat) {
                                     	echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
                                     	$childCats=getAllFrom("*","categories","WHERE Parent={$cat['ID']}","","ID");
                                     	foreach ($childCats as $child) {
                                     	  echo "<option value='".$child['ID']."'>--- ".$child['Name']."</option>";
                                     	}
                                     }
?>
							</select>
						</div>
					</div>
					<!-- End Categories Field -->
					<!-- Start tags Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Tags</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="tags" class="form-control" required="required"
							       placeholder="Seperate Tags with Comma (,)" />
						</div>
					</div>
					<!-- End tags Field -->
					
					<!-- Start Submit Field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add Item" class="btn btn-primary btn-lg" />
						</div>
					</div>
					<!-- End Submit Field -->
				</form>
			</div>

<?php 


			
	} elseif ($do == 'Insert') {// Insert Member Page
		// Insert Item Page
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				echo "<h1 class='text-center'>Insert Member</h1>";
				echo "<div class='container'>";
			
				
				// Get Variables From The Form
				$name 	    = $_POST['name'];
				$desc 	    = $_POST['description'];
				$price 	    = $_POST['price'];
				$country 	= $_POST['country'];
				$status     = $_POST['status'];
				$member     = $_POST['member'];
				$category   = $_POST['category'];
				$tags       = $_POST['tags'];

				// Validate The Form
				$formErrors = array();
				
				
				if (empty($name)) {
					$formErrors[] = 'Name Can\'t Be <strong>Empty</strong>';
				}
				if (empty($desc)) {
					$formErrors[] = 'Description Can\'t Be <strong>Empty</strong>';
				}
				if (empty($price)) {
					$formErrors[] = 'Full Name Can\'t Be <strong>Empty</strong>';
				}
				if (empty($country)) {
					$formErrors[] = 'Email Can\'t Be <strong>Empty</strong>';
				}
				if ($status == 0) {
					$formErrors[] = 'You Must Choose The <strong>Status</strong>';
				}
				if ($member == 0) {
					$formErrors[] = 'You Must Choose The <strong>member</strong>';
				}
				if ($category == 0) {
					$formErrors[] = 'You Must Choose The <strong>category</strong>';
				}
				
				
				// Loop Into Errors Array And Echo It
				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}
				// Check If There's No Error Proceed The Update Operation
				if (empty($formErrors)) {
					
					// Check If User Exist in Database
					$check = checkItem("Username", "users", $user);
					if ($check == 1) {
						$theMsg = '<div class="alert alert-danger">Sorry This User Is Exist</div>';
						redirectHome($theMsg, 'back');
					} else {
						// Insert Userinfo In Database
						$stmt = $con->prepare("INSERT INTO 
							                 items(Name, Description, Price, Country_Made,Status, Add_Date, Cat_ID, Member_ID,Tags)
												VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcategory, :zmember, :ztags) ");
						$stmt->execute(array(
							'zname' 	=> $name,
							'zdesc' 	=> $desc,
							'zprice' 	=> $price,
							'zcountry' 	=> $country,
							'zstatus'   => $status,
							'zcategory' => $category,
							'zmember'   => $member,
							'ztags'     => $tags
						));
						// Echo Success Message
						$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
						redirectHome($theMsg, 'back');
					}
				}
			} else {
				echo "<div class='container'>";
				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
				redirectHome($theMsg);
				echo "</div>";
			}
			echo "</div>";
			

	} elseif ($do == 'Edit') { //Edit Page
		// Check If Get Request userid Is Numeric & Get Its Integer Value
			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
			// Select All Data Depend On This ID
			$stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ? ");
			// Execute Query
			$stmt->execute(array($itemid));
			// Fetch The Data
			$item = $stmt->fetch();
			// The Row Count
			$count = $stmt->rowCount();
			// If There's Such ID Show The Form
			if ($count > 0) { ?>

				<h1 class="text-center">Edit Item</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Update" method="POST">
					<input type="hidden" name="itemid" value="<?php echo $itemid ?>">
					<!-- Start Name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="name" class="form-control" 
							required="required" value="<?php echo $item['Name'] ?>" />
						</div>
					</div>
					<!-- End Name Field -->
					<!-- Start Description Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="description" class="form-control"
							required="required" value="<?php echo $item['Description'] ?>"  />
						</div>
					</div>
					<!-- End Description Field -->
					<!-- Start Price Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Price</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="price" class="form-control" required="required"
							       value="<?php echo $item['Price'] ?>"  />
						</div>
					</div>
					<!-- End Price Field -->
					<!-- Start Country_Made Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Country</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="country" class="form-control" required="required"
							       value="<?php echo $item['Country_Made'] ?>"  />
						</div>
					</div>
					<!-- End Country_Made Field -->

					
					<!-- Start Status Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10 col-md-6">
							<select name="status">
								<option value="1" <?php if($item['Status'] == 1){echo 'selected';} ?> >New</option>
								<option value="2" <?php if($item['Status'] == 2){echo 'selected';} ?> >Like New</option>
								<option value="3" <?php if($item['Status'] == 1){echo 'selected';} ?> >Used</option>
								<option value="4" <?php if($item['Status'] == 1){echo 'selected';} ?> >Very Old</option>
							</select>
						</div>
					</div>
					<!-- End Status Field -->

					<!-- Start Members Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Members</label>
						<div class="col-sm-10 col-md-6">
							<select name="member">
<?php
                                     $stmt = $con->prepare("SELECT * FROM users");
                                     $stmt->execute();
                                     $users = $stmt->fetchAll();
                                     foreach ($users as $user) {
                                     	echo "<option value='".$user['UserID']."'";
                                     	if ($item['Member_ID'] == $user['UserID']) {
                                     		echo 'selected';
                                     	}
                                     	echo ">".$user['Username']."</option>";                                    }
?>
							</select>
						</div>
					</div>
					<!-- End Members Field -->


					<!-- Start Categories Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Categories</label>
						<div class="col-sm-10 col-md-6">
							<select name="category">
<?php
                                     $stmt = $con->prepare("SELECT * FROM categories");
                                     $stmt->execute();
                                     $cats = $stmt->fetchAll();
                                     foreach ($cats as $cat) {
                                     	echo "<option value='".$cat['ID']."'";
                                     	if ($item['Cat_ID'] == $cat['ID']) {
                                     	 	echo 'selected';
                                     	 }
                                     	 echo  ">".$cat['Name']."</option>";                                    }
?>
							</select>
						</div>
					</div>
					<!-- End Categories Field -->
					<!-- Start tags Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Tags</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="tags" class="form-control" required="required"
							       placeholder="Seperate Tags with Comma (,)"
							       value="<?php echo $item['Tags'] ?>" />
						</div>
					</div>
					
					<!-- Start Submit Field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Save Item" class="btn btn-primary btn-lg" />
						</div>
					</div>
					<!-- End Submit Field -->
				</form>
<?php
// to show all comments in the item
                // Select All Users Except Admin 
			$stmt = $con->prepare("SELECT comments.*, users.Username FROM comments
			                       INNER JOIN users ON users.UserID = comments.User_id 
			                       WHERE Item_id = ?");
			// Execute The Statement
			$stmt->execute(array($itemid));
			// Assign To Variable 
			$rows = $stmt->fetchAll();

			if(!empty($rows)){ 
?>
             
				<h1 class="text-center">Manage [<?php echo $item['Name'] ?>] Comments</h1>
				
					<div class="table-responsive">
						<table class="main-table manage-members text-center table table-bordered">
							<tr>
								<td>Comment</td>
								<td>User Name</td>
								<td>Added Date</td>
								<td>Control</td>
							</tr>
							<?php
								foreach($rows as $row) {
									echo "<tr>";
										echo "<td>" . $row['Comment'] . "</td>";
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
			    <?php } ?>

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
		echo "<h1 class='text-center'>Update Item</h1>";
			echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				// Get Variables From The Form
				$id         = $_POST['itemid'];
				$name 	    = $_POST['name'];
				$desc 	    = $_POST['description'];
				$price 	    = $_POST['price'];
				$country 	= $_POST['country'];
				$status     = $_POST['status'];
				$member     = $_POST['member'];
				$category   = $_POST['category'];
				$tags       = $_POST['tags'];
				
			
				// Validate The Form
				$formErrors = array();
				
				
				if (empty($name)) {
					$formErrors[] = 'Name Can\'t Be <strong>Empty</strong>';
				}
				if (empty($desc)) {
					$formErrors[] = 'Description Can\'t Be <strong>Empty</strong>';
				}
				if (empty($price)) {
					$formErrors[] = 'Full Name Can\'t Be <strong>Empty</strong>';
				}
				if (empty($country)) {
					$formErrors[] = 'Email Can\'t Be <strong>Empty</strong>';
				}
				if ($status == 0) {
					$formErrors[] = 'You Must Choose The <strong>Status</strong>';
				}
				if ($member == 0) {
					$formErrors[] = 'You Must Choose The <strong>member</strong>';
				}
				if ($category == 0) {
					$formErrors[] = 'You Must Choose The <strong>category</strong>';
				}
				
				// Loop Into Errors Array And Echo It
				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}
				// Check If There's No Error Proceed The Update Operation
				if (empty($formErrors)) {

						// Update The Database With This Info
						$stmt = $con->prepare("UPDATE items SET Name = ?, Description = ?, Price = ?,
						                 Country_Made = ?, Status = ?, Cat_ID=?, Member_ID=?, Tags=? WHERE Item_ID = ?");
						$stmt->execute(array($name, $desc, $price, $country, $status,$category,$member,
							             $tags, $id));
						// Echo Success Message
						$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
						redirectHome($theMsg, 'back');
					
				}
			} else {
				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
				redirectHome($theMsg);
			}
			echo "</div>";
			
	
	}elseif ($do == 'Delete') { // Delete Member Page
		echo "<h1 class='text-center'>Delete Item</h1>";
			echo "<div class='container'>";
				// Check If Get Request userid Is Numeric & Get The Integer Value Of It
				$itemid= isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
				// Select All Data Depend On This ID
				$check = checkItem('Item_ID', 'items', $itemid);
				// If There's Such ID Show The Form
				if ($check > 0) {
					$stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zid");
					$stmt->bindParam(":zid", $itemid);
					$stmt->execute();
					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
					redirectHome($theMsg, 'back');
				} else {
					$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';
					redirectHome($theMsg);
				}
			echo '</div>';

			
	}elseif($do == 'Approve'){ // Activate Page
		echo "<h1 class='text-center'>Approve Member</h1>";
			echo "<div class='container'>";
				// Check If Get Request userid Is Numeric & Get The Integer Value Of It
				$itemid= isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
				// Select All Data Depend On This ID
				$check = checkItem('Item_ID', 'items', $itemid);
				// If There's Such ID Show The Form
				if ($check > 0) {
					$stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");
					$stmt->execute(array($itemid));
					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Activated
					          </div>';
					redirectHome($theMsg, 'back');
				} else {
					$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';
					redirectHome($theMsg);
				}
			echo '</div>';

		    
	}else{
		
	}

	include $templ.'footer.php';

}else {
		header('Location: index.php');
		exit();
}
ob_end_flush();  // Release The Output
?>