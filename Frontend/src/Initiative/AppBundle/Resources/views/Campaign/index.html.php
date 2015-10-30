<?php 
$request = $this->container->get('request');
$routeName = $request->get('_route');
?>
<?php $view->extend('::base.html.php') ?>


<?php
//$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/tasks";
$url = $this->container->getParameter('apiUrl')."produse";

die('mortus');
$accesstoken = $_COOKIE['api'];

$headr = array();
$headr[] = 'Content-length: 0';
$headr[] = 'Content-type: application/json';
$headr[] = 'x-wsse: ApiKey="'.$accesstoken.'"';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$result2=curl_exec($ch);
curl_close($ch);

$tasks = json_decode($result2, true);

$task = $tasks['Tasks'];


$totalTasks = count($task);

$i = 0;
$taskIds = array();
while($i <= $totalTasks-1) {
	$taskId = $tasks['Tasks'][$i]['TaskID'];
	array_push($taskIds, $taskId);
	$i++;
}

?>



<?php
	// big wheel
//	if($step_id == 0) {
//		echo $view->render('InitiativeAppBundle:Campaign:Step0/index.html.php', array('project_id' => $project_id, 'real_TaskID' => $taskIds[0]));
//	}
//	// jtbd
//	if($step_id == 100) {
//		echo $view->render('InitiativeAppBundle:Campaign:Step100/index.html.php', array('project_id' => $project_id, 'real_TaskID' => $taskIds[0], 'step_id' => 100));
//	}
//	// jtbd complete
//	if($step_id == 150) {
//		echo $view->render('InitiativeAppBundle:Campaign:Step150/index.html.php', array('project_id' => $project_id, 'real_TaskID' => $taskIds[0], 'step_id' => 100));
//	}
//	// comms
//	if($step_id == 200) {
//		echo $view->render('InitiativeAppBundle:Campaign:Step200/index.html.php', array('project_id' => $project_id, 'real_TaskID' => $taskIds[1], 'step_id' => 200));
//	}
//	// real lives
//	if($step_id == 300) {
//		echo $view->render('InitiativeAppBundle:Campaign:Step300/index.html.php', array('project_id' => $project_id, 'real_TaskID' => $taskIds[2], 'step_id' => 300));
//	}
//	// media idea
//	if($step_id == 400) {
//		echo $view->render('InitiativeAppBundle:Campaign:Step400/index.html.php', array('project_id' => $project_id, 'real_TaskID' => $taskIds[3], 'step_id' => 400));
//	}
//	// Fundamental Channels
//	if($step_id == 500) {
//		echo $view->render('InitiativeAppBundle:Campaign:Step500/index.html.php', array('project_id' => $project_id, 'real_TaskID' => $taskIds[4], 'step_id' => 500));
//	}
//	// budget allocation & mapping
//	if($step_id == 600) {
//		echo $view->render('InitiativeAppBundle:Campaign:Step600/index.html.php', array('project_id' => $project_id, 'real_TaskID' => $taskIds[5], 'step_id' => 600));
//	}
//	// phasing
//	if($step_id == 700) {
//		echo $view->render('InitiativeAppBundle:Campaign:Step700/index.html.php', array('project_id' => $project_id, 'real_TaskID' => $taskIds[6], 'step_id' => 700));
//	}
//	// final
//	if($step_id == 800) {
//		echo $view->render('InitiativeAppBundle:Campaign:Step800/index.html.php', array('project_id' => $project_id, 'real_TaskID' => $taskIds[7], 'step_id' => 800));
//	}
//	// outcome
//	if($step_id == 900) {
//		echo $view->render('InitiativeAppBundle:Campaign:Step900/index.html.php', array('project_id' => $project_id, 'real_TaskID' => $taskIds[8], 'step_id' => 900));
//	}

	?>