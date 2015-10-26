<div class="row">
	<div class="col-xs-8 col-xs-offset-2">
		<?php echo $view->render('InitiativeAppBundle:Inc:NavWheel/index.html.php', array('project_id' => $project_id, 'task_id' => $task_id)); ?>
		<div class="evo-space-biggest"></div>
		<?php echo $view->render('InitiativeAppBundle:Inc:GoldenRules/index.html.php', array('project_id' => $project_id, 'task_id' => $task_id, 'real_TaskID' => $real_TaskID)); ?>
		<div class="evo-space-big"></div>
		<?php echo $view->render('InitiativeAppBundle:Inc:/CampaignStatus/index.html.php', array('campaignName' => $campaignName, 'userCanEdit' => $userCanEdit, 'project_id' => $project_id, 'task_id' => $task_id, 'real_TaskID' => $real_TaskID)); ?>
	</div>
</div>