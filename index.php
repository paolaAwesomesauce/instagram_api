<!DOCTYPE html>
<html>
<head>
  <!-- <meta name="viewport" content="minimal-ui, width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">  -->
  <!-- <meta name="viewport" content="width=device-width" /> -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
	<title></title>
</head>
<body>
<!-- Header is linked to ligin, register and blog post -->
<?php
	// configuration for our php server 
	set_time_limit(0);
	ini_set('default_socket_timeout', 300);
	session_start();

	// make constants using defined 
	define('clientID', '100e0526196b4ef996c6f519ee1bd552');
	define('clientSecret', '5b38bb2e201e4442a806252470c1d075');
	define('redirectURI', 'http://localhost/paulaiscool/index.php');
	define('ImageDirectory', 'pics/');

	// function that is going to connet to insta
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

	// function to get userID cause username doesnt allow us to get pics
	function getUserID($userName){
		// to get id
		$url = 'https://api.instagram.com/v1/users/search?q=' .$userName. '&client_id=' .clientID;
		// connecting to instagram
		//print_r($url);

		$instagramInfo = connectToInstagram($url);
		// creating a local variable to decode json information 
		$results = json_decode($instagramInfo, true);

		// echoing out userID
		return $results['data'][0]['id'];
	}



	// function to print out images on screen
	function printImages($userID){
		$url = 'https://api.instagram.com/v1/users' .$userID. '/media/recent?client_id=' .clientID. '&count=5';
		$instagramInfo = connectToInstagram($url);
		$results = json_decode($instagramInfo, true);

		//parse through the information one by one 
		foreach ($results['data'] as $item) {
			// going to go through all of my results and give myself back the url of those pictures because we want to save it in the PHP server
			$image_url = $item['images']['low_resolution']['url'];
			echo '<img src="' .$image_url. ' "/><br/>';

			// calling a function to save that $image_url
			savePictures($image_url);
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
		file_put_contents($destination, file_get_contents($image_url));
	}

	if (isset($_GET['code'])){
	$code = $_GET['code'];
	$url = 'https://api.instagram.com/oauth/access_token';
	$access_token_settings = array('client_id' => clientID,
		                           'client_secret' => clientSecret,
		                           'grant_type' => 'authorization_code',
		                           'redirect_uri' => redirectURI,
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
?>
</body>
</html>

 <!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/index.css"> 
	<link href='http://fonts.googleapis.com/css?family=Play' rel='stylesheet' type='text/css'>
</head>
<body>
	  <div class="container">
	  <p id="hi">
	  	Hello
	  </p>
<!-- creating login for peple to go and give approvel for our web app to access their accoutn
ater getting approval we are now going to have info -->
	<a href="https://api.instagram/oauth/authorize/?client_id=<?php echo clientID;?>
	&redirect_uri=<?php echo redirectURI;?>
	&response_type=code">LOGIN</a>
	</div>
	<script src="js/min.js"></script>
</body>
</html>

<?php
}
?>
