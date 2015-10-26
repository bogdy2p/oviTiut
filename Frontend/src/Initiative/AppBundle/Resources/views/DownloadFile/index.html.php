<?php

// require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Rhumsaa\Uuid\Uuid;
use Rhumsaa\Uuid\Exception\UnsatisfiedDependencyException;

ini_set('display_errors', 'On');
error_reporting(E_ALL);



// Data for the campaign:
$campaignId = $_GET['campaign_id']; // This should also be a parameter from $_GET[] array.


$api = $_COOKIE['api'];

// Create object used for making HTTP requests to the API.
// Specify base URL and authentication header:
$client = new Client([
    'base_url' => $this->container->getParameter('apiUrl'),
    'defaults' => [
        'headers' => ['x-wsse' => 'ApiKey="'.$api.'"'] // ApiKey value also has to be send to this script.
    ]
]);


// Send HTTP request to API and store API response:

// URL for final presentation PPTx download:
// $response = $client->get('campaigns/' . $campaignId . '/presentations/final-plan-outcome');

// URL for downloading a file based on file_type_id and task_name_id:
$response = $client->get('campaigns/' . $campaignId . '/downloadfile', [
	'query' => [
		'task_name_id' => $_GET['task_name_id'], 
		'file_type_id' => $_GET['file_type_id'] 
	]
]);

// echo '<pre>';
// print_r($response);exit();
// echo '</pre>';


// Set HTTP headers for the response that will be sent to the browser (using information from $response variable):
header('Content-Disposition: ' . $response->getHeader('Content-Disposition'));
header('Content-Length: ' . $response->getHeader('Content-Length'));
header('Content-Type: ' . $response->getHeader('Content-Type'));

// Send file back to browser:
echo $response->getBody();