<?php $view->extend('::base.html.php') ?>
<link rel="stylesheet/less" type="text/css" href="<?php echo $view['assets']->getUrl('css/jquery.dataTables.bootstrap.css') ?>">
<?php
if(isset($_COOKIE['api'])) {
	$url = $this->container->getParameter('apiUrl')."campaigns.json?filter=0";
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

	$campaigns_count = count($obj['Campaigns']);
	$campaigns = $obj['Campaigns'];
	$i = 0;



	$url = $this->container->getParameter('apiUrl')."users/".$_COOKIE['dash_user_id']."/info";
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
	$role = $obj2['user']['user_role_id'];


} else {
	header('Location: /login');
	die;
}

?>

<div class="container">
	<div class="row">
		<div class="offset-wrapper">
			<div class="evo-space"></div>
			<h2 class="evo-header-bigger">All Campaigns</h2>
			<!-- <div class="evo-space"></div> -->
			<table id="project-table" class="table"> 
				<thead> 
				<tr> 
					<th data-sort="string">Status</th>
				    <th data-sort="string">Client</th> 
				    <th data-sort="string">Division</th> 
				    <th data-sort="string">Brand</th> 
				    <th data-sort="string">Product Line</th> 
				    <th data-sort="string">Project<br />Name</th> 
				    <th data-sort="int">Start <br>Year</th>
				    <th data-sort="string">Market</th>
				    <?php 
				    	if($role == 3) { ?>
				    	<th class="disabled-sort"></th>
				    <?php } ?>
				</tr> 
				</thead> 
				<tbody> 
					<?php foreach ($campaigns as $project) { ?>
							<tr class="hover_row">
								<td><p class="evo-text-smaller"><?php echo $project['CampaignStatus']; ?></p></td>
								<td><p class="evo-text-smaller"><?php echo $project['ClientName']; ?></p></td>
								<td><p class="evo-text-smaller"><?php echo $project['Division']; ?></p></td>
								<td><p class="evo-text-smaller"><?php echo $project['Brand']; ?></p></td>
								<td><p class="evo-text-smaller"><?php echo $project['Productline']; ?></p></td>
								<td><p class="evo-text-smaller"><a href="campaign/<?php echo $project['CampaignID']; ?>/0"><?php echo $project['CampaignName']; ?></a></p></td>
								<td><p class="evo-text-smaller"></p></td>
								<td><p class="evo-text-smaller"><?php echo $project['Country']; ?></p></td>
								<?php 
				    				if($role == 3) { ?>
									<td><i class="fa fa-trash-o clickable hide_campaign" data-campaignId="<?php echo $project['CampaignID']; ?>"></i></td>
								<?php } ?>
							</tr>
							<?php $i++; ?>
					<?php } ?>
				</tbody> 
			</table> 
		</div>
	</div>
	<div class="evo-space-biggest"></div>
</div>