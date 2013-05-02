<?php
// Grabs form data from loc.html, converts each callnumber into array element

$word = $_POST['callnumbers'];
$callno_array = str_getcsv($word, "\n");

function normalize($callno) {
  // Parses callnumber parts into callnumber elements, stores as variables
	$alpha_match = preg_match("/[A-Z]{1,3}/", $callno, $alpha_bit);
	$numeric_match = preg_match("/[0-9]{1,4}/", $callno, $numeric_bit);
	$decimal_match = preg_match("/[.][0-9]{0,3}/", $callno, $decimal_bit);
	$cutter1_match = preg_match("/\.[A-Z][0-9]{1,7}/", $callno, $cutter1_bit);
	$cutter2_match = preg_match("/(?<=[ ])[A-Z][0-9]{1,6}/", $callno, $cutter2_bit);
	$date_match = preg_match("/(?<=[ ])[0-9][0-9][0-9][0-9][a-zA-Z]?/", $callno, $date_bit);

	// Validates call number part; checks to see if it exists.  If not, returns null.
	if ($cutter1_match == "0"){$cutter1_bit = array('');}
	if ($cutter2_match == "0"){$cutter2_bit = array('');}	
	if ($date_match == "0"){$date_bit = array('');}

	// Normalizes callnumber elements that need normalizing.
	$numeric_bit_f = str_pad($numeric_bit[0], 4, '0', STR_PAD_LEFT);
	$decimal_bit_f = str_pad($decimal_bit[0], 4, '0', STR_PAD_RIGHT);
	
	// Prints normalized callnumber.
	echo	"{$alpha_bit[0]} " . 
			"{$numeric_bit_f}" .
			"{$decimal_bit_f} " . 
			"{$cutter1_bit[0]} " . 
			"{$cutter2_bit[0]} " .
			"{$date_bit[0]}" .
			"<br />" ; 
};


// Loops through "$callno_array" to process whole list.
foreach ($callno_array as $callnum){
	normalize($callnum);
}

