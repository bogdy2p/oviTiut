<?php
$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id;

$accesstoken = $_COOKIE['api'];

$headr = array();
$headr[] = 'Content-length: 0';
$headr[] = 'Content-type: application/json';
$headr[] = 'x-wsse: ApiKey="'.$accesstoken.'"';

$ch = curl_init();

// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// set the PHP HEADers
curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
//
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);


// Execute
$result=curl_exec($ch);
// Closing
curl_close($ch);

// Will dump a beauty json :3
$campaign = json_decode($result, true);

$url = $this->container->getParameter('apiUrl')."users/".$_COOKIE['dash_user_id']."/profile.json";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$result2=curl_exec($ch);
curl_close($ch);
$myProfile = json_decode($result2, true)[0];

$userCanEdit = ($myProfile['user_role'] != 'Viewer');

$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/tasks";

$headr = array();
$headr[] = 'Content-length: 0';
$headr[] = 'Content-type: application/json';
$headr[] = 'x-wsse: ApiKey="'.$accesstoken.'"';


$ch = curl_init();

// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// set the PHP HEADers
curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
//
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);


// Execute
$result2=curl_exec($ch);
// Closing
curl_close($ch);

$obj2 = json_decode($result2, true);
$task_id = $obj2['Tasks'][0]['TaskID'];




$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/editurl";

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
$matrixLink = $obj['Matrix Link'];



$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/selectedtasksinformation";

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

$chart_data = json_decode($result, true);

if(isset($chart_data['error'])) {
	$has_data = false;
} else {
	$has_data = true;
}



$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/files";

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

$file_list = json_decode($result, true);

$file_list_count = count($file_list['files']);

$i = 0;
while($i <= $file_list_count-1) {
	$filename = $file_list['files'][$i]['FileType'];
	$TaskName = $file_list['files'][$i]['TaskName'];
	if($filename == "Output" && $TaskName == "Comm Tasks") {
		$comms = $file_list['files'][$i]['FilePath'];
	}
	$i++;
}






?>
<div class="container-fluid min-height" style="display: flex; align-items: stretch;">
	<div class="row" style="display: flex;">
		<div class="col-xs-8 evo-white-bg min-height" style="padding-top: 20px;">
		<div class="col-xs-offset-10 col-xs-offset-1 min-height campaign-content-container">
				
				<div class="row get_api" data-api="<?php echo $_COOKIE['api']; ?>">
					<div class="col-xs-12">
						<p class="evo-text-smaller-upper">
							<a class="small-header-link" href="<?php echo $view['router']->generate('initiative_app_project', array('project_id' => $project_id, 'step_id' => 0)); ?>">
								<i class="fa fa-chevron-left"></i> CAMPAIGN: <?php echo $campaign['Campaign']['CampaignName']; ?>
							</a>
						</p>
						<h1 class="evo-header-big margin-top-0 text-swap font_stack_4">Communication Tasks</h1>
						<div class="evo-space"></div>
					</div>


					<div class="col-xs-12">
						<div class="task_bar">
							<div class="task_bar_left">								
								<a href="<?php echo $matrixLink; ?>&screen=200"><button class="btn evo-btn-2">questionnaire</button></a>
								<a href="<?php echo $matrixLink; ?>&screen=300"><button class="btn evo-btn-2 second-button-spacing await_response">Launch Communication Tasks</button></a>
							</div>
						</div>
					</div>

					<?php if(!$has_data) { ?>
					<div class="col-xs-9">
						<p class="evo-text evo-orange"><i class="fa fa-exclamation-triangle"></i> Please make sure the questionnaire is complete</p>
					</div>
					<?php } ?>
					<div class="col-xs-12">
						<div class="evo-space"></div>
					</div>
					<div class="col-xs-11">
						<div id="chart-container" style="width:660px; height:440px; opacity: 0; display: none;"></div>
						<div class="placeholder fluid-img project_id" data-project-id="<?php echo $project_id; ?>">
							<?php if($has_data) { ?><script>$(document).ready(function() { render_chart(); });</script><?php } else { ?><img src="http://placehold.it/900x400&text=chart"><?php } ?>
						</div>
						<div class="evo-space"></div>
					</div>

				<!-- 	<div class="col-xs-12">
						<div class="evo-space-biggest"></div>
						<div class="row" style="display: flex;">
							<div class="col-xs-12" style="display: flex;">
								<div class="file_box file_drop_1" data-form-id="1" data-project-id="<?php echo $project_id; ?>" data-task-id="<?php echo $real_TaskID; ?>" data-task-type="11" data-file-name="<?php echo $project_id; ?>_CT.png">
									<i class="fa fa-file-o"></i> attach communications tasks output
								</div>
							</div>
						</div>
						<div class="evo-space-biggest"></div>
						<div class="evo-space-biggest"></div>
					</div> -->	






					<div class="col-xs-12">
						<div class="row">
							<div class="evo-space-biggest"></div>
						</div>
					</div>

					<div class="col-xs-12">
						<?php if(isset($comms)) { ?>
							<div class="file_info_container chart-success">
								<div class="file_task_icon">
									<img src="<?php echo $view['assets']->getUrl('img/file_ham.png'); ?>" width="15" height="15">
									<div class="box_file_tout">
										<ul>
											<li>
												<a href="#" class="replace_file_1" data-text=" attach communications tasks output">
													Replace File
												</a>
											</li>
											<li>
												<a href="<?php echo $view['router']->generate('initiative_app_download_file'); ?>?task_name_id=2&file_type_id=11&campaign_id=<?php echo $project_id; ?>">
													Download File
												</a>
											</li>
										</ul>
									</div>
									<div class="evo-space"></div>
								</div>
							</div>
						<?php } ?>
					</div>


					<div class="col-xs-12">
							<div class="chart-success file_box file_1<?php if(!isset($comms)){echo " file_drop_1";}?>" data-form-id="1" data-project-id="<?php echo $project_id; ?>" data-task-id="<?php echo $real_TaskID; ?>" data-task-type="11" data-file-name="<?php echo $project_id; ?>_CT.png">
								<?php if(isset($comms)) { ?>
									<a href="<?php echo $view['router']->generate('initiative_app_download_file'); ?>?task_name_id=2&file_type_id=11&campaign_id=<?php echo $project_id; ?>">
										<i class="fa fa-cloud-download"></i> 
										download communications tasks output
									</a>
								<?php } else {	?>
									<i class="fa fa-file-o"></i> attach communications tasks output
								<?php }
								?>
							</div>

							<div class="evo-space-biggest"></div>
							<div class="evo-space-biggest"></div>
	
					</div>
				</div>


			</div>

		</div>
					
		<div class="col-xs-4 sidebar_bg">
			<?php echo $view->render('InitiativeAppBundle:Inc:CampaignSidebar/index.html.php', array('campaignName' => $campaign['Campaign']['CampaignName'], 'userCanEdit' => $userCanEdit, 'project_id' => $project_id, 'task_id' => "200", 'real_TaskID' => $real_TaskID)); ?>
		</div>
	</div>
</div>