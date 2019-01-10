<?php

// error reporting
ini_set('display_errors', 'On');
error_reporting('E_All');

//db 
include 'admin/connect.php';

$sessionUser = '';
if(isset($_SESSION['username'])){
	$sessionUser = $_SESSION['username'];
}




// Routes

$templ = 'includes/templates/';  //Template Directory
$lang  = 'includes/languages/';  //language Directory
$func  = 'includes/functions/';  //functios Directory
$css   = 'layout/css/';  //Css Directory
$js    = 'layout/js/';  //Js Directory


// include important files
   include $func. 'functions.php';
   include $lang. 'english.php';
   include $templ .'header.php';
   


