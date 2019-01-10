<?php
//db 
include 'connect.php';


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


//include navbar in all pages except the one has $noNavbar variable
   if(!isset($noNavbar)){
   	  include $templ .'navbar.php';
   }
