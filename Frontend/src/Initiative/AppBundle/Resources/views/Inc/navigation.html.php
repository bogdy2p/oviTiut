<?php
$request = $this->container->get('request');
$routeName = $request->get('_route');
?>

<?php
if(isset($_COOKIE['api'])) {
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

  $result=curl_exec($ch);
  curl_close($ch);

  $obj = json_decode($result, true);

  $tasks_count = count($obj['tasks_data']);
  
  $task_messages = 0;
  $i = 0;

	while($i <= $tasks_count-1) {
    if($obj['tasks_data'][$i]['last_task_message'] != null) {
      $task_messages++;
    }
    $i++;
 }
}
?>



<div id="new-sidebar" class="expanded_menu">

	<div class="row">
		<div class="col-xs-12">
			<a href="#" class="hamburger_ico" id="menu-trigger">
				<div class="evo-ico">
					<?php include('img/svg/8.php'); ?>
				</div>
				<h2 class="evo-header evo-ff3 evo-white">Close Menu</h2>
			</a>
		</div>

		<div class="col-xs-12">
			<div class="evo-space"></div>
		</div>

		<div class="col-xs-12">
			<a href="<?php echo $view['router']->generate('initiative_app_homepage') ?>" class="hamburger_ico btn_action<?
				if ($routeName == "initiative_app_homepage" || $routeName == "initiative_app_project") {
					echo " active";
				}
				?>" id="menu-trigger">
				<div class="evo-ico">
					<?php include('img/svg/3.php'); ?>
				</div>
				<h2 class="evo-header evo-ff3 evo-white">Dashboard</h2>
			</a>
		</div>

		<div class="col-xs-12">
			<a href="<?php echo $view['router']->generate('initiative_app_myTasks') ?>" class="hamburger_ico btn_action<?
				if ($routeName == "initiative_app_myTasks") {
					echo " active";
				}
				?>" id="menu-trigger">
				<div class="evo-ico">
					<?php include('img/svg/9.php'); ?>
				</div>
				<h2 class="evo-header evo-ff3 evo-white">My Assignments</h2>
				<?php if(isset($task_messages)) { ?><div class="task_messages_count_2"><?php echo $task_messages; ?></div><?php } ?>
			</a>
		</div>

		<div class="col-xs-12">
			<a href="<?php echo $view['router']->generate('initiative_app_allProjects') ?>" class="hamburger_ico btn_action<?
				if ($routeName == "initiative_app_allProjects") {
					echo " active";
				}
				?>" id="menu-trigger">
				<div class="evo-ico">
					<?php include('img/svg/1.php'); ?>
				</div>
				<h2 class="evo-header evo-ff3 evo-white">All Campaigns</h2>
			</a>
		</div>

		<div class="col-xs-12">
			<a href="<?php echo $view['router']->generate('initiative_app_allFiles') ?>" class="hamburger_ico btn_action<?
				if ($routeName == "initiative_app_allFiles") {
					echo " active";
				}
				?>" id="menu-trigger">
				<div class="evo-ico">
					<?php include('img/svg/6.php'); ?>
				</div>
				<h2 class="evo-header evo-ff3 evo-white">All Files</h2>
			</a>
		</div>

		<div class="col-xs-12">
			<a href="<?php echo $view['router']->generate('initiative_app_goldenRules') ?>" class="hamburger_ico btn_action<?
				if ($routeName == "initiative_app_goldenRules") {
					echo " active";
				}
				?>" id="menu-trigger">
				<div class="evo-ico">
					<?php include('img/svg/5.php'); ?>
				</div>
				<h2 class="evo-header evo-ff3 evo-white">Golden Rules</h2>
			</a>
		</div>

		<div class="col-xs-12">
			<a href="<?php echo $this->container->getParameter('adminUrl'); ?>" target="_blank" class="hamburger_ico btn_action<?php
				if ($routeName == "initiative_app_admin") {
					echo " active";
				}
				?>" id="menu-trigger">
				<div class="evo-ico">
					<?php include('img/svg/7.php'); ?>
				</div>
				<h2 class="evo-header evo-ff3 evo-white">Admin</h2>
			</a>
		</div>


		<div class="col-xs-12">
			<div class="evo-space"></div>
			<h2 class="evo-header evo-ff3 evo-white" style="left: 0px; margin-bottom: 0;">tools</h2>
			<ul class="evo-text-small evo-ff3 evo-white no-bullets">
				<li><a href="https://honey.is/home/#group/44881/posts&topic=44884" target="_blank">Allocate</a></li>
				<li><a href="https://honey.is/home/#group/44881/posts&topic=46281" target="_blank">Matrix</a></li>
				<li><a href="https://honey.is/home/#group/44529/posts&topic=44532" target="_blank">Real Lives</a></li>
				<li><a href="https://honey.is/home/#group/44529/posts&topic=45451" target="_blank">MegaStar</a></li>
			</ul>
		</div>

		<div class="col-xs-12">
			<div class="evo-space"></div>
			<h2 class="evo-header evo-ff3 evo-white" style="left: 0px; margin-bottom: 0;">resources</h2>
			<ul class="evo-text-small evo-ff3 evo-white no-bullets">
				<li><a href="https://honey.is/home/#all" target="_blank">Honey</a></li>
				<li><a href="https://knowledge.initiative.com" target="_blank">Knowledge Center</a></li>
				<li><a href="http://fbds.initiative.com/" target="_blank">Branding Page</a></li>
				<li><a href="https://www.mbww.com/flite/" target="_blank">FLITE</a></li>
			</ul>
		</div>

		<div class="col-xs-12">
			<div class="evo-space"></div>
			<h2 class="evo-header evo-ff3 evo-white" style="left: 0px; margin-bottom: 0;">client links</h2>
			<ul class="evo-text-small evo-ff3 evo-white no-bullets">
				<li><a href="https://knowledge.initiative.com/display/UN/" target="_blank">Unilever Wiki Space</a></li>
			</ul>
		</div>



	</div>


</div>


<div class="col-xs-1 sidePanel <?php if($routeName == "initiative_app_login") {echo "hidden";}?>">

<!-- 	<div class="evo_action_ico">
		<a href="<?php echo $view['router']->generate('initiative_app_homepage') ?>">
			<img src="<?php echo $view['assets']->getUrl('img/logo.png');?>" class="logo initiative_logo_sidebar">
		</a>
	</div> -->

	<div class="blue_grow"></div>

	<div class="sidebar_nav">
		<div class="evo-space-bigger evo-space-collapse"></div>
		<div class="evo_action_ico loader2">
			<a href="#" class="hamburger_ico" id="menu-trigger" data-effect="st-effect-1">
				<div class="evo-ico">
					<?php include('img/svg/4.php'); ?>
				</div>
			</a>
		</div>
		<div class="evo-space-bigger"></div>
		<div class="evo_action_ico loader">
			<a href="<?php echo $view['router']->generate('initiative_app_homepage') ?>" class="btn_action">
				<div class="evo-ico<?php
				if ($routeName == "initiative_app_homepage" || $routeName == "initiative_app_project") {
					echo " evo-ico-active";
				}
				?>">
					<?php include('img/svg/3.php'); ?>
				</div>
				<span><div class="arrow-left_tool"></div>Dashboard</span>
			</a>
			<!-- <div class="arrow-left"></div> -->
		</div>
		<div class="evo-space-bigger evo-space-collapse"></div>
		<div class="evo_action_ico loader">
			<a href="<?php echo $view['router']->generate('initiative_app_myTasks') ?>" class="btn_action">
				<div class="evo-ico<?php
				if ($routeName == "initiative_app_myTasks") {
					echo " evo-ico-active";
				}
				?>">
					<?php include('img/svg/9.php'); ?>
					<?php if(isset($task_messages)) { ?><div class="task_messages_count"><?php echo $task_messages; ?></div><?php } ?>
				</div>
				<span><div class="arrow-left_tool"></div>My Assignments</span>
			</a>
		</div>
		<div class="evo-space-bigger evo-space-collapse"></div>
		<div class="evo_action_ico loader">
			<a href="<?php echo $view['router']->generate('initiative_app_allProjects') ?>" class="btn_action">
				<div class="evo-ico<?php
				if ($routeName == "initiative_app_allProjects") {
					echo " evo-ico-active";
				}
				?> evo-ico-flip-y">
					<?php include('img/svg/1.php'); ?>
				</div>
				<span><div class="arrow-left_tool"></div>All Campaigns</span>
			</a>
		</div>
		<div class="evo-space-bigger evo-space-collapse"></div>
		<div class="evo_action_ico loader">
			<a href="<?php echo $view['router']->generate('initiative_app_allFiles') ?>" class="btn_action">
				<div class="evo-ico<?php
				if ($routeName == "initiative_app_allFiles") {
					echo " evo-ico-active";
				}
				?>">
					<?php include('img/svg/6.php'); ?>
				</div>
				<span><div class="arrow-left_tool"></div>All Files</span>
			</a>
		</div>
		<div class="evo-space-bigger evo-space-collapse"></div>
		<div class="evo_action_ico loader">
			<a href="<?php echo $view['router']->generate('initiative_app_goldenRules') ?>" class="btn_action">
				<div class="evo-ico<?php
				if ($routeName == "initiative_app_goldenRules") {
					echo " evo-ico-active";
				}
				?>">
					<?php include('img/svg/5.php'); ?>
				</div>
				<span><div class="arrow-left_tool"></div>Golden Rules</span>
			</a>
		</div>
		<div class="evo-space-bigger evo-space-collapse"></div>
		<div class="evo_action_ico loader2">
			<a href="<?php echo $this->container->getParameter('adminUrl'); ?>" target="_blank">
				<div class="evo-ico<?php
				if ($routeName == "initiative_app_admin") {
					echo " evo-ico-active";
				}
				?>">
					<?php include('img/svg/7.php'); ?>
				</div>
				<span><div class="arrow-left_tool"></div>Admin</span>
			</a>
		</div>

		<div class="evo-space-bigger evo-space-collapse"></div>
	</div>
</div>