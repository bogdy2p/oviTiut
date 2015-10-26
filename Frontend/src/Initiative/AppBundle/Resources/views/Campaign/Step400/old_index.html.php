
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




$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/idea";

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

$idea = json_decode($result, true);
$campaignIdeaDesc = $idea['campaign_idea'];
$campaignIdeaTitle = $idea['campaign_idea_title'];



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
	if($filename == "Output" && $TaskName == "Media Idea") {
		$media = $file_list['files'][$i]['FilePath'];
	}
	$i++;
}



?>
<div class="container-fluid min-height" style="display: flex; align-items: stretch;"> 
	<div class="row min-height" style="display: flex;">
		<div class="col-xs-8 evo-white-bg min-height" style="padding-top: 20px;">
			<div class="col-xs-offset-10 col-xs-offset-2 min-height">
				
				<div class="row get_api" data-api="<?php echo $_COOKIE['api']; ?>">
					<div class="col-xs-12">
						<p class="evo-text-smaller-upper">
							<a class="small-header-link" href="<?php echo $view['router']->generate('initiative_app_project', array('project_id' => $project_id, 'step_id' => 0)); ?>">
								<i class="fa fa-chevron-left"></i> CAMPAIGN: <?php echo $campaign['Campaign']['CampaignName']; ?>
							</a>
						</p>
						<h1 class="evo-header-big margin-top-0 text-swap font_stack_4">Media Idea</h1>
						<div class="evo-space"></div>
					</div>

					<div class="col-xs-12">
						<div class="task_bar">
							<div class="task_bar_left">								
								<a href=""><button class="btn evo-btn-2">Edit Score Card</button></a>
							</div>
							<div class="task_bar_right">
								<span class="evo-text-smaller"><a href="http://dashboard3.itstrategists.com/api/uploads/template_files/Scorecard%20design%20template.pptx" download><i class="fa fa-cloud-download"></i> download template</a></span>
							</div>
							<div class="task_bar_far_right">
								<!-- generate powerpoint -->
								<a href="#"><span class="export_ppt"><i class="fa fa-share" title="Generate PowerPoint"></i></span></a>
							</div>
						</div>
					</div>

					<div class="col-xs-12">
						<?php if(isset($media)) { ?>
							<div class="file_info_container">
								<div class="file_task_icon">
									<img src="<?php echo $view['assets']->getUrl('img/file_ham.png'); ?>" width="15" height="15">
									<div class="box_file_tout">
										<ul>
											<li><a href="#" class="replace_file_1" data-text=" attach completed score card">Replace File</a></li>
											<li><a href="<?php echo $this->container->getParameter('fileUrl').$media; ?>" download>Download File</a></li>
										</ul>
									</div>
									<div class="evo-space"></div>
								</div>
							</div>
						<?php } ?>
					</div>

					<div class="col-xs-12">
						<div class="row" style="display: flex;">
							<div class="col-xs-12" style="display: flex;">
								<div class="file_box file_1<?php if(!isset($media)){echo " file_drop_1";}?>" data-form-id="1" data-project-id="<?php echo $project_id; ?>" data-task-id="<?php echo $real_TaskID; ?>" data-task-type="11">
									<?php if(isset($media)) { ?>
									<a href="<?php echo $this->container->getParameter('fileUrl').$media; ?>" download><i class="fa fa-cloud-download"></i> download completed score card</a>
								<?php } else {	?>
									<i class="fa fa-file-o"></i> attach completed score card
								<?php }
								?>
								</div>
							</div>
						</div>
						<div class="evo-space-biggest"></div>
					</div>



					<div class="col-xs-12">
						<div class="evo-space"></div>
						<h4>The Campaign Idea</h4>

						<form name="update_campaignidea" id="update_campaignidea" action="<?php echo $this->container->getParameter('apiUrl'); ?>campaigns/<?php echo $project_id; ?>/idea.json" method="PUT">
							<input name="campaign_idea_title" placeholder="Enter a title" <?php if($campaignIdeaTitle) {echo " value=\"".$campaignIdeaTitle."\"";}?> class="form-control"></input>
							<textarea class="form-control" name="campaign_idea"><?php if($campaignIdeaDesc) { echo $campaignIdeaDesc; } else { echo "Enter the campaign idea description"; } ?></textarea>
							<div class="row">
								<div class="col-xs-2">
									<?php
										if($campaignIdeaTitle || $campaignIdeaDesc) { ?>
											<button type="submit" class="evo-btn btn">update</button>
										<?php } else { ?>
											<button type="submit" class="evo-btn btn">submit</button>
									<?php } ?>
								</div>
								<div class="col-xs-3">
									<p class="evo-text-smaller save-data"> <i class="fa fa-spinner fa-spin"></i> <span>saving</span></p>
								</div>
							</div>
						</form>
					</div>

					<div class="col-xs-12">
						<div class="evo-space"></div>
						<?php echo $view->render('InitiativeAppBundle:Files:index.html.php', array('project_id' => $project_id, 'task_id' => "400", 'real_TaskID' => $real_TaskID)); ?>
					</div>
				</div>

			</div>

		</div>
					
		<div class="col-xs-4 sidebar_bg">
			<?php echo $view->render('InitiativeAppBundle:Inc:CampaignSidebar/index.html.php', array('campaignName' => $campaign['Campaign']['CampaignName'], 'project_id' => $project_id, 'task_id' => "400", 'real_TaskID' => $real_TaskID)); ?>
		</div>
	</div>
</div>