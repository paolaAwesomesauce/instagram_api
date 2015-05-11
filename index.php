<?php
	// configuration for our php server 
	set_time_limit(0);
	ini_set('default_socket_timeout', 300);
	session_start();

	// make constants using defined 
	define('clientID', 'c73d173254d844b89d8117954f97d9ee');
	define('client_Secret', '971766cd8c4f4af7b7a6ff36f32b68b0');
	define('redirectURL', 'http://localhost:8888/appacademyapi/index.php');
	define('ImageDirectory', 'pics/');

	// function that is going to connet to insta
	function connectToInstagram($url){
		$ch = curl_init();

		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => false,
			CURLOPT_SSL_VERIFYPEER => 2,
			));
		$result = curl_exec($ch);
		return $result;
	}

	if (isset($_GET['code'])) {
		$code = ($_GET['code']);
		$url = 'https:api.instagram/oauth/access_token';
		$access_token_settings = array('client_id' => client_id,
			'client_secret' => client_Secret,
			'grant_type' => 'authorization_code',
			'redirect_url' => redirectURL,
			'code' => $code
			);
	
// cURL is a library we use in PHP that calls on other API's
	// setting a cURL session and we put in $url because thats where we are getting data from
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_POST, true);
	// setting the POSTFIELDS  to the arrat setup that we created
	curl_setopt($curl, CURLOPT_POSTFIELDS, $access_token_settings);
	// setting equal to bc we are getting strings back
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	// but in live work-production we want to set this to true
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	
	$result = curl_exec($curl);
	curl_close($curl);

	$result = json_decode($result, true);
	echo $results['user']['username'];
	}
	else{

	}
?>

 <!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<!-- creating login for peple to go and give approvel for our web app to access their accoutn
ater getting approval we are now going to have info -->
	<a href="https:api.instagram/oauth/authorize/?client_id=<?php echo clientSID;?>
	&redirec_url=<?php echo redirectURL;?>
	&response_type=code">LOGIN</a>

	<script src="js/min.js"></script>
</body>
</html>
