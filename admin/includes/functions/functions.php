<?php
/*
  ** Get All Function v1.2
  ** Function To Get All From Any Database Table
*/

function getAllFrom($field , $tableName, $where =Null, $and =Null,  $orderBy , $ordering= "DESC"){
	global $con;
	//$ql = $where == Null ? '' : $where;
	
	$statement = $con->prepare("SELECT $field FROM $tableName $where $and ORDER BY $orderBy DESC");
	$statement->execute();
	$all = $statement->fetchAll();
	return $all;

}
/*
  ** Function Title v1.0
  ** Title function that echo the page title in case the page 
  ** has the variable $pageTitle and echo default title for other page 
*/

function getTitle(){
	global $pageTitle;
	if(isset($pageTitle)){
		echo $pageTitle;
	}else{
		echo "Default";
	}
}

/*
  **                                  /// Home Redirect function v1.0///
  ** [This Function Accept Parameters]
  **$errorMsg = Echo The Error Message
  **$seconds  = Seconds Before Redirecting 

function redirectHome($errorMsg, $seconds=3){
	echo "<div class='alert alert-danger'>" .$errorMsg."</div>";
	echo "<div class='alert alert-info'>You Will Be Redirected To Home Page After". $seconds ." Seconds.</div>";
	header("refresh:$seconds; url=index.php");
	exit();

}
*/

/*
  **                                  /// Home Redirect function v2.0///
  ** [This Function Accept Parameters]
  **$theMsg = Echo The Message [Error | Success | Warning]
  **$url = The Link You Want To Redirect To 
  **$seconds  = Seconds Before Redirecting 
*/
function redirectHome($theMsg, $url= null, $seconds= 3){
	if($url === null){
       $url = 'index.php';
       $link = 'Home Page';
	}else{
		if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != ''){
			$url = $_SERVER['HTTP_REFERER'];
			$link = 'Previous Page';
		}else{
			$url = 'index.php';
			$link = 'Home Page';
		}
		
	}
	echo $theMsg;
	echo "<div class='alert alert-info'>You Will Be Redirected To $link After ". $seconds ." Seconds.</div>";
	header("refresh:$seconds; url=$url");
	exit();

}

/*
  ** Check Item Function v1.0
  ** Function To check item in database [function accept parameters]
  ** $select = the item to select [Example: user, item, category]
  ** $from   = the table to select from [Example: users, items, categories]
  ** $value  = the value of select [Example: Ahmed, ..]
*/
function checkItem($select, $from, $value){
	global $con;
	$statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
	$statement->execute(array($value));
	$count = $statement->rowCount();
	return $count;
}


/*
  ** Count Number Of Items Function v1.0
  ** Function To count Number Of Items ROws
  ** $item = The Item To Count 
  ** $table = The Table To Choose From 
*/
 function countItems($item, $table){
 	global $con;
 	$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
   	$stmt2->execute();
   	return $stmt2->fetchColumn();
 }


/*
  ** Get Latest Records Function v1.0
  ** Function To Get Latest Items From Database[ users , items , comments]
  ** $item = Field To Select 
  ** $table = The Table To Choose From
  ** $order = The Desc Ordering 
  ** $limit = Number Of Records To Get
*/

function getLatest($select, $table, $order, $limit = 5){
	global $con;
	$statement = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
	$statement->execute();
	$rows = $statement->fetchAll();
	return $rows;

}





