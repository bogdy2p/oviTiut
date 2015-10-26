<div class="section">
	
	<a href="http://honey.is" target="_blank"><p class="evo-text-smaller-upper"><img src="<?php echo $view['assets']->getUrl('img/honey_logo.png') ?>" class="evo-ico-inline"> HONEY FEED</p></a>
	
	<?php
		$client_id = "9337b147fe743ac0f4bc";
		$client_secret = "8987fca6285f316ffcbacd7977c11f";

		$url = $this->container->getParameter('apiUrl')."users/".$_COOKIE['dash_user_id']."/profile.json";
		$api_key = $_COOKIE['api'];
		$api_header = array('x-wsse' => 'ApiKey="'.$api_key.'"');
		$response = Unirest\Request::get($url, $api_header);
		$user_profile = json_decode($response->raw_body, true)[0];

    $apiUrl = $this->container->getParameter('apiUrl');

		// set auth token from user profile
		$access_token = $user_profile['honey_uuid'];

                echo "<h1>CEVA AICI (honey/api.html.php - twig it ! :)</h1>";
  ?>

</div>