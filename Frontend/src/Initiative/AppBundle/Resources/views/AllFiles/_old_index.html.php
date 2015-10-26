

<?php $view->extend('::base.html.php') ?>
<link rel="stylesheet/less" type="text/css" href="<?php echo $view['assets']->getUrl('css/jquery.dataTables.bootstrap.css') ?>">
<?php

$accesstoken = $_COOKIE["api"];

$headr = array();
$headr[] = 'Content-length: 0';
$headr[] = 'Content-type: application/json';
$headr[] = 'x-wsse: ApiKey="'.$accesstoken.'"';



$url = $this->container->getParameter('apiUrl')."campaigns.json";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$result=curl_exec($ch);
curl_close($ch);


$obj = json_decode($result, true);
$campaigns_count = count($obj['Campaigns']);
$campaigns = $obj['Campaigns'];
$i = 0;



?>




<div class="container">
	<div class="row">
		<div class="table-wrapper">
 			<div class="evo-space"></div>
 			<h2 class="evo-header-bigger">All Files</h2>
 			<!-- <div class="evo-space"></div> -->
 			<table id="files-table" class="table display dataTable" width="100%">
	 			<thead> 
					<tr>
						<th>Campaign ID</th>
						<th>Campign Name</th>
						<th>File Name</th>
						<th>Version</th>
						<th>Modified Date</th>
						<th>Modified By</th>
					</tr>
				</thead> 
  			<tbody> 
			<?php foreach ($campaigns as $project) { 
			$campaign_id = $project['CampaignID']; 

			$url = $this->container->getParameter('apiUrl')."campaigns/".$campaign_id."/files";

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

			$result=curl_exec($ch);
			curl_close($ch);

			$all_files = json_decode($result, true);
			$file_count = count($all_files['files']);
			$file_obj = $all_files['files']; 
			 if ($file_count>0) {
			
			
			// list all the files
			foreach ($file_obj as $file) { 
			echo '
			<tr class="hover_row">
				<td>'.$campaign_id.'</td>
				<td>'.$project['CampaignName'].'</td>
			<td><a href="'.$file['FilePath'].'">'.urldecode($file['FileName']).'</a></td>
			<td>'.$file['FileVersion'].'</td>
			<td>';
			// translate the date into something more readable
			$provided_date = $file['FileModifiedDate'];
			$our_date = str_replace('EST', ' ',$provided_date);
			
			$good_date = date('n/j/y g:ia',strtotime($our_date));
			
			echo "$good_date";
			echo '</td>
			<td>'.$file['FileModifiedBy'].'</td>
			</tr>';

			}


			}
			
			}

			?>
				</tbody> 
			</table>
			<div class="evo-space"></div>
		</div>
	</div>
</div>