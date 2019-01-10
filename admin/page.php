<?php


//$do = isset($_GET['do']) ? $_GET['do'] : 'manage';
$do = '';
if(isset($_GET['do'])){
	$do = $_GET['do'];

}else{
	$do = 'manage';
}


// if the page in main page
if($do == 'manage'){
	echo 'Welcome You Are In Manage Category Page';
	echo '<a href="page.php?do=Add">Add New Category</a>';
}elseif ($do == 'Add') {
	echo 'Welcome You Are In Add Category Page';
}elseif ($do == 'Insert') {
	echo 'Welcome You Are In Insert Category Page';
}else{
	echo 'Error There\'s No Page With This Name';
}