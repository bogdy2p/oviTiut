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

// check user permissions
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
	if($filename == "Output" && $TaskName == "Fundamental Channels") {
		$media = $file_list['files'][$i]['FilePath'];
	}
	$i++;
}


$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/channelranking";

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




?>
<div class="container-fluid min-height">
	<div class="row" style="display: flex;">
		<div class="col-xs-8 evo-white-bg min-height" style="padding-top: 20px;">
			<div class="col-xs-offset-10 col-xs-offset-1 min-height campaign-content-container">
				
				<div class="row get_api" data-api="<?php echo $_COOKIE['api']; ?>">
					<div class="col-xs-12 project_id" data-project-id="<?php echo $project_id; ?>">
						<p class="evo-text-smaller-upper">
							<a class="small-header-link" href="<?php echo $view['router']->generate('initiative_app_project', array('project_id' => $project_id, 'step_id' => 0)); ?>">
								<i class="fa fa-chevron-left"></i> CAMPAIGN: <?php echo $campaign['Campaign']['CampaignName']; ?>
							</a>
						</p>
						<h1 class="evo-header-big margin-top-0 text-swap font_stack_4">Fundamental Channels</h1>
						<div class="evo-space"></div>
					</div>

					<div class="col-xs-12">
						<div class="task_bar">
							<?php if($userCanEdit) { ?>
								<div class="task_bar_left">								
									<a href="<?php echo $matrixLink; ?>&screen=400"><button class="btn evo-btn-2 await_response2">Launch Matrix</button></a>
								</div>
							<?php } ?>
							<div class="task_bar_far_right">
								<!-- generate powerpoint -->
								<a href="<?php echo $view['router']->generate('initiative_app_download_ppt'); ?>?task_name_id=3&file_type_id=18&campaign_id=<?php echo $project_id; ?>">
									<i class="fa fa-share" title="Generate PowerPoint"></i>
								</a>
							</div>
						</div>
					</div>











	


					<div class="col-xs-11">
						<div id="chart-container" style="width:660px; height:440px; opacity: 0; display: none;"></div>

						<div class="placeholder fluid-img project_id" data-project-id="<?php echo $project_id; ?>">
							<?php if($has_data) { ?><script>$(document).ready(function() { render_fund(); });</script><?php } else { ?><img src="http://placehold.it/900x400&text=chart"><?php } ?>
						</div>
					</div>


					<div class="col-xs-12">
						<div class="evo-space-biggest"></div>
						<div class="row" style="display: flex;">

							<div class="col-xs-12">
								<?php if(isset($data1)) { ?>
									<div class="file_info_container">
										<div class="file_task_icon">
											<img src="<?php echo $view['assets']->getUrl('img/file_ham.png'); ?>" width="15" height="15">
											<div class="box_file_tout">
												<ul>
													<?php if($userCanEdit) { ?>
														<li><a href="#" class="replace_file_1" data-text=" attach attach phasing output">Replace File</a></li>
														<li>
													<?php } ?>
														<a href="<?php echo $view['router']->generate('initiative_app_download_file'); ?>?task_name_id=5&file_type_id=11&campaign_id=<?php echo $project_id; ?>">
															Download File
														</a>
													</li>
												</ul>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>

						</div>
					</div>

					<div class="col-xs-12">
						<div class="evo-space"></div>
						<div class="row" style="display: flex;">
							<div class="col-xs-12" style="display: flex;">
								<div class="file_box file_1<?php if(!isset($data1) && $userCanEdit){echo " file_drop_1";}?>" data-form-id="1" data-project-id="<?php echo $project_id; ?>" data-task-id="<?php echo $real_TaskID; ?>" data-task-type="11" data-file-name="<?php echo $project_id; ?>_TS.png">
									<?php if(isset($data1)) { ?>
										<a href="<?php echo $view['router']->generate('initiative_app_download_file'); ?>?task_name_id=5&file_type_id=11&campaign_id=<?php echo $project_id; ?>">
											<i class="fa fa-cloud-download"></i> 
											fundamental channel ranking output  
										</a>
									<?php } else {	?>
										<i class="fa fa-file-o"></i> fundamental channel ranking output<?php if(!$userCanEdit){ echo ' unavailable';} ?>
									<?php }
									?>
								</div>
							</div>
						</div>
					</div>




















				</div>

			</div>

		</div>
					
		<div class="col-xs-4 sidebar_bg">
			<?php echo $view->render('InitiativeAppBundle:Inc:CampaignSidebar/index.html.php', array('campaignName' => $campaign['Campaign']['CampaignName'], 'userCanEdit' => $userCanEdit, 'project_id' => $project_id, 'task_id' => "500", 'real_TaskID' => $real_TaskID)); ?>
		</div>
	</div>
</div>