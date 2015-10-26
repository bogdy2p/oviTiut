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

	$clients = $obj['clients'];
	$brands = $obj['brands'];
	$products = $obj['products'];
	$countries = $obj['countries'];
	$product_lines = $obj['product_lines'];
	$divisions = $obj['divisions'];
	$status = $obj['campaign_statuses'];

	$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id;

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	$result2=curl_exec($ch);
	curl_close($ch);

	$obj2 = json_decode($result2, true);

	$campaignName = $obj2['Campaign']['CampaignName'];
	$clientName = $obj2['Campaign']['ClientName'];
	$country = $obj2['Campaign']['Country'];
	$brand = $obj2['Campaign']['Brand'];
	$product = $obj2['Campaign']['Product'];
	$productLine = $obj2['Campaign']['Productline'];
	$campaignStatus = $obj2['Campaign']['CampaignStatus'];
	$completionDate = $obj2['Campaign']['CompletionDate'];
	$campaignLastModifiedDate = $obj2['Campaign']['CampaignLastModifiedDate'];
	$clientDeliverabledate = $obj2['Campaign']['ClientDeliverabledate'];
	$presentedToClient = $obj2['Campaign']['PresentedToClient'];
	$division = $obj2['Campaign']['Division'];
?>


<div class="row get_api" data-api="<?php echo $_COOKIE['api']; ?>">
	<div class="close_window campaign-edit evo-text-right"><i class="fa fa-times fa-2x"></i></div>
	<div class="col-xs-12">
		<h2 class="evo-header-big font_stack_4 margin-top-0 text-swap">Edit Campaign</h2>
	</div>
</div>

<form name="edit_campaign" id="edit_campaign" action="<?php echo $this->container->getParameter('apiUrl'); ?>campaigns/<?php echo $project_id; ?>" method="PUT">
	<label for="campaign">Campaign Name</label>
	<input required name="name" type="text" data-for='campaign_name' class="form-control" value="<?php echo $campaignName; ?>">
	
	<label for="client">Client Name</label>
	<select required class="sorting_options new_campaign_select ajaxSelector" data-for='client' name="client">
		<?php
		foreach($clients as $key => $value) {
			if($value == $clientName) {
				echo '<option selected value="'.$key.'">'.$value.'</a>';
			} else {
				echo '<option value="'.$key.'">'.$value.'</a>';
			}
		}
		?>
	</select>
	
	<label for="division">Division</label>
	<select required name="division" class="sorting_options new_campaign_select ajaxSelector" data-for='division'>
		<?php
		foreach($divisions as $key => $value) {
			if($value == $division) {
				echo '<option selected value="'.$key.'">'.$value.'</a>';
			} else {
				echo '<option value="'.$key.'">'.$value.'</a>';
			}
		}
		?>
	</select>	
	
	<label for="brand">Brand Name</label>
	<select required name="brand" class="sorting_options new_campaign_select ajaxSelector" data-for='brand'>
		<?php
		foreach($brands as $key => $value) {
			if($value == $brand) {
				echo '<option selected value="'.$key.'">'.$value.'</a>';
			} else {
				echo '<option value="'.$key.'">'.$value.'</a>';
			}
		}
		?>
	</select>
	
	<label for="productline">Product Line</label>
	<select required name="productline" class="sorting_options new_campaign_select ajaxSelector" data-for='productline'>
		<?php
		foreach($product_lines as $key => $value) {
			if($value == $productLine) {
				echo '<option selected value="'.$key.'">'.$value.'</a>';
			} else {
				echo '<option value="'.$key.'">'.$value.'</a>';
			}
		}
		?>
	</select>	
	
	<label for="product">Product</label>
	<select name="product" class="sorting_options new_campaign_select ajaxSelector" data-for='product'>
		<?php
		foreach($products as $key => $value) {
			if($value == $product) {
				echo '<option selected value="'.$key.'">'.$value.'</a>';
			} else {
				echo '<option value="'.$key.'">'.$value.'</a>';
			}
		}
		?>
	</select>	
	<label for="country">Country</label>
	<select required class="sorting_options new_campaign_select" name="country">
		<?php
		foreach($countries as $key => $value) {
			if($value == $country) {
				echo '<option selected value="'.$key.'">'.$value.'</a>';
			} else {
				echo '<option value="'.$key.'">'.$value.'</a>';
			}
		}
		?>
	</select>

	<label for="cdd">Plan Approval Due</label>
	<input name="client_deliverabledate" type="text" class="form-control datepicker" placeholder="2015-12-30" value="<?php echo $clientDeliverabledate; ?>" required>

						
	<label for="cd">Estimated Campaign End Date</label>
	<input name="completion_date" type="text" class="form-control datepicker" placeholder="2015-12-30" value="<?php echo $completionDate; ?>" required>
					
	<label for="campaign_status">Status</label>
	<select required class="sorting_options new_campaign_select" name="campaign_status">
		<?php
		foreach($status as $key => $value) {
			if($value == $status) {
				echo '<option selected value="'.$key.'">'.$value.'</a>';
			} else {
				echo '<option value="'.$key.'">'.$value.'</a>';
			}
		}
		?>
	</select>


	<?php 
		if($presentedToClient) {
			echo "<input class=\"check_presented\" value=\"0\" type='hidden' checked>";
		} else {
			echo "<input class=\"check_presented\" value=\"1\" type='hidden'>";
		}
	?>

	<input type="hidden" class="already_presented" name="already_presented"<?php if($presentedToClient) { echo " value=\"1\""; } else { echo " value=\"0\""; } ?>>

	
	<label for="modified_date">Last Modified Date</label>
	<?php echo $campaignLastModifiedDate; ?>
	
	<div class="evo-space"></div>

	<div class="row">
		<div class="col-xs-7">
			<button type="submit" class="evo-btn-2 btn">Edit Campaign</button>
		</div>
		<div class="col-xs-5">
			<p class="evo-text-smaller save-data evo-black"> <i class="fa fa-spinner fa-spin"></i> <span>saving</span></p>
		</div>
	</div>


	<div class="evo-space"></div>
</form>