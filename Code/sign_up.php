<?php
	echo "<html lang'\"en\">";
	echo "<head>";
	echo "<title>Social Engineering</title>";
?>
<style type="text/css">
	@import url(http://fonts.googleapis.com/css?family=Roboto:400,100);

	html{
	  background:url("proxy.jpeg") repeat center top #826e79;
	}

	body {
	  -webkit-background-size: cover;
	  -moz-background-size: cover;
	  -o-background-size: cover;
	  background-size: cover;
	  font-family: 'Roboto', sans-serif;
	}

	.register-card {
	  padding: 40px;
	  width: 274px;
	  background-color: #F7F7F7;
	  margin: 0 auto 10px;
	  border-radius: 2px;
	  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
	  overflow: hidden;
	}

	.register-card h1 {
	  font-weight: 100;
	  text-align: center;
	  font-size: 2.3em;
	}

	.register-card input[type=submit] {
	  width: 100%;
	  display: block;
	  margin-bottom: 10px;
	  position: relative;
	}

	.register-card input[type=text], input[type=password] {
	  height: 44px;
	  font-size: 16px;
	  width: 100%;
	  margin-bottom: 10px;
	  -webkit-appearance: none;
	  background: #fff;
	  border: 1px solid #d9d9d9;
	  border-top: 1px solid #c0c0c0;
	  /* border-radius: 2px; */
	  padding: 0 8px;
	  box-sizing: border-box;
	  -moz-box-sizing: border-box;
	}

	.register-card input[type=text]:hover, input[type=password]:hover {
	  border: 1px solid #b9b9b9;
	  border-top: 1px solid #a0a0a0;
	  -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
	  -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
	  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
	}

	.register-card a {
	  text-decoration: none;
	  color: #666;
	  font-weight: 400;
	  text-align: center;
	  display: inline-block;
	  opacity: 0.6;
	  transition: opacity ease 0.5s;
	}

	.register-card a:hover {
	  opacity: 1;
	}
</style>
<?php
	echo "</head>";

	echo "<body>";
	echo "<div class=\"register-card\">";
	echo "<h1>Sign Up, It's FREE!</h1><br>";
	echo "<form action=\"sign_up.php\" method=\"post\">";
	echo "<input type=\"text\" name=\"FirstName\" placeholder=\"First Name\" id=\"firstname\">";
	echo "<input type=\"text\" name=\"LastName\" placeholder=\"Last Name\" id=\"lastname\">";
	echo "<input type=\"text\" name=\"Username\" placeholder=\"Username\" id=\"username\">";
	echo "<input type=\"password\" name=\"Password\" placeholder=\"Password\" id=\"password\">";
	echo "<input type=\"password\" name=\"Password2\" placeholder=\"Confirm Password\" id=\"password2\">";
	echo "<input type=\"text\" name=\"Email\" placeholder=\"Email\" id=\"email\">";
	echo "<input type=\"text\" name=\"Email2\" placeholder=\"Confirm Email\" id=\"email2\">";
	echo "<input name=\"submit\" type=\"submit\" value=\"Register\">";
	echo "</form>";
	echo "</div>";

    define('DB_NAME', 'a3785503_sedb');
	define('DB_USER', 'a3785503_root');
	define('DB_PASSWORD', 'Darren10');
	define('DB_HOST', 'mysql7.000webhost.com');

	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);

	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}

	$db_selected = mysql_select_db(DB_NAME, $link);

	if (!$db_selected) {
		die('Cant\'t use ' . DB_NAME . ': ' . mysql_error());
	}

	$FirstName = $_POST['FirstName'];
	$LastName = $_POST['LastName'];
	$Username = $_POST['Username'];
	$Email = $_POST['Email'];
	$Email2 = $_POST['Email2'];
	$Password = $_POST['Password'];
	$Password2 = $_POST['Password2'];

	if (!filter_var($Email, FILTER_VALIDATE_EMAIL))
	{
		echo "<script type=\"text/javascript\">";
		echo "alert(\"Email address is invalid!\")";
		echo "</script>";
	}

	if ($Email==$Email2)
	{
		if ($Password==$Password2)
		{
			$query = "SELECT User_ID FROM users WHERE Email = '$Email' and verified = '0'";
			
			$num = mysql_num_rows($query);

			if ($num > 0)
			{
				echo "<script type=\"text/javascript\">";
				echo "alert(\"Your email is already activated!\")";
				echo "</script>";
			}
			else
			{
				$sql = "INSERT INTO users (First_Name, Last_Name, Username, Email, Password) VALUES ('$FirstName', '$LastName', '$Username', '$Email', '$Password')";

				if (!mysql_query($sql))
				{
					die('Error: ' . mysql_error());
				}
				else
				{
					$verificationCode = md5(uniqid(rand()));

					$verificationLink = "http://socialengineeringgame.com/activate.php?code=" . $verificationCode;

					$htmlStr = "";
					$htmlStr .= "Hi " . $email. ",<br /><br />";

					$htmlStr .= "Please click the button below to verify your account and have access to the game site.<br /><br /><br />";
					$htmlStr .= "<a href='{$verificationLink}' target='_blank' style='padding:1em; font-weight:bold; background-color:blue;color:#fff;'>VERIFY EMAIL</a><br /><br /><br />";

					$htmlStr .= "Kind regards,<br />";
					$htmlStr .= "<a href='http://socialengineeringgame.com/' target='_blank'>Social Engineering: Hacking the Human OS</a?<br />";

					$name = "Social Engineering: Hacking the Human OS";
					$email_sender = "no-reply@socialengineeringgame.com";
					$subject = "Verification Link | Social Engineering: Hacking the Human OS";
					$recipient_email = $email;

					$headers = "MIME-Version: 1.0rn";
					$headers .= "Content-type: text/html; charset=iso-8859-1rn";
					$headers .= "From: {$name} <{$email_sender}> n";

					$body = $htmlStr;

					if (mail($recipient_email, $subject, $body, $headers))
					{
						echo "<script type=\"text/javascript\">";
						echo "alert(\"A verification email was sent to " . $$email . ", please open your email inbox and click the given link to verify your account!\")";
						echo "</script>";
					}
				}
			}

			$sql = "INSERT INTO users (First_Name, Last_Name, Username, Email, Password, ver_code) VALUES ('$FirstName', '$LastName', '$Username', '$Email', '$Password', '$verificationCode')";

			if (!mysql_query($sql)) {
				die('Error: ' . mysql_error());
			}
			else
			{
				echo "<script type=\"text/javascript\">";
				echo "alert(\"Thank you for registering, an email verification has been sent!\")";
				echo "</script>";
			}
		}
		else
		{
			echo "<script type=\"text/javascript\">";
			echo "alert(\"Passwords do not match!\")";
			echo "</script>";
		}
	}
	else
	{
		echo "<script type=\"text/javascript\">";
		echo "alert(\"Email addresses do not match!\")";
		echo "</script>";
	}

	mysql_close();

	echo "</body>";
	echo "</html>";
?>