<?php
	define('DB_NAME', 'se_db');
	define('DB_USER', 'root');
	define('DB_PASSWORD', '');
	define('DB_HOST', 'localhost');

	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);

	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}

	$db_selected = mysql_select_db(DB_NAME, $link);

	if (!$db_selected) {
		die('Cant\'t use ' . DB_NAME . ': ' . mysql_error());
	}

	$value = $_POST['Name'];
	$value2 = $_POST['Email'];
	$value3 = $_POST['Comment'];

	$sql = "INSERT INTO feedback (Name, Email, Comment) VALUES ('$value', '$value2', '$value3')";

	if (!mysql_query($sql)) {
		die('Error: ' . mysql_error());
	}

	mysql_close();
?>