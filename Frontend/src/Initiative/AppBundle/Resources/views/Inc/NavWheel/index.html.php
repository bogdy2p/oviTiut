<style>
.nav_wheel_container {
	width: calc(300px * 0.85);
	height: calc(300px * 0.85);
	margin: calc(50px * 0.85) auto 0 auto;
	position: relative;
	z-index: 2;
}
.nav_wheel {
	position: absolute;
	top: 0;
	left: 0;
	z-index: -1;
}

.nav_wheel_container .dotSize_0 {
	position: absolute;
	width: calc(30px * 0.85) !important;
	height: calc(30px * 0.85) !important;
	top: calc(131px * 0.85) !important;
	left: calc(135px * 0.85) !important;
	pointer-events: none;
}
.nav_wheel_container .dotSize_1 {
	position: absolute;
	width: calc(45px * 0.85) !important;
	height: calc(45px * 0.85) !important;
	top: calc(123px * 0.85) !important;
	left: calc(128px * 0.85) !important;
	pointer-events: none;
}
.nav_wheel_container .dotSize_2 {
	position: absolute;
	width: calc(80px * 0.85) !important;
	height: calc(80px * 0.85) !important;
	top: calc(103px * 0.85) !important;
	left: calc(109px * 0.85) !important;
	pointer-events: none;
}
.nav_wheel_container .dotSize_3 {
	position: absolute;
	width: calc(100px * 0.85) !important;
	height: calc(100px * 0.85) !important;
	top: calc(97px * 0.85) !important;
	left: calc(100px * 0.85) !important;
	pointer-events: none;
}
.nav_wheel_container .dotSize_4 {
	position: absolute;
	width: calc(120px * 0.85) !important;
	height: calc(120px * 0.85) !important;
	top: calc(81px * 0.85) !important;
	left: calc(89px * 0.85) !important;
	pointer-events: none;
}
.nav_wheel_container .dotSize_5 {
	position: absolute;
	width: calc(140px * 0.85) !important;
	height: calc(140px * 0.85) !important;
	top: calc(76px * 0.85) !important;
	left: calc(79px * 0.85) !important;
	pointer-events: none;
}
.nav_wheel_container .dotSize_6 {
	position: absolute;
	width: calc(160px * 0.85) !important;
	height: calc(160px * 0.85) !important;
	top: calc(62px * 0.85) !important;
	left: calc(69px * 0.85) !important;
	pointer-events: none;
}
.nav_wheel_container .dotSize_7 {
	position: absolute;
	width: calc(180px * 0.85) !important;
	height: calc(180px * 0.85) !important;
	top: calc(53px * 0.85) !important;
	left: calc(61px * 0.85) !important;
	pointer-events: none;
}

#hit_points {
	margin-top: -5px;
}
.hit_point {
	cursor: pointer;
	stroke: none;
}

#phase_container {
	position: absolute;
	top: -19px;
	left: -16px;
	width: 330px;
	height: 323px;
	opacity: .5;
	z-index: -1;
}
#phase_container svg {
	position: absolute;
	width: 100%;
	height: 100%;
}
</style>

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


$i = 0;
$jsonData = file_get_contents("js/data.json");
$json = json_decode($jsonData, true);

$arrayLength = count($json['wheel']['phases']);

// $completionScore = $json['wheel']['completionScore'];
// $project_urgency = $json['wheel']['urgency'];

if($project_urgency >= 7) {
	$project_urgency = "low";
}
else if($project_urgency <= 6 && $project_urgency >= 1) {
	$project_urgency = "medium";
}
else if($project_urgency <= 0) {
	$project_urgency = "high";
}


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


$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/tasks";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$result2=curl_exec($ch);
curl_close($ch);

$obj2 = json_decode($result2, true);




echo "<style>";

while($i <= $arrayLength-1) {

	$status = $obj2['Tasks'][$i]['LatestTaskStatus'];
	if($status == "Completed") {
		$fill = "#04de99";
	}
	elseif($status == "Open") {
		$fill = "#e5e5e5";
	}
	elseif($status == "Submitted") {
		$fill = "#f8b429";
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
	else {
		$fill2 = "gray";
	}
	$phase = $i+1;
	echo "#nav_wheel_".$json['wheel']['guid']." .nav_wheel_task_dot_".$phase." {";

	if($status == "submitted") {
		echo "fill:".$fill2.";";
		echo "stroke:".$fill2.";";
	} else {
		echo "stroke:".$fill2.";";
		echo "fill: none;";
	}
	echo "}";
	echo "#nav_wheel_".$json['wheel']['guid']." .nav_wheel_task_".$phase. "{";
	echo "fill:".$fill;
	echo "}";
	$i++;
}
echo "</style>";

?>
<?php include('img/nav_wheel/nav.php'); ?>