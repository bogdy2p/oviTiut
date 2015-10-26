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
	if($filename == "Uploaded Presentation" && $TaskName == "Final Plan") {
		$data1 = $file_list['files'][$i]['FilePath'];
	}
	if($filename == "Working Flow Chart" && $TaskName == "Final Plan") {
		$data2 = $file_list['files'][$i]['FilePath'];
		$data2_version = $file_list['files'][$i]['FileVersion'];
		$data2_moddate = $file_list['files'][$i]['FileModifiedDate'];
		$data2_modname = $file_list['files'][$i]['FileModifiedBy'];
	}
	$i++;
}




?>
<div class="container-fluid min-height">
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
						<h1 class="evo-header-big margin-top-0 text-swap font_stack_4">Final Plan</h1>
						<div class="evo-space"></div>
					</div>


					<div class="col-xs-12">
						<div class="task_bar">
							<?php if($userCanEdit) { ?>
								<div class="task_bar_left">								
									<a href="<?php echo $matrixLink; ?>&screen=10100"><button class="btn evo-btn-2">Launch Matrix</button></a>
								</div>
							<?php } ?>
							<div class="task_bar_right">
								<span class="evo-text-smaller">
									<?php if(isset($data2)) { ?>
									<a href="<?php echo $view['router']->generate('initiative_app_download_file'); ?>?task_name_id=8&file_type_id=12&campaign_id=<?php echo $project_id; ?>">
										<i class="fa fa-cloud-download"></i> 
										download matrix flowchart
									</a>
								<?php } ?>
							</span>
								<span class="evo-text-smaller">
									<?php if(isset($data3)) { ?>
										<a href="<?php echo $view['router']->generate('initiative_app_download_file'); ?>?task_name_id=8&file_type_id=1&campaign_id=<?php echo $project_id; ?>">
											<i class="fa fa-cloud-download"></i> 
											download latest plan
										</a>
									<?php } ?>
								</span>
							</div>
					
							<div class="task_bar_far_right">
								<!-- generate powerpoint -->
								<a href="<?php echo $view['router']->generate('initiative_app_download_ppt'); ?>?task_name_id=3&file_type_id=18&campaign_id=<?php echo $project_id; ?>">
									<i class="fa fa-share" title="Generate PowerPoint"></i>
								</a>
							</div>
						</div>
					</div>




					<div class="col-xs-12">
						<div class="evo-space"></div>
						<div class="row" style="display: flex;">

							<div class="col-xs-12">
								<?php if(isset($data2)) { ?>
									<div class="file_info_container">
										<div class="file_task_icon">
											<img src="<?php echo $view['assets']->getUrl('img/file_ham.png'); ?>" width="15" height="15">
											<div class="box_file_tout">
												<ul>
													<?php if($userCanEdit) { ?>
													<li><a href="#" class="replace_file_2" data-text=" attach working flowchart">Replace File</a></li>
													<li>
													<?php } ?>
														<a href="<?php echo $view['router']->generate('initiative_app_download_file'); ?>?task_name_id=8&file_type_id=1&campaign_id=<?php echo $project_id; ?>">
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

					<?php if(isset($data2)) { ?>
					<div class="col-xs-12 clearfix">
						<div class="row">
							<div class="col-xs-2">
								<div class="attached_flowchart">
									<?php include('img/svg/2.php'); ?>
								</div>
							</div>
							<div class="col-xs-10">
								<p class="evo-text"><i class="fa fa-check evo-green"></i> flowchart attached</p>
							</div>
							<div class="col-xs-10">
								<p class="evo-text-smaller">
									<div class="row">
										<div class="col-xs-3"><p class="evo-text-smaller">version</p></div>
										<div class="col-xs-6"><p class="evo-text-smaller"><?php if(isset($data2_version)) { echo $data2_version; } ?></p></div>
									</div>
									<div class="row">
										<div class="col-xs-3"><p class="evo-text-smaller">modified date</p></div>
										<div class="col-xs-6"><p class="evo-text-smaller"><?php if(isset($data2_moddate)) { echo $data2_moddate; } ?></p></div>
									</div>
									<div class="row">
										<div class="col-xs-3"><p class="evo-text-smaller">modified by</p></div>
										<div class="col-xs-6"><p class="evo-text-smaller"><?php if(isset($data2_modname)) { echo $data2_modname; } ?></p></div>
									</div>
								</p>
							</div>
						</div>
					</div>
					<?php } ?>

					<div class="col-xs-12 clearfix">
						<div class="file_box file_2<?php if(!isset($data2) && $userCanEdit){echo " file_drop_2";}?>" data-form-id="1" data-project-id="<?php echo $project_id; ?>" data-task-id="<?php echo $real_TaskID; ?>" data-task-type="1">
							<?php if(isset($data2)) { ?>
								<a href="<?php echo $view['router']->generate('initiative_app_download_file'); ?>?task_name_id=8&file_type_id=1&campaign_id=<?php echo $project_id; ?>">
									<i class="fa fa-cloud-download"></i> 
									download working flowchart
								</a>
							<?php } else {	?>
								<i class="fa fa-file-o"></i> <?php echo ($userCanEdit) ? 'attach working flowchart' : 'working flowchart unavailable'; ?>
							<?php }
							?>
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
													<li><a href="#" class="replace_file_1" data-text=" attach revised presentation PPT">Replace File</a></li>
													<li>
													<?php } ?>
														<a href="<?php echo $view['router']->generate('initiative_app_download_file'); ?>?task_name_id=8&file_type_id=22&campaign_id=<?php echo $project_id; ?>">
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
						<div class="file_box file_1<?php if(!isset($data1) && $userCanEdit){echo " file_drop_1";}?>" data-form-id="1" data-project-id="<?php echo $project_id; ?>" data-task-id="<?php echo $real_TaskID; ?>" data-task-type="22">
							<?php if(isset($data1)) { ?>
								<a href="<?php echo $view['router']->generate('initiative_app_download_file'); ?>?task_name_id=8&file_type_id=22&campaign_id=<?php echo $project_id; ?>">
									<i class="fa fa-cloud-download"></i> 
									download revised presentation PPT
								</a>
							<?php } else {	?>
								<i class="fa fa-file-o"></i> <?php echo ($userCanEdit) ? 'attach revised presentation PPT' : 'revised presentation PPT unavailable'; ?>
							<?php }
							?>
						</div>
						<div class="evo-space-biggest"></div>
					</div>



					<div class="col-xs-12">
						<div class="evo-space"></div>
						<?php echo $view->render('InitiativeAppBundle:Files:index.html.php', array('userCanEdit' => $userCanEdit, 'project_id' => $project_id, 'task_id' => "800", 'real_TaskID' => $real_TaskID)); ?>
					</div>
				</div>

			</div>

		</div>
					
		<div class="col-xs-4 sidebar_bg">
			<?php echo $view->render('InitiativeAppBundle:Inc:CampaignSidebar/index.html.php', array('campaignName' => $campaign['Campaign']['CampaignName'], 'userCanEdit' => $userCanEdit, 'project_id' => $project_id, 'task_id' => "800", 'real_TaskID' => $real_TaskID)); ?>
		</div>
	</div>
</div>