<?php
	// configuration for our php server 
	set_time_limit(0);
	ini_set('default_socket_timeout', 300);
	session_start();

	// make constants using defined 
	define('client_ID', 'c73d173254d844b89d8117954f97d9ee');
	define('client_Secret', '971766cd8c4f4af7b7a6ff36f32b68b0');
	define('redirectURL', 'http://localhost:8888/appacademyapi/index.php');
	define('ImageDirectory', 'pics/');

?>

 <!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<!-- creating login for peple to go and give approvel for our web app to access their accoutn
ater getting approval we are now going to have info -->
	<a href="https:api.instagram/oauth/authorize/?client_id=<?php echo client_ID;?>
	&redirec_url=<?php echo redirectURL;?>
	&response_type=code">LOGIN</a>

	<script src="js/min.js"></script>
</body>
</html>
