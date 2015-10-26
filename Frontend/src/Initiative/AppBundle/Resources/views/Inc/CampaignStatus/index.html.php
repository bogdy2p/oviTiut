<?php

$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/tasks/".$real_TaskID.".json";

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


$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/teammembers";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$result2=curl_exec($ch);
curl_close($ch);

$obj2 = json_decode($result2, true);

$totalTeamMembers = count($obj2['teammembers']);

$i = 0;
$reviwerArray = array();
while($i <= $totalTeamMembers-1) {
	$memberId = $obj2['teammembers'][$i]['user_id'];
	if($obj2['teammembers'][$i]['is_reviewer']) {
		array_push($reviwerArray, $memberId);
	}
	$i++;
}








?>


<style>
.collapsed {
	display: none;
}
.data_table {
	width: 100%;
}
.data_table thead tr th {
	border-bottom: 2px solid white;
}
.data_table tbody tr td, .data_table thead tr th {
	padding: 8px 0;
}
th.data_col div {
	display: inline-block;
	text-align: center;
	margin-bottom: 3px;
}
.circle-honey {
	background-color: white;
	background-image: url("<?php echo $view['assets']->getUrl('img/honey_logo.png') ?>");
	background-size: 20px;
	background-position: center;
	background-repeat: no-repeat;
}
input[type="text"], select, textarea {
	width: 100%;
	margin: 0;
	padding: 0;
	-webkit-appearance: none;
}
select:focus {
	border: 0;
	outline: 0;
}
textarea {
	height: 0;
	opacity: 0;
	margin: 10px 0;
	padding: 10px;
}
input[type="submit"] {
	-webkit-appearance: none;
	display: block;
	padding: 10px 5px;
	background-color: transparent;
	border: 1px solid #000;
}
input[type="submit"]:focus, textarea:focus {
	outline: 0;
}
.versions_row {
	overflow: hidden;
}
</style>


<p class="evo-text-smaller-upper evo-white">STATS</p>
<div class="evo-space"></div>
<table class="table data_table">
	<?php if($obj['TaskOwnerUserID']) { ?>
	<thead>
		<tr class="data_row">
			<!-- task owner -->
			<th class="data_col">
				<p class="evo-text-smaller evo-white">Task Owner</p>
			</th>
			<th class="data_col">
				<div class="evo-text-smaller evo-white">
					<?php echo $obj['TaskOwnerFirstName']." ". $obj['TaskOwnerLastName']; ?>
					<?php if(in_array($obj['TaskOwnerUserID'], $reviwerArray)) {echo "<i class=\"fa fa-star evo-green\"></i>";}?>
				</div>
				<div>
					<?php echo "<a href=\"mailto:".$obj['TaskOwnerEmailAddress']."?subject=".$campaignName." - ".$obj['TaskName']."&body=http://unilever.humanig.com/campaign/".$project_id."/".$task_id."\">"; ?>
					<div class="circle_container"><div class="email_address"><i class="fa fa-envelope-o"></i></div></div></a>
				</div>
				<?php
					$user_id = $obj['TaskOwnerUserID'];
					$url = $this->container->getParameter('apiUrl')."users/".$user_id."/profile.json";
					$api_key = $_COOKIE['api'];
					$api_header = array('x-wsse' => 'ApiKey="'.$api_key.'"');
					$response = Unirest\Request::get($url, $api_header);
					$user_profile = json_decode($response->raw_body, true)[0];
					$honey_id = $user_profile['honey_id'];
					$honey_link = "https://honey.is/home/#user/$honey_id/profile";
					if($honey_id) {
						echo '<div><a href="'.$honey_link.'"><div class="circle_container circle-honey"><div class="email_address"><i class="honey-link"></i></div></div></a><div>';
					}
				?>
			</th>
		</tr>
	</thead>
	<?php } ?>
	<tbody>
		<tr class="data_row">
			<!-- status -->
			<td colspan="2">
				<form name="update_status" id="update_status" action="<?php echo $this->container->getParameter('apiUrl'); ?>campaigns/<?php echo $project_id; ?>/tasks/<?php echo $real_TaskID; ?>" method="PUT">
				<select <?php if(!$userCanEdit) { echo "disabled style='background-image: none'"; } ?> name="status" id="project_status" class="select_default campaign-status-select">
					<option value="1" <?php if($obj['LatestTaskStatus'] == "Open") { echo " selected"; } ?>>Open</option>
					<option value="2" <?php if($obj['LatestTaskStatus'] == "Submitted") { echo " selected"; } ?>>Submitted</option>
					
					<?php 
					if (in_array($_COOKIE['dash_user_id'], $reviwerArray)) { ?>
						<option value="3" <?php if($obj['LatestTaskStatus'] == "Completed") { echo " selected"; } ?>>Completed</option>
					<?php } ?>
				</select>
		
				<div class="data_inner_row">
						<div class="project_status hidden">
							<textarea name="message" id="status_message" placeholder="Enter a Status Message"></textarea>
							
							<div class="row">
								<div class="col-xs-6">
									<button type="submit" class="evo-btn-2 btn">update status</button>
								</div>
								<div class="col-xs-5 col-xs-offset-1">
									<p class="evo-text-smaller save-data-2 evo-white"> <i class="fa fa-spinner fa-spin"></i> <span>saving</span></p>
								</div>
							</div>
		
		
						</div>
					</form>
				</div>
			</td>
		</tr>
		<?php if($obj['LatestTaskMessage']) { ?>
		<tr class="data_row">
			<!-- latest messages -->
			<td colspan="2">
				<p class="evo-text-smaller evo-white">
					<?php echo $obj['LatestTaskMessage']; ?>
				</p>
			</td>
		</tr>
		<?php } ?>
		
		<?php if($obj['MatrixVersionDate']) { ?>
		<tr class="data_row">
			<!-- last saved -->
			<td class="data_col">
				<p class="evo-text-smaller evo-white">Last Saved</p>
			</td>
			<td class="data_col">
				<p class="evo-text-smaller evo-white">
					<?php 
						$our_date = str_replace('EST', ' ',$obj['MatrixVersionDate']);
						$good_date = date('n/j/y g:ia',strtotime($our_date));
					?>
					<?php echo $good_date; ?>
				</p>
			</td>
		</tr>
		<?php } ?>
		<?php if($obj['MatrixFileVersion']) { ?>
		<tr class="data_row">
			<!-- tools version -->
			<td colspan="2" style="border-bottom: 0;">
				<a href="#" class="versions">
					<p class="evo-text-smaller evo-white">Version <?php echo $obj['MatrixFileVersion']; ?></p>
				</a>
			</td>
		</tr>
	</tbody>
	<?php } ?>
</table>
<div class="evo-space-bigger"></div>

