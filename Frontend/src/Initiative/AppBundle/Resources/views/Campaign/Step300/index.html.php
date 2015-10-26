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





$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/reallives";

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

$realLives = json_decode($result, true);
$realLivesUrl = $realLives['real_lives_url'];
$realLivesPass = $realLives['real_lives_password'];





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

$url = $this->container->getParameter('apiUrl')."users/".$_COOKIE['dash_user_id']."/profile.json";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$result2=curl_exec($ch);
curl_close($ch);
$myProfile = json_decode($result2, true)[0];

$userCanEdit = ($myProfile['user_role'] != 'Viewer');

$i = 0;
while($i <= $file_list_count-1) {
	$filename = $file_list['files'][$i]['FileType'];
	if($filename == "Viz 1") {
		$viz1 = $file_list['files'][$i]['FilePath'];
	}
	if($filename == "Viz 2") {
		$viz2 = $file_list['files'][$i]['FilePath'];
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
						<h1 class="evo-header-big margin-top-0 text-swap font_stack_4">Real Lives</h1>
						<div class="evo-space"></div>
					</div>


					<div class="col-xs-12">
						<div class="task_bar">
							<div class="task_bar_left">								
								<a href="#" class="disabled"><button class="btn evo-btn-2">Launch Real Lives</button></a>
							</div>
							<?php if($realLivesUrl) { ?>
							<div class="task_bar_right">
								<span class="evo-text-smaller"><a href="<?php echo $realLivesUrl; ?><?php if(isset($realLivesPass)) { echo "&directguid=".$realLivesPass; } ?>" target="_blank"><i class="fa fa-file-o"></i> view real lives presentation</a></span><?php
									if($userCanEdit) { 
										echo '<span class="evo-text-right show_rl_creds"><i class="fa fa-gear" title="Edit Real Lives Credentials"></i></span>';
									} ?>
							</div>
							<?php } ?>
							<!-- <div class="task_bar_far_right">
								<!-- generate powerpoint -->
								<!-- <a href="#"><span class="export_ppt"><i class="fa fa-share" title="Generate PowerPoint"></i></span></a> -->
							<!-- </div> -->
						</div>
					</div>




					

					<div class="col-xs-12 hidden_rl_creds" <?php if($realLivesUrl) { echo "style=\"display: none\";"; } ?>>
						<p class="evo-text-smaller-upper">REAL LIVES CREDENTIALS</p>
						<form name="update_reallives" id="update_reallives" action="<?php echo $this->container->getParameter('apiUrl'); ?>campaigns/<?php echo $project_id; ?>/reallives.json" method="PUT">
							<label required style="border-top-width: 0">Real Lives URL</label>
							<input id="get_real_lives_url" name="real_lives_url" placeholder="url" class="form-control" <?php if($realLivesUrl) { echo "value=\"".$realLivesUrl."\""; } ?>>
							<label style="border-top-width: 0">Passcode</label>
							<input id="get_real_lives_pass" name="real_lives_password" placeholder="passcode" class="form-control" <?php if($realLivesPass) { echo "value=\"".$realLivesPass."\""; } ?>>
							<div class="evo-space"></div>
							<div class="row">
								<div class="col-xs-4">
									<?php
										if($realLivesUrl || $realLivesPass) { ?>
											<button type="submit" class="evo-btn-2 btn change_btn_text">update</button>
										<?php } else { ?>
											<button type="submit" class="evo-btn-2 btn change_btn_text">submit</button>
									<?php } ?>
								</div>
								<div class="col-xs-4">
									<p class="evo-text-smaller save-data"> <i class="fa fa-spinner fa-spin"></i> <span>saving</span></p>
								</div>
							</div>
						</form>
					</div>


					<div class="col-xs-12">
						<p class="evo-text-smaller warning_tout <?php if($realLivesUrl) { echo "hidden"; }?>" style="margin-top: 20px;">
							If you want to update the presentation, you can use this Real Lives URL and Passcode to download the Real Lives Presentation for editing. When you are done with your edits, re-publish the Real Lives presentation to the web and update the URL and Passcode accordingly
						</p>
					</div>










					<div class="col-xs-12 display_viz <?php if(!$realLivesUrl) { echo "hidden_viz\";"; } ?>">
						<p class="evo-text-smaller-upper">REAL LIVES VISUALIZATIONS </p>
					</div>

					<div class="col-xs-12 display_viz <?php if(!$realLivesUrl) { echo "hidden_viz\";"; } ?>">
						<div class="row" style="display: flex;">
							<div class="col-xs-6">
								<?php if(isset($viz1)) { ?>
									<div class="file_info_container">
										<div class="file_task_icon">
											<img src="<?php echo $view['assets']->getUrl('img/file_ham.png'); ?>" width="15" height="15">
											<div class="box_file_tout">
												<ul>
													<?php if($userCanEdit) { ?>
														<li><a href="#" class="replace_file_1" data-text=" attach viz 1">Replace viz 1</a></li>
													<?php } ?>
													<li>
														<a href="<?php echo $view['router']->generate('initiative_app_download_file'); ?>?task_name_id=3&file_type_id=18&campaign_id=<?php echo $project_id; ?>">
															Download Viz 1
														</a>
													</li>
												</ul>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>

							<div class="col-xs-6">
								<?php if(isset($viz2)) { ?>
									<div class="file_task_icon">
										<img src="<?php echo $view['assets']->getUrl('img/file_ham.png'); ?>" width="15" height="15">
										<div class="box_file_tout">
											<ul>
												<?php if($userCanEdit) { ?>
													<li><a href="#" class="replace_file_2" data-text=" attach viz 2">Replace Viz 2</a></li>
												<?php } ?>
												<li>
													<a href="<?php echo $view['router']->generate('initiative_app_download_file'); ?>?task_name_id=3&file_type_id=19&campaign_id=<?php echo $project_id; ?>">
														Download Viz 2
													</a>
												</li>
											</ul>
										</div>
									</div>
								<?php } ?>
							</div>

						</div>
					</div>



					<div class="col-xs-12 display_viz <?php if(!$realLivesUrl) { echo "hidden_viz\";"; } ?>">
						<div class="evo-space"></div>
						<div class="row" style="display: flex;">
							<div class="col-xs-6">
								<?php if(isset($viz1)) { ?>
									<img src="<?php echo $this->container->getParameter('fileUrl').$viz1; ?>" class="fluid-img">
								<?php } ?>
							</div>
							<div class="col-xs-6">
								<?php if(isset($viz2)) { ?>
									<img src="<?php echo $this->container->getParameter('fileUrl').$viz2; ?>" class="fluid-img">
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="col-xs-12 display_viz <?php if(!$realLivesUrl) { echo "hidden_viz\";"; } ?>">
						<div class="row" style="display: flex;">
							<div class="col-xs-6" style="display: flex;">
								<div class="file_box file_1<?php if(!isset($viz1) && $userCanEdit){echo " file_drop_1";}?>" data-form-id="1" data-project-id="<?php echo $project_id; ?>" data-task-id="<?php echo $real_TaskID; ?>" data-task-type="18">
									<?php if(isset($viz1)) { ?>
										<a href="<?php echo $view['router']->generate('initiative_app_download_file'); ?>?task_name_id=3&file_type_id=18&campaign_id=<?php echo $project_id; ?>">
											<i class="fa fa-cloud-download"></i> 
											download viz 1
										</a>
									<?php } elseif($userCanEdit) {	?>
										<i class="fa fa-file-o"></i> attach viz 1
									<?php } else { ?>
										<i class="fa fa-file-o"></i> viz unavailable 
									<?php
											  }
									?>
								</div>
							</div>
							<div class="col-xs-6" style="display: flex;">
								<div class="file_box file_2<?php if(!isset($viz2) && $userCanEdit){echo " file_drop_2";}?>" data-form-id="2" data-project-id="<?php echo $project_id; ?>" data-task-id="<?php echo $real_TaskID; ?>" data-task-type="19">
									<?php if(isset($viz2)) { ?>
										<a href="<?php echo $view['router']->generate('initiative_app_download_file'); ?>?task_name_id=3&file_type_id=19&campaign_id=<?php echo $project_id; ?>">
											<i class="fa fa-cloud-download"></i> 
											download viz 2
										</a>
									<?php } elseif($userCanEdit) {	?>
										<i class="fa fa-file-o"></i> attach viz 2
									<?php } else { ?>
										<i class="fa fa-file-o"></i> viz unavailable 
									<?php
											  }
									?>
								</div>
							</div>
						</div>
					</div>









			














			<!-- 		<div class="col-xs-12">
						<div class="evo-space"></div>
					</div>
					<div class="col-xs-6">
						<div class="placeholder fluid-img">
							<img src="http://placehold.it/900x400&text=page 1">
							<div class="evo-space"></div>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="placeholder fluid-img">
							<img src="http://placehold.it/900x400&text=page 2">
							<div class="evo-space"></div>
						</div>
					</div> -->
					<div class="col-xs-12">
						<div class="evo-space-biggest"></div>
						<?php echo $view->render('InitiativeAppBundle:Files:index.html.php', array('userCanEdit' => $userCanEdit, 'project_id' => $project_id, 'task_id' => "300", 'real_TaskID' => $real_TaskID)); ?>
					</div>
				</div>

			</div>

		</div>
					
		<div class="col-xs-4 sidebar_bg">
			<?php echo $view->render('InitiativeAppBundle:Inc:CampaignSidebar/index.html.php', array('campaignName' => $campaign['Campaign']['CampaignName'], 'userCanEdit' => $userCanEdit, 'project_id' => $project_id, 'task_id' => "300", 'real_TaskID' => $real_TaskID)); ?>
		</div>
	</div>
</div>