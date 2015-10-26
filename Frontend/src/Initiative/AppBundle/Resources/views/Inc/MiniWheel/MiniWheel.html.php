<?php



$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id;

$accesstoken = $_COOKIE['api'];

$headr = array();
$headr[] = 'Content-length: 0';
$headr[] = 'Content-type: application/json';
$headr[] = 'x-wsse: ApiKey="'.$accesstoken.'"';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$result=curl_exec($ch);
curl_close($ch);

$obj = json_decode($result, true);

$completionScore = $obj['Campaign']['Completeness'];
$project_urgency = $obj['Campaign']['Urgency'];


if($project_urgency >= 7) {
	$project_urgency = "low";
}
else if($project_urgency <= 6 && $project_urgency >= 1) {
	$project_urgency = "medium";
}
else if($project_urgency <= 0) {
	$project_urgency = "high";
}


$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/tasks";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$result2=curl_exec($ch);
curl_close($ch);

$obj2 = json_decode($result2, true);



$i = 0;
$jsonData = file_get_contents("js/data.json");
$json = json_decode($jsonData, true);

$arrayLength = count($json['wheel']['phases']);


if($completionScore == 0) {
	$completionScoreSize = 0;
}
if($completionScore >= 1) {
	$completionScoreSize = 1;
}
if($completionScore >= 3) {
	$completionScoreSize = 2;
}
if($completionScore >= 5) {
	$completionScoreSize = 3;
}
if($completionScore >= 7) {
	$completionScoreSize = 4;
}
if($completionScore >= 9) {
	$completionScoreSize = 5;
}
if($completionScore >= 11) {
	$completionScoreSize = 6;
}
if($completionScore >= 13) {
	$completionScoreSize = 7;
}
echo "<style>";

while($i <= $arrayLength-1) {

	$status = $obj2['Tasks'][$i]['LatestTaskStatus'];

	$avatarUrl = $json['wheel']['phases'][$i]['taskOwner']['avatarUrl'];

	if($status == "Completed") {
		$fill = "#04de99";
	}
	elseif($status == "Open") {
		$fill = "#e5e5e5";
	}
	elseif($status == "Submitted") {
		$fill = "#f8b429";
	}
	elseif($status == "Completed") {
		$fill = "#04de99";
	}
	if($project_urgency == "low") {
		$fill2 = "#04DE99";
	}
	elseif($project_urgency == "medium") {
		$fill2 = "#f8b429";
	}
	elseif($project_urgency == "high") {
		$fill2 = "#FF65C7";
	}
	$phase = $i+1;
	echo "#mini_wheel_".$project_id." .mini_wheel_task_dot_".$phase." {";

	if($status == "submitted") {
		echo "fill:".$fill2.";";
		echo "stroke:".$fill2.";";
	} else {
		echo "stroke:".$fill2.";";
		echo "fill: none;";
	}
	echo "}";
	echo "#mini_wheel_".$project_id." .mini_wheel_task_".$phase. "{";
	echo "fill:".$fill;
	echo "}";
	$i++;
}
echo "</style>";

?>
<?php include('img/mini_wheel/mini.php'); ?>