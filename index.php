<?php
//Configuration for our PHP Server
set_time_limit(0);
ini_set('default_socket_timeout', 300);
session_start();

//Make Constants using define
define('clientID', '9aa80563151d45b0a54d9ff6d208c15e');
define('clientSecret', 'b73c33a93dea45b3ab1342bcdaab423c');
define('redirectURI', 'http://localhost/appacademyapi/index.php');
define('ImageDirectory', 'pics/');

//Function that is going to connect to Instagram
function connectToInstagram($url){
	$ch = curl_init();

	curl_setopt_array($ch, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_SSL_VERIFYHOST => 2,
		));
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
//Function to get user ID cause userName doesn't allow us to get pictures!
function getUser($userName){
	$url = 'http://api.instagram.com/v1/users/search?q='.$userName.'&client_id'.clientID;
	$instagramInfo = connectToInstagram($url);
	$result = json_decode($instagramInfo, true);

	echo $result['data']['0']['id'];
}
//Function to print out images onto our screen
function printImages($userID){
	$url = 'https://api.instagram.com/v1/users/'.$userID.'/media/recent?client_id='.clientID.'&count=5';
	$instagramInfo = connectToInstagram($url);
	$results = json_decode($instagramInfo, true);
	//Parse through the information one by one.
	foreach($results['data'] as $items){
		$image_url = $items['images']['low_resolution']['url']; //going to go through all of my results and give myself back the URL of those pictures
		//because we want to save it in the PHP Server
		echo '<img src=" '.$image_url.' "/><br/>';
	}
}


if(isset($_GET['code'])){
	$code = ($_GET['code']);
	$url = 'https://api.instagram.com/oauth/access_token';
	$access_token_settings = array('client_id' => clientID,
									'client_secret' => clientSecret, 
									'grant_type' => 'authorization_code',
									'redirect_uri' => redirectURI,
									'code' => $code
									);
//cURL is what we use in PHP, it's a library calls to other API's
$curl = curl_init($url);//setting a cURL session and we put in $url because that;s where we are getting the data from
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $access_token_settings);//setting the POSTFIELDS to the array setup that we created
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//setting it equal to 1 because we are gettingstrings back
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//but in live work-production we want to set this to true

$result = curl_exec($curl);
curl_close($curl);

$results = json_decode($result, true);

$userName = $results['user']['username'];

$userID = getUserID($username);
}

printImage($userID);
else {
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
		<a href="https:api.instagram.com/oauth/authorize/?client_id=<?php echo clientID; ?>&redirect_uri=<?php echo redirectURI; ?>&response_type=code">LOGIN IN</a>	
		<script src="js/main.js"></script>	

</body>
</html>
<?php
}
?>