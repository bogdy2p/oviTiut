	<h1 class="evo-header-big margin-top-0 text-swap font_stack_4">Manage Member Tasks</h1>
			<div class="add_task_confirmation_holder"></div>

			<table class="fixed_table member_table get_api" data-api="<?php echo $_COOKIE['api']; ?>">
				<tr>
					<td>Team<br>Member</td>
					<td>JTBD</td>
					<td>Comms<br>Tasks</td>
					<td>Real<br>Lives</td>
					<td>Media<br>Idea</td>
					<td>Touchpoint<br>Shortlist</td>
					<td>Budget Allocation<br>& Mapping</td>
					<td>Phasing</td>
					<td>Final<br>Plan</td>
					<td>Outcome</td>
					<td>&nbsp;&nbsp;</td>
				</tr>

				<?php
				foreach($users as $key => $value) {
					if(in_array($key, $memberArray)) { ?>
						<tr>


							<td data-memberId="<?php echo $key; ?>"><?php echo $value; ?></td>
							<td data-memberId="<?php echo $key; ?>" data-taskId="<?php echo $taskId1; ?>"><?php if($taskOwner1 == $value) {echo "<span></span>";}?></td>
							<td data-memberId="<?php echo $key; ?>" data-taskId="<?php echo $taskId2; ?>"><?php if($taskOwner2 == $value) {echo "<span></span>";}?></td>
							<td data-memberId="<?php echo $key; ?>" data-taskId="<?php echo $taskId3; ?>"><?php if($taskOwner3 == $value) {echo "<span></span>";}?></td>
							<td data-memberId="<?php echo $key; ?>" data-taskId="<?php echo $taskId4; ?>"><?php if($taskOwner4 == $value) {echo "<span></span>";}?></td>
							<td data-memberId="<?php echo $key; ?>" data-taskId="<?php echo $taskId5; ?>"><?php if($taskOwner5 == $value) {echo "<span></span>";}?></td>
							<td data-memberId="<?php echo $key; ?>" data-taskId="<?php echo $taskId6; ?>"><?php if($taskOwner6 == $value) {echo "<span></span>";}?></td>
							<td data-memberId="<?php echo $key; ?>" data-taskId="<?php echo $taskId7; ?>"><?php if($taskOwner7 == $value) {echo "<span></span>";}?></td>
							<td data-memberId="<?php echo $key; ?>" data-taskId="<?php echo $taskId8; ?>"><?php if($taskOwner8 == $value) {echo "<span></span>";}?></td>
							<td data-memberId="<?php echo $key; ?>" data-taskId="<?php echo $taskId9; ?>"><?php if($taskOwner9 == $value) {echo "<span></span>";}?></td>
							<td><i class="fa fa-delete"></i></td>
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
					<input type="submit" value="update tasks">
				</form>
				<div class="evo-space"></div>