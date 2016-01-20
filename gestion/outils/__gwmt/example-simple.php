<?php
	include 'gwtdata.php';
	try {
		$email = "xxxx@xxxx.pf";
		$passwd = "xxxx";

		# If hardcoded, don't forget trailing slash!
		$website = "http://www.xxxx-tahiti.com/";

		$gdata = new GWTdata();
        print_r($gdata);echo("<br>");
		if($gdata->LogIn($email, $passwd) === true)
		{
            echo("eee");
			$gdata->DownloadCSV($website);
		}
	} catch (Exception $e) {
		die($e->getMessage());
	}
?>