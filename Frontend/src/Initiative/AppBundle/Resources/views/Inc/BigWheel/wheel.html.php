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

$result2=curl_exec($ch);
curl_close($ch);

$obj2 = json_decode($result2, true);


$campaignName = $obj2['Campaign']['CampaignName'];
$clientName = $obj2['Campaign']['ClientName'];
$country = $obj2['Campaign']['Country'];
$brand = $obj2['Campaign']['Brand'];
$product = $obj2['Campaign']['Product'];
$productLine = $obj2['Campaign']['Productline'];
$campaignStatus = $obj2['Campaign']['CampaignStatus'];
$completionDate = $obj2['Campaign']['CompletionDate'];
$campaignLastModifiedDate = $obj2['Campaign']['CampaignLastModifiedDate'];
$clientDeliverabledate = $obj2['Campaign']['ClientDeliverabledate'];
$presentedToClient = $obj2['Campaign']['PresentedToClient'];
$division = $obj2['Campaign']['Division'];
$PresentedToClient = $obj2['Campaign']['PresentedToClient'];

$project_urgency = $obj2['Campaign']['Urgency'];
$completionScore = $obj2['Campaign']['Completeness'];


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

$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/teammembers";

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


$totalTeamMembers = count($obj['teammembers']);

$i = 0;
$memberArray = array();
while($i <= $totalTeamMembers-1) {
	$memberId = $obj['teammembers'][$i]['user_id'];
	array_push($memberArray, $memberId);
	$i++;
}

$i = 0;
$reviwerArray = array();
while($i <= $totalTeamMembers-1) {
	$memberId = $obj['teammembers'][$i]['user_id'];
	if($obj['teammembers'][$i]['is_reviewer']) {
		array_push($reviwerArray, $memberId);
	}
	$i++;
}








$url = $this->container->getParameter('apiUrl')."users";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$result3=curl_exec($ch);
curl_close($ch);

$obj3 = json_decode($result3, true);

// var_dump($obj);

$users = $obj3['users'];

$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/tasks";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$result4=curl_exec($ch);
curl_close($ch);

$obj4 = json_decode($result4, true);

$totalTasks = count($obj4['Tasks']);




$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/files";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$files=curl_exec($ch);
curl_close($ch);

$files = json_decode($files, true);

$totalFiles = count($files['files']);

$filesRemoved = 0;

$url = $this->container->getParameter('apiUrl')."users/".$_COOKIE['dash_user_id']."/profile.json";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$result2=curl_exec($ch);
curl_close($ch);
$myProfile = json_decode($result2, true)[0];
$userCanEdit = ($myProfile['user_role'] != 'Viewer') 

?>

<div class="opacity"></div>

<div id="file_modal">
	<?php echo $view->render('InitiativeAppBundle:Files:index.html.php', array('userCanEdit' => $userCanEdit, 'project_id' => $project_id)); ?>
</div>


<div id="new_campaign_container">
	<?php echo $view->render('InitiativeAppBundle:EditCampaign:index.html.php', array('project_id' => $project_id)); ?>
</div>

<div id="members_container">
</div>



<div class="container-fluid" id="wheel_chalk_bg" style="position: relative;">
	<div id="wheel_chalk_bg_2"></div>
	<div class="project_info">
		<div class="row" style="margin-top: -20px;">
			<div class="col-xs-5 evo-white-bg">
				<div class="row project_data_sidebar" style="padding-bottom: 20px;">
					<div class="col-xs-10 col-xs-offset-2">
						<?php 
						$i = 0;
						$jsonData = file_get_contents("js/data.json");
						$json = json_decode($jsonData, true);

						$arrayLength = count($json['wheel']['phases']);
						?>
						
						<div class="evo-space"></div>
						
						<div class="row">
							<div class="col-xs-10">
								<p class="evo-text-smaller-upper">Campaign overview</p>
							</div>
							<div class="col-xs-2">
								<?php if($userCanEdit) { ?>
									<span class="evo-text-right">
										<a class="edit_campaign_btn" href="<?php echo $view['router']->generate('initiative_app_editProject', array('project_id' => $project_id)); ?>">
											<i class="fa fa-pencil"></i>
										</a>
									</span>
								<?php } ?>
							</div>
						</div>
						
						<div class="row">
							<div class="col-xs-12">
								<h1 class="evo-header-big margin-top-0 text-swap font_stack_4"><?php echo $clientName."-".$campaignName; ?></h1>
								<table class="basic_table">
									<tr>
										<td>
											<p class="evo-text-smaller"><?php echo $brand; ?></p>
										</td>
										<td>
											<p class="evo-text-smaller"><?php echo $productLine; ?></p>
										</td>
									</tr>
									<tr>
										<td>
											<p class="evo-text-smaller"><?php echo $country; ?></p>
										</td>
										<td>
											<p class="evo-text-smaller"><?php echo $completionDate."-".$clientDeliverabledate; ?></p>
										</td>
									</tr>
								</table>
							</div>
						</div> <!-- /row -->
						
						<div class="evo-space"></div>
						
						<div class="row">
							<div class="col-xs-10">
								<p class="evo-text-smaller-upper" style="padding-bottom: 10px;">team members</p>
							</div>
							<div class="col-xs-2">
								<span class="evo-text-right"><a class="show_add_member" href="<?php echo $view['router']->generate('initiative_app_memberManagement', array('project_id' => $project_id)); ?>"><i class="fa fa-user-plus"></i></a></span>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12">
								<div class="team_members_list evo-no-bullets">
									<!-- members output -->
									<ul>
									<?php

										function url_exists($url) { 
										 $handle = @fopen($url, "r"); 
										 if ($handle === false) 
										 	return false; 
										 fclose($handle); 
											return true; 
										} 

										$i = 0;
										while($i <= $totalTeamMembers-1) {
											${'userImg_'.$obj['teammembers'][$i]['user_id']} = $obj['teammembers'][$i]['Profile Picture location'];
											echo "<li>";
											echo "<div class=\"member_group\" data-memberId=\"".$obj['teammembers'][$i]['user_id']."\">";

												echo "<div class=\"member_photo\">";
													
													if($obj['teammembers'][$i]['Profile Picture location']) {
													
														$query = url_exists($obj['teammembers'][$i]['Profile Picture location']); 
														if ($query) {
															echo "<div class=\"photo\" style=\"background-image: url('".$obj['teammembers'][$i]['Profile Picture location']."');\"></div>";
														} else {
															echo "<div class=\"photo\" style=\"background-image: url('".$view['assets']->getUrl('img/no-face.png')."');\"></div>";
														}

													} else {
														echo "<div class=\"photo\" style=\"background-image: url('".$view['assets']->getUrl('img/no-face.png')."');\"></div>";
													}
													echo "<span><a href=\"mailto:".$obj['teammembers'][$i]['Email Adress']."?subject=RE: ".$clientName."-".$campaignName."&body=http://unilever.humanig.com/campaign/".$project_id."/0\"><div class=\"circle_container\"><div class=\"email_address\"><i class=\"fa fa-envelope-o\"></i></div></div></a></span>";
												echo "</div>";


												echo "<div class=\"member_info\">";
													echo "<p class=\"evo-text-small\">".$obj['teammembers'][$i]['First Name'] ." ". $obj['teammembers'][$i]['Last Name'];
														if($obj['teammembers'][$i]['is_reviewer'] == "true") {
															echo "<a href=\"#\" class=\"toggle_review\" data-project-id=\"".$project_id."\" data-memberId=\"".$obj['teammembers'][$i]['user_id']."\"><i class=\"fa fa-star evo-green\"></i></a>";
														} else {
															echo "<a href=\"#\" class=\"toggle_review\" data-project-id=\"".$project_id."\" data-memberId=\"".$obj['teammembers'][$i]['user_id']."\"><i class=\"fa fa-star not_reviewer\"></i></a>";						
														}
													echo "</p>";
											
													echo "<p class=\"evo-text-smaller\">";
														$p = 0;
														$taskArray = array();
														while($p <= $totalTasks-1) {
															if($obj['teammembers'][$i]['user_id'] == $obj4['Tasks'][$p]['TaskOwnerUserID']) {
																${'task_'.$p} = $obj4['Tasks'][$p]['TaskName'];
																array_push($taskArray, $obj4['Tasks'][$p]['TaskName']);
															} 
															$p++;
														}
														$ca = 0;
														$countArray = count($taskArray);
														while($ca <= $countArray-1) {
															echo $taskArray[$ca];
															if($ca != $countArray-1) {
																echo ", ";
															}
															$ca++;
														}
														if($countArray == 0) {
															echo "&nbsp;&nbsp;";
														}
													echo "</p>";

												echo "</div>";
											
											echo "</div>";

											echo "<div class=\"delete_user get_project_id\" data-project-id=\"".$project_id."\"><a href=\"#\"><i class=\"fa fa-trash-o remove-user\" data-memberId=\"".$obj['teammembers'][$i]['user_id']."\"></i></a></div>";											

											echo "</li>";
											$i++;
										}
									?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php  $step = $completionScore; ?> 
			</div>
			<div class="col-xs-5 col-xs-offset-1">

				<div class="wheel_holder">
					<div class="wheel_container_2">
						<div class="phase_circle">

							<?php include('img/wheel/wheel.php'); ?>
							<?php 
							$i = 0;
							echo "<style>";
							while($i <= $arrayLength-1) {
								$status = $obj4['Tasks'][$i]['LatestTaskStatus'];

								if(isset(${'userImg_'.$obj4['Tasks'][$i]['TaskOwnerUserID']})) {
									$avatarUrl = ${'userImg_'.$obj4['Tasks'][$i]['TaskOwnerUserID']};
								} 
								else {
									$avatarUrl = $view['assets']->getUrl('img/no-face.png');
								} 
								if(!file_exists($avatarUrl)) {
									$avatarUrl = $view['assets']->getUrl('img/no-face.png');
								}



								if($status == "Completed") {
									$fill = "#04de99";
								}
								elseif($status == "Open") {
									$fill = "#e5e5e5";
								}
								elseif($status == "Submitted") {
									$fill = "#f8b429";
								}
								$phase = $i+1;
								echo ".wheel_circle".$phase. "{";
								if($avatarUrl == null) {
									$avatarUrl = $view['assets']->getUrl('img/no-face.png');
								}
								echo "background-image: url(".$avatarUrl.");";
								echo "}";
								echo ".outter_dots div:nth-of-type(".$phase.") {";
								echo "border-color:".$fill." !important;";
								echo "}";
								echo ".wheel_phase".$phase. "{";
								echo "fill:".$fill;
								echo "}";
								$i++;
							}
							echo "</style>";
							?>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
			
<div class="tasks_right">
	<!--  -->
	<a href="#" class="campaign_presented" data-project-id="<?php echo $project_id; ?>" data-campaign-status="<?php echo $campaignStatus; ?>">

		<div class="svg_box_bg">
			<svg viewBox="0 0 183.003 179.986">
				<g class="svg_box_bg_opacity">
					<path fill="#000" d="M177.935,1.404c-0.193,0.543,4.505,0.591-0.178-0.081c-2.937-0.42-5.691-0.805-8.673-0.934
						c-5.911-0.256-11.831,0.803-17.739,0.374c-22.382-1.627-44.11,2.263-66.366,1.656C74.266,2.126,58.884-2.655,49.664,2.086
						C33.603,1.659,15.71,5.318-0.001,8.6c6.29-1.313,0.207,62.418,1.412,68.702c1.923,10.033,1.422,13.354,0.352,23.809
						c-0.792,7.743,2.471,14.653,2.963,22.244c0.559,8.612-1.412,17.638-1.586,26.299c-0.18,8.936,3.462,19.849,1.429,28.277
						l3.488-0.001c19.18,6.13,43.367-3.722,53.938-0.412c18.73,2.468,47.089-4.612,59.402-3.804c16.202,1.063,48.897-5.057,61.605,4.217
						c-4.933-13.036-5.101-40.87-5.513-54.727c-0.438-14.711,5.409-28.372,5.511-42.727c0.094-13.048-8.798-22.413-9.224-36.115
						c-0.414-13.261-0.248-28.823,5.709-40.781c-0.389-0.253-4.763-2.44-4.877-2.126"/>
				</g>
				<g class="svg_box_bg_outline">
					<path fill="none" stroke="#FFFFFF" stroke-width="2" stroke-miterlimit="15" d="M177.936,1.404c-0.194,0.543,4.504,0.591-0.179-0.081
						c-2.936-0.42-5.69-0.805-8.672-0.934c-5.911-0.256-11.831,0.803-17.739,0.374c-22.382-1.627-44.11,2.263-66.366,1.656
						C74.266,2.126,58.884-2.655,49.665,2.086C33.603,1.659,15.711,5.318,0,8.6c6.29-1.313,0.206,62.418,1.411,68.702
						c1.923,10.033,1.422,13.354,0.352,23.809c-0.792,7.743,2.471,14.653,2.963,22.244c0.558,8.612-1.413,17.638-1.586,26.299
						c-0.179,8.936,3.462,19.849,1.429,28.277l3.488-0.001c19.18,6.13,43.367-3.722,53.938-0.412c18.73,2.468,47.089-4.612,59.402-3.804
						c16.202,1.063,48.897-5.057,61.604,4.217c-4.932-13.036-5.1-40.87-5.512-54.727c-0.438-14.711,5.408-28.372,5.511-42.727
						c0.093-13.048-8.797-22.413-9.224-36.115c-0.413-13.261-0.248-28.823,5.71-40.781c-0.389-0.253-4.763-2.44-4.877-2.126"/>
				</g>
			</svg>
		</div>
		<?
		if($campaignStatus == "Build") {
			$check = "unapproved";
			$check_text = "unapproved";
		}
		else {
			$check = "approved";
			$check_text = "approved_text";
		}
		?>
		<div class="file_count"><h1 class="evo-ff4  evo-text-center padding-top-0 padding-bottom-0"><i class="fa fa-check <?php echo $check; ?>"></i></h2> 
			<p class="evo-text-small evo-ff5 <?php echo $check_text; ?> evo-text-center loose">plan<br>approved</p>
		</div>
	</a>




	<a href="#" class="launch_files">
		<div class="svg_box_bg">
			<svg viewBox="0 0 183.003 179.986">
				<g class="svg_box_bg_opacity">
					<path fill="#000" d="M177.935,1.404c-0.193,0.543,4.505,0.591-0.178-0.081c-2.937-0.42-5.691-0.805-8.673-0.934
						c-5.911-0.256-11.831,0.803-17.739,0.374c-22.382-1.627-44.11,2.263-66.366,1.656C74.266,2.126,58.884-2.655,49.664,2.086
						C33.603,1.659,15.71,5.318-0.001,8.6c6.29-1.313,0.207,62.418,1.412,68.702c1.923,10.033,1.422,13.354,0.352,23.809
						c-0.792,7.743,2.471,14.653,2.963,22.244c0.559,8.612-1.412,17.638-1.586,26.299c-0.18,8.936,3.462,19.849,1.429,28.277
						l3.488-0.001c19.18,6.13,43.367-3.722,53.938-0.412c18.73,2.468,47.089-4.612,59.402-3.804c16.202,1.063,48.897-5.057,61.605,4.217
						c-4.933-13.036-5.101-40.87-5.513-54.727c-0.438-14.711,5.409-28.372,5.511-42.727c0.094-13.048-8.798-22.413-9.224-36.115
						c-0.414-13.261-0.248-28.823,5.709-40.781c-0.389-0.253-4.763-2.44-4.877-2.126"/>
				</g>
				<g class="svg_box_bg_outline">
					<path fill="none" stroke="#FFFFFF" stroke-width="2" stroke-miterlimit="15" d="M177.936,1.404c-0.194,0.543,4.504,0.591-0.179-0.081
						c-2.936-0.42-5.69-0.805-8.672-0.934c-5.911-0.256-11.831,0.803-17.739,0.374c-22.382-1.627-44.11,2.263-66.366,1.656
						C74.266,2.126,58.884-2.655,49.665,2.086C33.603,1.659,15.711,5.318,0,8.6c6.29-1.313,0.206,62.418,1.411,68.702
						c1.923,10.033,1.422,13.354,0.352,23.809c-0.792,7.743,2.471,14.653,2.963,22.244c0.558,8.612-1.413,17.638-1.586,26.299
						c-0.179,8.936,3.462,19.849,1.429,28.277l3.488-0.001c19.18,6.13,43.367-3.722,53.938-0.412c18.73,2.468,47.089-4.612,59.402-3.804
						c16.202,1.063,48.897-5.057,61.604,4.217c-4.932-13.036-5.1-40.87-5.512-54.727c-0.438-14.711,5.408-28.372,5.511-42.727
						c0.093-13.048-8.797-22.413-9.224-36.115c-0.413-13.261-0.248-28.823,5.71-40.781c-0.389-0.253-4.763-2.44-4.877-2.126"/>
				</g>
			</svg>

		</div>

		<div class="file_count"><h1 class="evo-ff4 evo-blue evo-text-center padding-top-0 padding-bottom-0"><?php echo $totalFiles; ?></h2> 
			<p class="evo-text-small evo-ff5 evo-white evo-text-center loose">campaign<br>files</p>
		</div>
	</a>
</div>