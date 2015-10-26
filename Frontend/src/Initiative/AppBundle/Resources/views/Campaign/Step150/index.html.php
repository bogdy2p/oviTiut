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

?>
<div class="container-fluid min-height">
	<div class="row" style="display: flex;">
		<div class="col-xs-8 evo-white-bg min-height" style="padding-top: 20px;">
			<div class="col-xs-offset-10 col-xs-offset-2 min-height">
				
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
					<form name="update_jtbd" id="update_jtbd" action="<?php echo $this->container->getParameter('apiUrl'); ?>campaigns/<?php echo $project_id; ?>/jtbd.json" method="PUT">
					<div class="col-xs-12">
						<textarea class="form-control" name="brief_outline"><?php echo $campaign['Campaign']['Brief_outline']; ?></textarea>
						<div class="evo-space"></div>
					</div>
					<div class="col-xs-6">
						<h1 class="evo-header-small margin-top-0 evo-ff4">MMOs</h1>
						<input name="mmo_brandshare" class="form-control" value="<?php echo $campaign['Campaign']['MMO_brandshare']; ?>">
						<div class="evo-space"></div>
						<input name="mmo_penetration" class="form-control" value="<?php echo $campaign['Campaign']['MMO_penetration']; ?>">
						<div class="evo-space"></div>
						<input name="mmo_salesgrowth" class="form-control" value="<?php echo $campaign['Campaign']['MMO_salesgrowth']; ?>">
						<div class="evo-space"></div>
						<input name="mmo_othermetric" class="form-control" value="<?php echo $campaign['Campaign']['MMO_othermetric']; ?>">
					</div>
					<div class="col-xs-6">
						<h1 class="evo-header-small margin-top-0 evo-ff4">MCOs</h1>
						<input name="mco_brandhealth_bhc" class="form-control" value="<?php echo $campaign['Campaign']['MMO_brandhealth_bhc']; ?>">
						<div class="evo-space"></div>
						<input name="mco_awareness_increase" class="form-control" value="<?php echo $campaign['Campaign']['MMO_awareness_increase']; ?>">
						<div class="evo-space"></div>
						<input name="mco_brandhealth_performance" class="form-control" value="<?php echo $campaign['Campaign']['MMO_brandhealth_performance']; ?>">
					</div>			
					</form>
				</div>

			</div>

		</div>
					
		<div class="col-xs-4 sidebar_bg">
			<?php echo $view->render('InitiativeAppBundle:Inc:CampaignSidebar/index.html.php', array('campaignName' => $campaign['Campaign']['CampaignName'], 'project_id' => $project_id, 'task_id' => "100", 'real_TaskID' => $real_TaskID)); ?>
		</div>
	</div>
</div>