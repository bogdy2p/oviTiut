<?php $view->extend('::base.html.php') ?>
<?php
if(isset($_COOKIE['api'])) {

    
        $url = $this->container->getParameter('apiUrl')."receptions.json";
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


//        var_dump($obj);

	$campaigns_count = count($obj['Receptions']);

//        $campaigns_count = 2;
//        die($campaigns_count);
	$i = 0;


//
	$url = $this->container->getParameter('apiUrl')."users/".$_COOKIE['dash_user_id']."/profile.json";

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	$result2=curl_exec($ch);
	curl_close($ch);

	$myProfile = json_decode($result2, true)[0];

	function getAvatarUrl($myProfile) {
		if($myProfile['profile_picture_path']) {
			$comment_avatar = $myProfile['profile_picture_path'];
		}
		if (isset($comment_avatar)) {
			$comment_avatar2 = substr($comment_avatar, 0, 3);
			$comment_avatar3 = substr($comment_avatar, -3);
			$comment_avatar4 = substr($comment_avatar, 3, -3);
			$photo_url = "https://cdn.honey.is/avatar/".$comment_avatar2."/".$comment_avatar3."/".$comment_avatar4."_100x100.png";
			echo "<div class=\"avatar_img\" style=\"background-image: url('".$photo_url."')\"></div>";
		} else {
			echo "<div class=\"avatar_img\" style=\"background-image: url('img/no-face.png')\"></div>";
		}
	}




} else {
	header('Location: /login');
	die;
}

?>

<div class="opacity"></div>

<div id="new_campaign_container">
<?php echo $view->render('InitiativeAppBundle:NewReception:index.html.php');?>
</div>




<div class="container-fluid">
	<div class="row">
		<div class="col-xs-9 evo-white">
			<div class="row project_data_sidebar" style="padding-bottom: 20px;">
				<div class="offset-wrapper">


					<!-- HEADER -->
					<div class="row">
						<div class="col-xs-12">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-9">
							<div class="evo-space"></div>
							<p class="evo-text-smaller-upper">Unilever Dash</p>
							<h1 class="evo-header-big margin-top-0 text-swap font_stack_4"><?php if(isset($myProfile['user']['firstname'])) {echo $myProfile['user']['firstname']."'s";} else {echo "Your";	}?> Dashboard</h1>
						</div>
						<!-- USER AVATAR AND MESSAGES -->
						<div class="col-xs-3">
							<div class="profile_section">
								<i class="fa fa-chevron-down"></i>
								<!-- WHEN HONEY IS AUTHROIZED, GET UUID FOR AVATAR, OTHERWISE, SHOW BLANK ONE -->
								<?php getAvatarUrl($myProfile); ?>
								<!-- USER LINKS DROP DOWN -->
								<div class="user_panel"> 
									<div class="arrow-up">
										<svg viewBox="0 0 77.879 50.862">
										<polyline fill="#FFFFFF" stroke="#000000" stroke-width="0.7712" stroke-miterlimit="10" points="0.305,50.626 38.939,0.631 
											77.574,50.626 "/>
										</svg>
									</div>
									<ul>
										<!-- <a href="#"><li><i class="fa fa-user"></i> My Profile</li></a>
										<a href="#"><li><img src="<?php #echo $view['assets']->getUrl('img/honey_logo.png') ?>" class="evo-ico-inline-smaller"> Sync Honey</li></a> -->
										<!-- <a href="#"><li><i class="fa fa-cog"></i> Account Settings</li></a>
										<a href="#"><li><i class="fa fa-question-circle"></i> Help</li></a> -->
										<a href="/login" class="logout_btn"><li><i class="fa fa-power-off"></i> Logout</li></a>
									</ul>
								</div>
								<!-- END USER LINKS DROPDOWN -->
							</div>
						</div>
					</div>
					<!-- END HEADER -->

					<!-- CAMPAIGNS SORT/FILTER BAR -->
					<div class="row">
						<div class="col-xs-12">
							<div class="task_bar">
								<?php if($myProfile['user_role'] != "Viewer") { ?>
									<div class="task_bar_left">
										<button class="btn evo-btn-2 create_campaign_btn">Creaza Nota Receptie</button>
									</div>
								<?php } ?>
								<div class="task_bar_right">
<!--									<span class="evo-text-smaller">Only show</span>
									<select class="sorting_options" id="present-filter" >
										<option value=".Build">Build</option>
										<option value=".Approved">Approved</option>
									</select>
									<span class="evo-text-smaller">Sort by</span>
									<select class="sorting_options" id="stat-filter">
										<option value="recent:desc">Most Recent</option>
										<option value="completion:desc">Completion Score</option>
										<option value="urgency:asc">Urgency</option>
										<option value="responsibility:desc">Your Responsibility</option>
									</select>-->
								</div>
							</div>
						</div>
					</div>
					<!-- END CAMPAIGNS SORT/FILTER BAR -->

					<!-- LIST CAMPAIGNS -->
					<div class="row">
						<div class="col-xs-12">
							<div class="row wheel_row">
								<div class="evo-space"></div>
								<div id="campaign-holder">
								<?php
									while($i <= $campaigns_count-1) { 
										if($obj['Campaigns'][$i]['not_visible']) { continue; }
										$project_id = $obj['Campaigns'][$i]['CampaignID'];
										$client_name = $obj['Campaigns'][$i]['ClientName'];
										$campaign_name = $obj['Campaigns'][$i]['CampaignName'];
										$presented_status = $obj['Campaigns'][$i]['CampaignStatus'];
										$recent = strtotime($obj['Campaigns'][$i]['CampaignLastModifiedDate']);
										$completion = $obj['Campaigns'][$i]['Completeness'];
										$urgency = $obj['Campaigns'][$i]['Urgency'];
										?>
										<div class="col-xs-4 mix <?php echo $presented_status; ?>" data-project_id="<?php echo $project_id; ?>" data-recent="<?php echo $recent; ?>" data-completion="<?php echo $completion; ?>" data-urgency="<?php echo $urgency; ?>" data-campaign="<?php echo $campaign_name; ?>" data-client="<?php echo $client_name; ?>">
											<a href="<?php echo $view['router']->generate('initiative_app_project', array('project_id' => $project_id, 'step_id' => 0)); ?>">
												<?php echo $view->render('InitiativeAppBundle:Inc:MiniWheel/MiniWheel.html.php', array('project_id' => $project_id)); ?>
											</a>
										<div class="clear_wheel">
											<h4 class="evo-text-small text-center"><?php echo $client_name. " - " .$campaign_name; echo "<br><p class='evo-text-smaller evo-gray-2'>"; echo $obj['Campaigns'][$i]['Country'];?></p></h4>
										<?php $i ++; ?>
										</div>
										</div>
								<?php } ?>
								</div>
							</div>
							<div class="evo-space-biggest"></div>
						</div>
					</div><!-- row -->
					<!-- END LIST CAMPAIGNS -->
				</div><!-- /col-xs-10 col-xs-offset-2 -->	
			</div><!-- row project_data_sidebar -->
		</div><!-- col-xs-8 evo-white -->
		<!-- <div class="col-xs-3"> -->
			<!-- <div class="row"> -->
				<div class="col-xs-3 inner-fixed">
					<?php echo $view->render('InitiativeAppBundle:Inc:Honey/api.html.php'); ?>
					<?php echo $view->render('InitiativeAppBundle:Inc:Confluence/index.html.php'); ?>
				</div>
			<!-- </div> -->
		<!-- </div> -->
	</div>
</div>
<script src="http://cdn.jsdelivr.net/jquery.mixitup/latest/jquery.mixitup.min.js"></script>
