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
		curl_close($ch);
		return $result;
	}

	// function to get userID cause username doesnt allow us to get pics
	function getUserID($userName){
		// to get id
		$url = 'https://api.instagram.com/v1/users/search?q=' .$userName. '&client_id' .clientID;
		// connecting to instagram
		$instagramInfo = connectToInstagram($url);
		// creating a local variable to decode json information 
		$results = json_decode($instagramInfo, true);

		// echoing out userID
		return $results['data']['0']['id'];
	}

	// function to print out images on screen
	function printImages($userID){
		$url = 'https://api.instagram.com/v1/users' .$userID. '/media/recent?client_id=' .clientID. '&count=5';
		$instagramInfo = connectToInstagram($url);
		$results = json_decode($instagramInfo, true);

		//parse through the information one by one 
		foreach ($results['data'] as $item) {
			// going to go through all of my results and give myself back the url of those pictures because we want to save it in the PHP server
			$image_url = $items['images']['low_resolution']['url'];
			echo '<img src="' .$image_url. ' "/><br/>';

			// calling a function to save that $image_url
			savePictures($images_url){

			}

		}
	}

	// function to save images to server 
	function savePictures($image_url){
		echo $image_url .'<br>';
		// the filename is what we are storing. Basename is the PHP bult in the method that we ere using to store $image_url
		$filename = basename($image_url);
		echo $filename . '<br>';

		// making sure that the image doesnt exist in the storage
		$destination = ImageDirectory . $filename;
		// goes and grabs an imagefile and stores it into our server 
		file_put_contents($destionation, file_get_contents($image_url));
	}


	if (isset($_GET['code'])) {
		$code = ($_GET['code']);
		$url = 'https://api.instagram/oauth/access_token';
		$access_token_settings = array('client_id' => client_id,
			'client_secret' => clientSecret,
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

	$results = json_decode($result, true);

	$userName = $results['user']['username'];

	$userID = getUserID($userName);
	printImages($userID);
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
