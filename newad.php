<?php

session_start();
$pageTitle = 'Create New Item';

   include 'init.php';

   if(isset($_SESSION['username'])){

   	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$formErrors = array();
			$name 		= filter_var($_POST['name'], FILTER_SANITIZE_STRING);
			$desc 		= filter_var($_POST['description'], FILTER_SANITIZE_STRING);
			$price 		= filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
			$country 	= filter_var($_POST['country'], FILTER_SANITIZE_STRING);
			$status 	= filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
			$category 	= filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
			$tags 		= filter_var($_POST['tags'], FILTER_SANITIZE_STRING);

			if (strlen($name) < 4) {
				$formErrors[] = 'Item Title Must Be At Least 4 Characters';
			}
			if (strlen($desc) < 10) {
				$formErrors[] = 'Item Description Must Be At Least 10 Characters';
			}
			if (strlen($country) < 2) {
				$formErrors[] = 'Item Title Must Be At Least 2 Characters';
			}
			if (empty($price)) {
				$formErrors[] = 'Item Price Cant Be Empty';
			}
			if (empty($status)) {
				$formErrors[] = 'Item Status Cant Be Empty';
			}
			if (empty($category)) {
				$formErrors[] = 'Item Category Cant Be Empty';
			}
			// Check If There's No Error Proceed The Update Operation
			if (empty($formErrors)) {
				// Insert Userinfo In Database
				$stmt = $con->prepare("INSERT INTO 
					items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID,Member_ID,Tags)
					VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember, :ztags)");
				$stmt->execute(array(
					'zname' 	=> $name,
					'zdesc' 	=> $desc,
					'zprice' 	=> $price,
					'zcountry' 	=> $country,
					'zstatus' 	=> $status,
					'zcat'		=> $category,
					'zmember'	=> $_SESSION['uid'],
					'ztags'	    => $tags
					
				));
				// Echo Success Message
				if ($stmt) {
					$successMsg = 'Item Has Been Added';
					
				}
			}
		}
   	
?>
<h1 class="text-center"><?= $pageTitle ?></h1>
<div class="create-ad block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading"><?= $pageTitle ?></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-8">
						<form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
						<!-- Start Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="name" class="form-control live" 
							   placeholder="Name Of The Item" data-class=".live-name" required />
							</div>
						</div>
						<!-- End Name Field -->
						<!-- Start Description Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="description" class="form-control live"
							 placeholder="Decribe The Item" data-class=".live-desc" required />
							</div>
						</div>
						<!-- End Description Field -->
						<!-- Start Price Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Price</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="price" class="form-control live" required
								        placeholder="Number To Arrange The Categories" data-class=".live-price" />
							</div>
						</div>
						<!-- End Price Field -->
						<!-- Start Country_Made Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Country</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="country" class="form-control" 
								       placeholder="Country Of Made"  required/>
							</div>
						</div>
						<!-- End Country_Made Field -->

						
						<!-- Start Status Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10 col-md-6">
								<select name="status" required>
									<option value="">...</option>
									<option value="1">New</option>
									<option value="2">Like New</option>
									<option value="3">Used</option>
									<option value="4">Very Old</option>
								</select>
							</div>
						</div>
						<!-- End Status Field -->

					


						<!-- Start Categories Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Categories</label>
							<div class="col-sm-10 col-md-6">
								<select name="category" required>
									<option value="">...</option>
	<?php
	                                     
	                                     $cats = getAllFrom('*','Categories','','', 'ID');
	                                     foreach ($cats as $cat) {
	                                     	echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";                                    }
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


					<div class="col-md-4">
						
						    <div class="thumbnail item-box live-preview">
						       	<span class="price-tag">
						       	     $<span class="live-price"></span>
						        </span>
						       	<img class="img-responsive" src="layout/images/user_default.png" alt="">
						       	    <div class="caption">
						       	      <h3 class="live-name">Title</h3>
						       	      <p class="live-desc">Description</p>
						       	    </div>
						    </div>
						
					</div>
				</div>
				<!-- start looping errors array -->
				
					<?php 
					if(!empty($formErrors)){
						foreach($formErrors as $error){

						   echo "<div class='alert alert-danger'>".$error."</div>";
						}
					}

					if(isset($successMsg)){
						echo "<div class='alert alert-success'>".$successMsg."</div>";
					}
					?>
				<!-- end looping errors array -->
			</div>
		</div>

	</div>
</div>

<
<?php
  }else{
  	header('Location:login.php');
  	exit();
  }
   include $templ .'footer.php';

?>