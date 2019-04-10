<?php

	$host="localhost";
	$fusername="root";
	$fpassword="";
	// $fusername="swiftmoolahDb";
	// $fpassword="991994Jam#";
	$db_name = 'ECE_CLASS_OF_2017';

	@mysql_connect("$host", "$fusername", "$fpassword") or die();

	$createDb = "CREATE DATABASE IF NOT EXISTS ".$db_name;
	$createDbRun = mysql_query($createDb);

?>