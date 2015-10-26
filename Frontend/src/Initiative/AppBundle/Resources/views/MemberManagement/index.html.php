<?php

$url = $this->container->getParameter('apiUrl')."users";

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

// var_dump($obj);

$users = $obj['users'];


$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/teammembers";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$result2=curl_exec($ch);
curl_close($ch);

$obj2 = json_decode($result2, true);

$totalMembers = count($obj2['teammembers']);

$i = 0;
$reviwerArray = array();
while($i <= $totalMembers-1) {
	$memberId = $obj2['teammembers'][$i]['user_id'];
	if($obj2['teammembers'][$i]['is_reviewer']) {
		array_push($reviwerArray, $memberId);
	}
	$i++;
}





$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/tasks";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$result3=curl_exec($ch);
curl_close($ch);

$obj3 = json_decode($result3, true);

$taskId1 = $obj3['Tasks'][0]['TaskID'];
$taskOwner1 = $obj3['Tasks'][0]['TaskOwnerFirstName']." ".$obj3['Tasks'][0]['TaskOwnerLastName'];

$taskId2 = $obj3['Tasks'][1]['TaskID'];
$taskOwner2 = $obj3['Tasks'][1]['TaskOwnerFirstName']." ".$obj3['Tasks'][1]['TaskOwnerLastName'];

$taskId3 = $obj3['Tasks'][2]['TaskID'];
$taskOwner3 = $obj3['Tasks'][2]['TaskOwnerFirstName']." ".$obj3['Tasks'][2]['TaskOwnerLastName'];

$taskId4 = $obj3['Tasks'][3]['TaskID'];
$taskOwner4 = $obj3['Tasks'][3]['TaskOwnerFirstName']." ".$obj3['Tasks'][3]['TaskOwnerLastName'];

$taskId5 = $obj3['Tasks'][4]['TaskID'];
$taskOwner5 = $obj3['Tasks'][4]['TaskOwnerFirstName']." ".$obj3['Tasks'][4]['TaskOwnerLastName'];

$taskId6 = $obj3['Tasks'][5]['TaskID'];
$taskOwner6 = $obj3['Tasks'][5]['TaskOwnerFirstName']." ".$obj3['Tasks'][5]['TaskOwnerLastName'];

$taskId7 = $obj3['Tasks'][6]['TaskID'];
$taskOwner7 = $obj3['Tasks'][6]['TaskOwnerFirstName']." ".$obj3['Tasks'][6]['TaskOwnerLastName'];

$taskId8 = $obj3['Tasks'][7]['TaskID'];
$taskOwner8 = $obj3['Tasks'][7]['TaskOwnerFirstName']." ".$obj3['Tasks'][7]['TaskOwnerLastName'];

$taskId9 = $obj3['Tasks'][8]['TaskID'];
$taskOwner9 = $obj3['Tasks'][8]['TaskOwnerFirstName']." ".$obj3['Tasks'][8]['TaskOwnerLastName'];




?>

<?php
	$i = 0;
	$memberArray = array();
	while($i <= $totalMembers-1) {
	//echo $obj2['teammembers'][$i]['user_id']."-";
	$memberId = $obj2['teammembers'][$i]['user_id'];
	//echo $obj2['teammembers'][$i]['is_reviewer']." / ";
	array_push($memberArray, $memberId);
	$i++;
}
?>

<div class="col-xs-12" style="padding-left: 150px;">
	
	<div class="evo-space"></div>
		
		<div class="row">
			<div class="col-xs-10">
				<p class="evo-text-smaller-upper">Team Member Overview</p>
			</div>
			<div class="col-xs-2">
				<p class="evo-text-smaller-upper evo-text-right" style="text-align: right"><i class="fa fa-times fa-2x close_members"></i></p>
			</div>
		</div>


		<div class="row">
				<div class="col-xs-12">
			<h1 class="evo-header-big margin-top-0 text-swap font_stack_4">Manage Members</h1>
					<div class="add_task_confirmation_holder"></div>

					<table class="fixed_table member_table get_api" data-api="<?php echo $_COOKIE['api']; ?>">
						<tr class="get_project_id" data-project-id="<?php echo $project_id;?>">
							<td>Team<br>Member</td>
							<td class="task1" data-getTaskId="<?php echo $taskId1; ?>">JTBD</td>
							<td class="task2" data-getTaskId="<?php echo $taskId2; ?>">Comms<br>Tasks</td>
							<td class="task3" data-getTaskId="<?php echo $taskId3; ?>">Real<br>Lives</td>
							<td class="task4" data-getTaskId="<?php echo $taskId4; ?>">Media<br>Idea</td>
							<td class="task5" data-getTaskId="<?php echo $taskId5; ?>">Touchpoint<br>Shortlist</td>
							<td class="task6" data-getTaskId="<?php echo $taskId6; ?>">Budget Allocation<br>& Mapping</td>
							<td class="task7" data-getTaskId="<?php echo $taskId7; ?>">Phasing</td>
							<td class="task8" data-getTaskId="<?php echo $taskId8; ?>">Final<br>Plan</td>
							<td class="task9" data-getTaskId="<?php echo $taskId9; ?>">Outcome</td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						</tr>

						<?php
						foreach($users as $key => $value) {
							if(in_array($key, $memberArray)) { ?>
								<tr data-memberId="<?php echo $key; ?>">
									<td data-memberId="<?php echo $key; ?>"><?php echo $value; ?><?php if(in_array($key, $reviwerArray)) {echo "<i class=\"fa fa-star evo-green\"></i>";}?></td>

									<td class="add_dot" data-memberId="<?php echo $key; ?>" data-taskId="<?php echo $taskId1; ?>"><?php if($taskOwner1 == $value) {echo "<span></span>";}?></td>
									<td class="add_dot" data-memberId="<?php echo $key; ?>" data-taskId="<?php echo $taskId2; ?>"><?php if($taskOwner2 == $value) {echo "<span></span>";}?></td>
									<td class="add_dot" data-memberId="<?php echo $key; ?>" data-taskId="<?php echo $taskId3; ?>"><?php if($taskOwner3 == $value) {echo "<span></span>";}?></td>
									<td class="add_dot" data-memberId="<?php echo $key; ?>" data-taskId="<?php echo $taskId4; ?>"><?php if($taskOwner4 == $value) {echo "<span></span>";}?></td>
									<td class="add_dot" data-memberId="<?php echo $key; ?>" data-taskId="<?php echo $taskId5; ?>"><?php if($taskOwner5 == $value) {echo "<span></span>";}?></td>
									<td class="add_dot" data-memberId="<?php echo $key; ?>" data-taskId="<?php echo $taskId6; ?>"><?php if($taskOwner6 == $value) {echo "<span></span>";}?></td>
									<td class="add_dot" data-memberId="<?php echo $key; ?>" data-taskId="<?php echo $taskId7; ?>"><?php if($taskOwner7 == $value) {echo "<span></span>";}?></td>
									<td class="add_dot" data-memberId="<?php echo $key; ?>" data-taskId="<?php echo $taskId8; ?>"><?php if($taskOwner8 == $value) {echo "<span></span>";}?></td>
									<td class="add_dot" data-memberId="<?php echo $key; ?>" data-taskId="<?php echo $taskId9; ?>"><?php if($taskOwner9 == $value) {echo "<span></span>";}?></td>
									<td><a href="#"><i class="fa fa-trash-o remove-user" data-memberId="<?php echo $key; ?>"></i></a></td>
								</td>
								<?php
							}
						}
						?>
					</table>

						<form class="task_form" data-taskId="<?php echo $taskId1; ?>" action="<?php echo $this->container->getParameter('apiUrl'); ?>campaigns/<?php echo $project_id;?>/tasks/<?php echo $taskId1; ?>/owners/" method="PUT">
							<input class="task_jtbd_task" type="hidden" name="task_id" value="<?php echo $taskId1; ?>">
							<input class="user_id" type="hidden" name="user_id" data-taskId="<?php echo $taskId1; ?>">
						</form>
						<form class="task_form" data-taskId="<?php echo $taskId2; ?>" action="<?php echo $this->container->getParameter('apiUrl'); ?>campaigns/<?php echo $project_id;?>/tasks/<?php echo $taskId2; ?>/owners/" method="PUT">
							<input class="task_jtbd_task" type="hidden" name="task_id" value="<?php echo $taskId2; ?>">
							<input class="user_id" type="hidden" name="user_id" data-taskId="<?php echo $taskId2; ?>">
						</form>
						<form class="task_form" data-taskId="<?php echo $taskId3; ?>" action="<?php echo $this->container->getParameter('apiUrl'); ?>campaigns/<?php echo $project_id;?>/tasks/<?php echo $taskId3; ?>/owners/" method="PUT">
							<input class="task_jtbd_task" type="hidden" name="task_id" value="<?php echo $taskId3; ?>">
							<input class="user_id" type="hidden" name="user_id" data-taskId="<?php echo $taskId3; ?>">
						</form>
						<form class="task_form" data-taskId="<?php echo $taskId4; ?>" action="<?php echo $this->container->getParameter('apiUrl'); ?>campaigns/<?php echo $project_id;?>/tasks/<?php echo $taskId4; ?>/owners/" method="PUT">
							<input class="task_jtbd_task" type="hidden" name="task_id" value="<?php echo $taskId4; ?>">
							<input class="user_id" type="hidden" name="user_id" data-taskId="<?php echo $taskId4; ?>">
						</form>
						<form class="task_form" data-taskId="<?php echo $taskId5; ?>" action="<?php echo $this->container->getParameter('apiUrl'); ?>campaigns/<?php echo $project_id;?>/tasks/<?php echo $taskId5; ?>/owners/" method="PUT">
							<input class="task_jtbd_task" type="hidden" name="task_id" value="<?php echo $taskId5; ?>">
							<input class="user_id" type="hidden" name="user_id" data-taskId="<?php echo $taskId5; ?>">
						</form>
						<form class="task_form" data-taskId="<?php echo $taskId6; ?>" action="<?php echo $this->container->getParameter('apiUrl'); ?>campaigns/<?php echo $project_id;?>/tasks/<?php echo $taskId6; ?>/owners/" method="PUT">
							<input class="task_jtbd_task" type="hidden" name="task_id" value="<?php echo $taskId6; ?>">
							<input class="user_id" type="hidden" name="user_id" data-taskId="<?php echo $taskId6; ?>">
						</form>
						<form class="task_form" data-taskId="<?php echo $taskId7; ?>" action="<?php echo $this->container->getParameter('apiUrl'); ?>campaigns/<?php echo $project_id;?>/tasks/<?php echo $taskId7; ?>/owners/" method="PUT">
							<input class="task_jtbd_task" type="hidden" name="task_id" value="<?php echo $taskId7; ?>">
							<input class="user_id" type="hidden" name="user_id" data-taskId="<?php echo $taskId7; ?>">
						</form>
						<form class="task_form" data-taskId="<?php echo $taskId8; ?>" action="<?php echo $this->container->getParameter('apiUrl'); ?>campaigns/<?php echo $project_id;?>/tasks/<?php echo $taskId8; ?>/owners/" method="PUT">
							<input class="task_jtbd_task" type="hidden" name="task_id" value="<?php echo $taskId8; ?>">
							<input class="user_id" type="hidden" name="user_id" data-taskId="<?php echo $taskId8; ?>">
						</form>
						<form id="update_all_task_owners" class="task_form" data-taskId="<?php echo $taskId9; ?>" action="<?php echo $this->container->getParameter('apiUrl'); ?>campaigns/<?php echo $project_id;?>/tasks/<?php echo $taskId9; ?>/owners/" method="PUT">
							<input class="task_jtbd_task" type="hidden" name="task_id" value="<?php echo $taskId9; ?>">
							<input class="user_id" type="hidden" name="user_id" data-taskId="<?php echo $taskId9; ?>">
							<div class="evo-space-big"></div>
							<button type="submit" class="btn evo-btn-2">Update Tasks</button>
						</form>
						<div class="evo-space"></div>

					</div>
				</div>



	
		<div class="row">
			<div class="col-xs-12">
				<div class="evo-space-biggest"></div>
				<h1 class="evo-header-big margin-top-0 text-swap font_stack_4">Add Team Members</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12">
			

			<script>
			 $(function() {
			   var availableTags = [
			     <?php
			     foreach($users as $key => $value) {
			     	echo "\"".$value."\",";
			     }
			     ?>
			   ];
			   $( "#names" ).autocomplete({
			     source: availableTags,
			     select: function( event, ui ) {
			     	addedName = ui.item.value;
	     			console.log(addedName);
	     			$('#add_user').find('addedName').attr('selected', true);
	     			$('#add_user').find('option:contains("'+addedName+'")').attr("selected",true);
			     }
			   });
			 });
			 </script>

			
			<div class="add_member_confirmation_holder get_api" data-api="<?php echo $_COOKIE['api']; ?>"></div>
			<form name="add_teamMember" id="add_teamMember" action="<?php echo $this->container->getParameter('apiUrl'); ?>campaigns/<?php echo $project_id; ?>/teammembers/" method="PUT">

				<div class="row">
					<div class="col-xs-7">
						<label class="add-member-label" style="border-top-width: 0px;">Name</label>
						<input type="text" id="names" placeholder="Begin typing a name" class="form-control">
					</div>
					<select id="add_user" name="add_user" class="hidden">
						<?php
						foreach($users as $key => $value) {
							echo '<option value="'.$key.'">'.$value.'</a>';
						}
						?>
					</select>
					<div class="col-xs-1">
						<label class="add-member-label" style="border-top-width: 0px;">Reviewer?</label>
						<div class="reviewer_check form-control"></div>
						<input class="is_reviewer hidden" type="checkbox" name="is_reviewer" value="0">
					</div>
					<div class="col-xs-3" style="margin-top: 40px">
						<button type="submit" class="btn evo-btn-2">Add Team Member</button>
					</div>
				</div>

			</form>

	
			

		
		</div>
	</div>
</div>

<script>
	$(function(){ 
		$('.reviewer_check').html("<i class=\"fa fa-star\" style=\"font-size:1.2em !important;\">") 
	});
</script>