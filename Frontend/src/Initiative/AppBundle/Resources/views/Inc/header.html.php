<?php
$request = $this->container->get('request');
$routeName = $request->get('_route');
?>
<!doctype html>
<html>
	<head>
		<title>Unilever Dash</title>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="icon" type="image/png" href="<?php echo $view['assets']->getUrl('img/favicon.png'); ?>" />


		<link rel="stylesheet" type="text/css" href="<?php echo $view['assets']->getUrl('css/jquery-ui.css'); ?>">

		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Ropa+Sans:400,400italic' rel='stylesheet' type='text/css'>

		<link rel="stylesheet" type="text/css" href="<?php echo $view['assets']->getUrl('css/normalize.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo $view['assets']->getUrl('css/bootstrap.min.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo $view['assets']->getUrl('css/responsive-nav.css'); ?>">

		<link rel="stylesheet" type="text/css" href="<?php echo $view['assets']->getUrl('css/jquery.fullPage.css'); ?>">

		<link rel="stylesheet/less" type="text/css" href="<?php echo $view['assets']->getUrl('css/main.less') ?>">

		<link rel="stylesheet" type="text/css" href="<?php echo $view['assets']->getUrl('css/jquery-te-1.4.0.css') ?>">

		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

		<script src="<?php echo $view['assets']->getUrl('js/jquery.min.js'); ?>"></script>

		<script>
		    apiUrl = '<?php echo $this->container->getParameter('apiUrl'); ?>';
		    fileUrl = '<?php echo $this->container->getParameter('fileUrl'); ?>';
		</script>

		

	</head>
<body>
<div class="alert_bar"></div>

<div class="loading_ico"></div>