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


$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/createurl";


$ch = curl_init(); 

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$result=curl_exec($ch);
curl_close($ch);

$obj = json_decode($result, true);
$matrixLink = $obj['Matrix Link'];



$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/editurl";


$ch = curl_init(); 

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$result=curl_exec($ch);
curl_close($ch);

$obj = json_decode($result, true);
$matrixLink2 = $obj['Matrix Link'];




$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/files";

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
	if($filename == "Reckoner") {
		$reckoner = $file_list['files'][$i]['FilePath'];
	}
	if($filename == "Strategic Clarity") {
		$clarity = $file_list['files'][$i]['FilePath'];
	}
	$i++;
}




?>
<div class="container-fluid" style="display: flex; align-items: stretch;">
	<div class="row" style="display: flex;">
		<div class="col-xs-8 evo-white-bg" style="padding-top: 20px;">
			<div class="col-xs-offset-10 col-xs-offset-1 min-height campaign-content-container">
	
				<div class="row get_api" data-api="<?php echo $_COOKIE['api']; ?>">
					<div class="col-xs-12">
						<p class="evo-text-smaller-upper">
							<a class="small-header-link" href="<?php echo $view['router']->generate('initiative_app_project', array('project_id' => $project_id, 'step_id' => 0)); ?>">
								<i class="fa fa-chevron-left"></i> CAMPAIGN: <?php echo $campaign['Campaign']['CampaignName']; ?>
							</a>
						</p>
						<h1 class="evo-header-big margin-top-0 text-swap font_stack_4">JTBD: Jobs to be done</h1>
						<div class="evo-space"></div>
					</div>


					<div class="col-xs-12">
						<div class="task_bar">
							<?php if($userCanEdit) { ?>
								<div class="task_bar_left">								
									<?php
									if($campaign['Campaign']['Campaign_Start_Date'] != null || $campaign['Campaign']['Survey'] != null || $campaign['Campaign']['Budget'] != null || $campaign['Campaign']['Campaign_End_Date'] != null || $campaign['Campaign']['Target'] != null || $campaign['Campaign']['Currency']) {?>									
										<a href="<?php echo $matrixLink; ?>" class="show_confirm"><button class="btn evo-btn-2">Change Survey Data</button></a>
										<a href="<?php echo $matrixLink2; ?>&screen=100"><button class="btn evo-btn-2">Update Project Information</button></a>
									<?php } else { ?>
										<a href="<?php echo $matrixLink; ?>"><button class="btn evo-btn-2">Launch Matrix</button></a>
									<?php } ?>
								</div>
							<?php } ?>
							<div class="task_bar_right">
								<span class="evo-text-smaller">
									
										<a href="<?php echo $this->container->getParameter('fileUrl'); ?>uploads/template_files/targetreckoner-template.xlsx">
											<i class="fa fa-cloud-download"></i> 
											reckoner template
										</a>
								
								</span>
								<span class="evo-text-smaller">
									
										<a href="<?php echo $this->container->getParameter('fileUrl'); ?>uploads/template_files/Strategic Clarity.pptx">
											<i class="fa fa-cloud-download"></i> 
											clarity matrix template
										</a>
									
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
					</div>

					<div class="col-xs-12">
						<h1 class="evo-header-small margin-top-0 evo-ff4">Matrix Data</h1>
					</div>

					<div class="col-xs-6">
						<label style="border-top-width: 0px; padding-top: 0px; margin-top: 0px;">Campaign Start Date</label>
						<input name="Campaign_Start_Date" class="form-control" placeholder="Campaign Start Date" <?php if($campaign['Campaign']['Campaign_Start_Date']) { echo "value=\"".$campaign['Campaign']['Campaign_Start_Date']."\""; }?> disabled>
						<div class="evo-space"></div>
						<label style="border-top-width: 0px; padding-top: 0px; margin-top: 0px;">Region</label>
						<input name="Region" class="form-control" placeholder="Region" <?php if($campaign['Campaign']['Region']) { echo "value=\"".$campaign['Campaign']['Region']."\""; }?> disabled>
						<div class="evo-space"></div>
						<label style="border-top-width: 0px; padding-top: 0px; margin-top: 0px;">Survey</label>
						<input name="Survey" class="form-control" placeholder="Survey" <?php if($campaign['Campaign']['Survey']) { echo "value=\"".$campaign['Campaign']['Survey']."\""; }?> disabled>
						<div class="evo-space"></div>
						<label style="border-top-width: 0px; padding-top: 0px; margin-top: 0px;">Budget</label>
						<input name="Budget" class="form-control" placeholder="Budget" <?php if($campaign['Campaign']['Budget']) { echo "value=\"".$campaign['Campaign']['Budget']."\""; }?> disabled>
					</div>
					<div class="col-xs-6">
						<label style="border-top-width: 0px; padding-top: 0px; margin-top: 0px;">Campaign End Date</label>
						<input name="Campaign_End_Date" class="form-control" placeholder="Campaign End Date" <?php if($campaign['Campaign']['Campaign_End_Date']) { echo "value=\"".$campaign['Campaign']['Campaign_End_Date']."\""; }?> disabled>
						<div class="evo-space"></div>
						<label style="border-top-width: 0px; padding-top: 0px; margin-top: 0px;">Country</label>
						<input name="Country" class="form-control" placeholder="Country" <?php if($campaign['Campaign']['Country']) { echo "value=\"".$campaign['Campaign']['Country']."\""; }?> disabled>
						<div class="evo-space"></div>
						<label style="border-top-width: 0px; padding-top: 0px; margin-top: 0px;">Target</label>
						<input name="Target" class="form-control" placeholder="Target" <?php if($campaign['Campaign']['Target']) { echo "value=\"".$campaign['Campaign']['Target']."\""; }?> disabled>
						<div class="evo-space"></div>
						<label style="border-top-width: 0px; padding-top: 0px; margin-top: 0px;">Currency</label>
						<input name="Currency" class="form-control" placeholder="Currency" <?php if($campaign['Campaign']['Currency']) { echo "value=\"".$campaign['Campaign']['Currency']."\""; }?> disabled>
					</div>


					<div class="evo-space-biggest"></div>
			


					<div class="col-xs-12">
						<div class="row">
							<form name="update_jtbd" id="update_jtbd" action="<?php echo $this->container->getParameter('apiUrl'); ?>campaigns/<?php echo $project_id; ?>/jtbd.json" method="PUT">
								<div class="col-xs-12">
									<h1 class="evo-header-small margin-top-0 evo-ff4">The Brief</h1>
									<textarea class="form-control" name="brief_outline" <?php if(!$userCanEdit){ echo 'disabled'; } ?>><?php 
											if($campaign['Campaign']['Brief_outline']) { 
												echo $campaign['Campaign']['Brief_outline']; 
											} else { 
												echo "Enter the brief outline"; 
											} 
										?>
									</textarea>
									<div class="evo-space"></div>
								</div>
								<div class="col-xs-6">
									<h1 class="evo-header-small margin-top-0 evo-ff4">MMOs</h1>
									<label style="border-top-width: 0px; padding-top: 0px; margin-top: 0px;">MMO Brandshare</label>
									<input name="mmo_brandshare" class="form-control" placeholder="Brand Share %" <?php if($campaign['Campaign']['MMO_brandshare']) { echo "value=\"".$campaign['Campaign']['MMO_brandshare']."\""; } if(!$userCanEdit){ echo 'disabled'; } ?>>
									<div class="evo-space"></div>
									<label style="border-top-width: 0px; padding-top: 0px; margin-top: 0px;">MMO Penetration</label>
									<input name="mmo_penetration" class="form-control" placeholder="Penetration %" <?php if($campaign['Campaign']['MMO_penetration']) { echo "value=\"".$campaign['Campaign']['MMO_penetration']."\""; } if(!$userCanEdit){ echo 'disabled'; } ?>>
									<div class="evo-space"></div>
									<label style="border-top-width: 0px; padding-top: 0px; margin-top: 0px;">MMO Salesgrowth</label>
									<input name="mmo_salesgrowth" class="form-control" placeholder="Sales Growth %" <?php if($campaign['Campaign']['MMO_salesgrowth']) { echo "value=\"".$campaign['Campaign']['MMO_salesgrowth']."\""; } if(!$userCanEdit){ echo 'disabled'; } ?>>
									<div class="evo-space"></div>
									<label style="border-top-width: 0px; padding-top: 0px; margin-top: 0px;">MMO Other Metric</label>
									<input name="mmo_othermetric" class="form-control" placeholder="Other Metric %" <?php if($campaign['Campaign']['MMO_othermetric']) { echo "value=\"".$campaign['Campaign']['MMO_othermetric']."\""; } if(!$userCanEdit){ echo 'disabled'; } ?>>
								</div>
								<div class="col-xs-6">
									<h1 class="evo-header-small margin-top-0 evo-ff4">MCOs</h1>
									<label style="border-top-width: 0px; padding-top: 0px; margin-top: 0px;">MCO Brand Health HBC</label>
									<input name="mco_brandhealth_bhc" class="form-control" placeholder="Brand Health HBC" <?php if($campaign['Campaign']['MMO_brandhealth_bhc']) { echo "value=\"".$campaign['Campaign']['MMO_brandhealth_bhc']."\""; } if(!$userCanEdit){ echo 'disabled'; } ?>>
									<div class="evo-space"></div>
									<label style="border-top-width: 0px; padding-top: 0px; margin-top: 0px;">MCO Awareness Increase</label>
									<input name="mco_awareness_increase" class="form-control" placeholder="Brand Awareness Increase" <?php if($campaign['Campaign']['MMO_awareness_increase']) { echo "value=\"".$campaign['Campaign']['MMO_awareness_increase']."\""; } if(!$userCanEdit){ echo 'disabled'; } ?>>
									<div class="evo-space"></div>
									<label style="border-top-width: 0px; padding-top: 0px; margin-top: 0px;">MCO Brand Health Performance</label>
									<input name="mco_brandhealth_performance" class="form-control" placeholder="Brand Health Performance" <?php if($campaign['Campaign']['MMO_brandhealth_performance']) { echo "value=\"".$campaign['Campaign']['MMO_brandhealth_performance']."\""; } if(!$userCanEdit){ echo 'disabled'; } ?>>
								</div>
								<div class="col-xs-12">
									<div class="evo-space"></div>
									<div class="row">
										<div class="col-xs-3">
											<?php if($userCanEdit) {
												echo '<button type="submit" class="evo-btn-2 btn">Submit Data</button>';
											} ?>
										</div>
										<div class="col-xs-2" style="position: relative; left: -30px;">
											<p class="evo-text-smaller save-data evo-black"> <i class="fa fa-spinner fa-spin"></i> <span>saving</span></p>
										</div>
									</div>

								</div>
							</form>
						</div>
					</div>


					<div class="col-xs-12">
						<div class="evo-space-biggest"></div>
						<div class="row" style="display: flex;">

							<div class="col-xs-6">
								<?php if(isset($reckoner)) { ?>
									<div class="file_info_container">
										<div class="file_task_icon">
											<img src="<?php echo $view['assets']->getUrl('img/file_ham.png'); ?>" width="15" height="15">
											<div class="box_file_tout">
												<ul>
													<?php if($userCanEdit) { ?>
														<li><a href="#" class="replace_file_1" data-text=" attach completed reckoner">Replace File</a></li>
													<?php } ?>
													<li>
														<a href="<?php echo $view['router']->generate('initiative_app_download_file'); ?>?task_name_id=1&file_type_id=20&campaign_id=<?php echo $project_id; ?>">
															Download File
														</a>
													</li>
												</ul>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>

							<div class="col-xs-6">
								<?php if(isset($clarity)) { ?>
									<div class="file_task_icon">
										<img src="<?php echo $view['assets']->getUrl('img/file_ham.png'); ?>" width="15" height="15">
										<div class="box_file_tout">
											<ul>
												<?php if($userCanEdit) { ?>
													<li><a href="#" class="replace_file_2" data-text=" attach strategic clarity PPT">Replace File</li></li>
												<?php } ?>
												<li>
													<a href="<?php echo $view['router']->generate('initiative_app_download_file'); ?>?task_name_id=1&file_type_id=21&campaign_id=<?php echo $project_id; ?>">
														Download File
													</a>
												</li>
											</ul>
										</div>
									</div>
								<?php } ?>
							</div>

						</div>
						<div class="row">
							<div class="col-xs-12">
								<div class="evo-space"></div>
							</div>
						</div>

						<div class="row" style="display: flex;">


							<div class="col-xs-6" style="display: flex;">
								<div class="file_box file_1<?php if(!isset($reckoner) && $userCanEdit){echo " file_drop_1";}?>" data-form-id="1" data-project-id="<?php echo $project_id; ?>" data-task-id="<?php echo $real_TaskID; ?>" data-task-type="20">
									<?php if(isset($reckoner)) { ?>
										<a href="<?php echo $view['router']->generate('initiative_app_download_file'); ?>?task_name_id=1&file_type_id=20&campaign_id=<?php echo $project_id; ?>">
											<i class="fa fa-cloud-download"></i> 
											download completed reckoner
										</a>
									<?php } elseif(!$userCanEdit) {	?>
										<i class="fa fa-file-o"></i> completed reckoner not available
									<?php } else { ?>
										<i class="fa fa-file-o"></i> attach completed reckoner
									<?php } ?>
								</div>
							</div>

							<div class="col-xs-6" style="display: flex;">
								<div class="file_box file_2<?php if(!isset($clarity) && $userCanEdit){echo " file_drop_2";}?>" data-form-id="2" data-project-id="<?php echo $project_id; ?>" data-task-id="<?php echo $real_TaskID; ?>" data-task-type="21">								
									<?php if(isset($clarity)) { ?>
										<a href="<?php echo $view['router']->generate('initiative_app_download_file'); ?>?task_name_id=1&file_type_id=21&campaign_id=<?php echo $project_id; ?>">
											<i class="fa fa-cloud-download"></i> 
											download strategic clarity PPT
										</a>
									<?php } elseif(!$userCanEdit) {	?>
										<i class="fa fa-file-o"></i> clarity PPT not available
									<?php } else { ?>
										<i class="fa fa-file-o"></i> attach strategic clarity PPT
									<?php } ?>
								</div>
							</div>

						</div>
					</div>

					<div class="col-xs-12">
						<div class="evo-space-biggest"></div>
						<?php echo $view->render('InitiativeAppBundle:Files:index.html.php', array('userCanEdit' => $userCanEdit, 'project_id' => $project_id, 'task_id' => "100", 'real_TaskID' => $real_TaskID)); ?>
					</div>
				</div>

			</div>

		</div>
					
		<div class="col-xs-4 sidebar_bg">
			<?php echo $view->render('InitiativeAppBundle:Inc:CampaignSidebar/index.html.php', array('campaignName' => $campaign['Campaign']['CampaignName'], 'userCanEdit' => $userCanEdit, 'project_id' => $project_id, 'task_id' => "100", 'real_TaskID' => $real_TaskID)); ?>
		</div>
	</div>
</div>