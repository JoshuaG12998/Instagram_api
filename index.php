<?php
//Configuration for our PHP Server
set_time_limit(0);
ini_set('default_socket_timeout', 300);
session_start();

//Make Constants using define
define('clientID', 'a7525d0c37684196a4c67745b031f8c2');
define('clientSecret', '56f055d50cb7431191dc3f4e1dfef0ac');
define('redierctURI', 'http://localhost:8888/appacademyapi/index.php');
define('ImageDirectory', 'pics/');

if isset(($_GET['code'])){
	$code = ($_GET['code']);
	$url = 'https://api.instagram.com/oauth/access_token';
	$access_token_settings = array('client_id' => clientID,
									'client_secret' => clientSecret, 
									'grant_type' => 'authorization_code'
									'redirect_uri' => redirect_URI,
									'code' => $code
									);
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Untitled</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="author" href="humans.txt">
	</head>
	<body>
		<!-- create a login for people to go to Instagram AOI -->
		<!-- creating a link to instagram through oauth/authorizing the account -->
		<!-- After setting client_id to blank in the beginning, along with redirect_uri then you have to echo it out from the constant. -->
		<a href="https:api.instagram/oauth/authorize/?client_id=<?php echo clientID; ?>&redirect_uri=<?php echo redirectURI; ?>&response_type=code">LOGIN IN</a>	
		<script src="js/main.js"></script>	

</body>
</html>