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

	.login-card {
	  padding: 40px;
	  width: 274px;
	  background-color: #F7F7F7;
	  margin: 0 auto 10px;
	  border-radius: 2px;
	  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
	  overflow: hidden;
	}

	.login-card h1 {
	  font-weight: 100;
	  text-align: center;
	  font-size: 2.3em;
	}

	.login-card input[type=submit] {
	  width: 100%;
	  display: block;
	  margin-bottom: 10px;
	  position: relative;
	}

	.login-card input[type=text], input[type=password] {
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

	.login-card input[type=text]:hover, input[type=password]:hover {
	  border: 1px solid #b9b9b9;
	  border-top: 1px solid #a0a0a0;
	  -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
	  -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
	  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
	}

	.login {
	  text-align: center;
	  font-size: 14px;
	  font-family: 'Arial', sans-serif;
	  font-weight: 700;
	  height: 36px;
	  padding: 0 8px;
	  /* border-radius: 3px; */
	  /* -webkit-user-select: none;
	  user-select: none; */
	}

	.login-submit {
	  /* border: 1px solid #3079ed; */
	  border: 0px;
	  color: #fff;
	  text-shadow: 0 1px rgba(0,0,0,0.1); 
	  background-color: #4d90fe;
	  /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#4787ed)); */
	}

	.login-submit:hover {
	  /* border: 1px solid #2f5bb7; */
	  border: 0px;
	  text-shadow: 0 1px rgba(0,0,0,0.3);
	  background-color: #357ae8;
	  /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#357ae8)); */
	}

	.login-card a {
	  text-decoration: none;
	  color: #666;
	  font-weight: 400;
	  text-align: center;
	  display: inline-block;
	  opacity: 0.6;
	  transition: opacity ease 0.5s;
	}

	.login-card a:hover {
	  opacity: 1;
	}

	.login-help {
	  width: 100%;
	  text-align: center;
	  font-size: 12px;
	}
</style>

<?php
	echo "</head>";

	echo "<body>";
	echo "<div class=\"login-card\">";
	echo "<h1>Welcome Back!</h1><br>";
	echo "<form action=\"log_in.php\" method=\"post\">";
	echo "<input type=\"text\" name=\"Username\" placeholder=\"Username\" id=\"username\">";
	echo "<input type=\"password\" name=\"Password\" placeholder=\"Password\" id=\"password\">";
	echo "<input name=\"submit\" type=\"submit\" value=\"Log In\">";
	echo "</form>";
	echo "<div class=\"login-help\">";
    echo "<a href=\"sign_up.php\" id+\"register\">Register</a> &#149; <a href=\"forgot_password.html\">Forgot Password</a>";
    echo "</div>";
    echo "</div>";

	session_start();

	$Username = $_POST['Username'];
	$Password = $_POST['Password'];

	function empty_error()
	{
		echo "<script type=\"text/javascript\">";
		echo "alert(\"Enter a username and password!\")";
		echo "</script>";
	}

	function password_error()
	{
		echo "<script type=\"text/javascript\">";
		echo "alert(\"You're password is incorrect!\")";
		echo "</script>";
	}

	if($Username&&$Password)
	{
		$connect = mysql_connect('mysql7.000webhost.com', 'a3785503_root', 'Darren10') or die('Could not connect: ' . mysql_error());
		mysql_select_db('a3785503_sedb') or die('Cant\'t use a3785503_sedb: ' . mysql_error());
	
		$query = mysql_query("SELECT * FROM users WHERE Username='$Username'");

		$numrows = mysql_num_rows($query);

		if($numrows!==0)
		{
			while($row = mysql_fetch_assoc($query))
			{
				$dbusername = $row['Username'];
				$dbpassword = $row['Password'];
			}

			if($Username==$dbusername&&md5($Password)==$dbpassword)
			{
				$_SESSION['Username'] = $Username;
				header("Location: http://socialengineeringgame.com/home.html");
				exit();
			}
			else
			{
				password_error();
			}
		}
		else
		{
			echo "<script type=\"text/javascript\">";
			echo "if (confirm(\"You entered an unregistered username! You will be redirected to the sign up page!\")) ? location.href=\"sign_up.html\")";
			echo "</script>";
		}
	}
	echo "</body>";
	echo "</html>";
?>