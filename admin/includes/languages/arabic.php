<?php

function lang ($phrase){
	static $lang = array(
		'MESSAGE' => 'Ahla In Arabic',
		'ADMIN' => 'Arabic Adminstrator'

	);
	return $lang[$phrase];
}