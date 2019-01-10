<?php 
  session_start();
  include 'init.php'; 
?>


   <div class="container">
   	   
	   	   <div class="row">
<?php
        //$category = isset($_GET['pageid']) && is_numeric($_GET['pageid']) ? intval($_GET['pageid']) : 0;
        if(isset($_GET['name'])){
        	   $tag = $_GET['name'];
        	   echo '<h1 class=" head text-center">'.strtoupper($tag).'</h1>';
        	   
               $tagItems = getAllFrom("*", "items", "WHERE Tags like '%$tag%' ", "AND Approve = 1",
                                    "Item_ID");
		       foreach ($tagItems as $item) {
		       	echo '<div class="col-sm-6 col-md-3">';
		       	   echo '<div class="thumbnail item-box">';
		       	       echo '<span class="price-tag">'.$item['Price'].'</span>';
		       	       echo '<img class="img-responsive" src="layout/images/user_default.png" alt="">';
		       	       echo '<div class="caption">';
		       	            echo '<h3><a href="item.php?itemid='.$item['Item_ID'].'">'.$item['Name'].
		       	            '</a></h3>';
		       	            echo '<p>'.$item['Description'].'</p>';
		       	            echo '<div class="date">'.$item['Add_Date'].'</div>';
		       	       echo '</div>';
		       	   echo '</div>';
		       	echo '</div>';
		       }
		}else{
			echo "You Must Add Enter Tag Name";		}
		    
?>
	       </div>

	      
   </div>
   
  

<?php include $templ .'footer.php'; ?>