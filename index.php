<?php

ob_start();
session_start();
$pageTitle = 'Homepage';

   include 'init.php';
?>
   <div class="container">
	   	   <div class="row">
<?php
               $allads = getAllFrom('*', 'items','WHERE Approve = 1' ,'', 'Item_ID');
		       foreach ($allads as $item) {
		       	echo '<div class="col-sm-6 col-md-3">';
		       	   echo '<div class="thumbnail item-box">';
		       	       echo '<span class="price-tag">$'.$item['Price'].'</span>';
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
?>
	       </div>

	      
   </div>
<?php
   include $templ .'footer.php';
   ob_end_flush();

?>