<?php

$url = $this->container->getParameter('apiUrl')."options.json";

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
?>

<div class="get_api" data-api="<?php echo $_COOKIE['api']; ?>">
	<div class="close_window campaign evo-text-right"><i class="fa fa-times fa-2x"></i></div>
	<h2 class="evo-header-big margin-top-0 text-swap font_stack_4">Nota receptie noua</h2>
	
	
	<form name="new_campaign" id="new_campaign" action="<?php echo $this->container->getParameter('apiUrl'); ?>receptions.json" method="POST">

	<div class='new-campaign-item-divider'></div>
	<label for="furnizor_name" class='float_label'>Nume receptie</label>
	<input name="Furnizor" type="text" data-for='furnizor_name' data-animation='topZero' class="form-control" placeholder="Furnizor" required>

	<div class='new-campaign-item-divider'></div>							
	<label for="cd" class='float_label'>Data</label>
	<input name="completion_date" type="text" class="form-control datepicker" data-for='cd' data-calendar='datePicker' placeholder="YYYY-MM-DD" required>

	<div class="evo-space"></div>
	<button class="evo-btn evo-btn-2">Trimite !</button>
	<div class="evo-space"></div>

</div>

<script>

	$('select').click(function() {
		getFor = $(this).data("for");
		if ($(this).data('animation') === 'topZero'){
			$('label[for="'+getFor+'"]').animate({"opacity":"1","top":"0"}, 300);
		}
	});

	$('select').change(function() {
		getFor = $(this).data("for");
		if ($(this).data('animation') === 'topZero'){
			$('label[for="'+getFor+'"]').animate({"opacity":"1","top":"0"}, 300);
		}
	});

	$('input').on('click change', function() {
		var getFor = $(this).data("for");
		if ($(this).data('calendar') === 'datePicker') {
			$('label[for="'+getFor+'"]').animate({"opacity":"1","top":"0"}, 300);
		}
	});

</script>