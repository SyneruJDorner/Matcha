<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();

	foreach (glob("AJAX Functions/Get/*.php") as $filename)
	{
		if ($filename != "AJAX Functions/Get/include_all_gets.php")
			include $filename;
	}
?>