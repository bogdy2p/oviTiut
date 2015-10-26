<?php $view->extend('::base.html.php') ?>



<div class="fullPage fullPageLogin">


	<?php echo $view->render('InitiativeAppBundle:Inc:Login/fullpage_video.html.php'); ?>

	<img src="img/logo.png" class="logo_login">
	<div class="login_section">
		<h1 class="evo-header-bigger evo-white evo-text-center padding-bottom-0">
			<img src="img/unilever.png" style="width: 50px;">
			<span>Dash</span></h1>

			<?php echo $view->render('InitiativeAppBundle:Inc:Login/login_form.html.php'); ?>

	</div>
</div>