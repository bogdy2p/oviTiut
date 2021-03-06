<?php $view->extend('::base.html.php') ?>
<link rel="stylesheet/less" type="text/css" href="<?php echo $view['assets']->getUrl('css/jquery.dataTables.bootstrap.css') ?>">
<?php

$accesstoken = $_COOKIE["api"];

$headr = array();
$headr[] = 'Content-length: 0';
$headr[] = 'Content-type: application/json';
$headr[] = 'x-wsse: ApiKey="'.$accesstoken.'"';



//$url = $this->container->getParameter('apiUrl')."campaigns.json?filter=0";
$url = $this->container->getParameter('apiUrl')."produse.json";

die('mortus');

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
$fileDownloadUrl = $this->container->getParameter('fileUrl');

function clean_date ($provided_date) {
	$our_date = str_replace('EST', ' ',$provided_date);
	return date('n/j/y g:ia',strtotime($our_date));
}


?>




<div class="container">
	<div class="row">
		<div class="offset-wrapper">
			<div class="evo-space"></div>
			<h2 class="evo-header-bigger">All Files</h2>
			<!-- <div class="evo-space"></div> -->
			<table id="files-table" class="table display dataTable" width="100%">
				<thead> 
					<tr>
						<th>Campaign ID</th>
						<th>Campaign</th>
						<th>Country</th>
						<th>Client</th>
						<th>Brand</th>
						<th>Task</th>
						<th>Type</th>
						<th>File Name</th>
						<th>Modified Date</th>
						<th>Modified By</th>
						<th>Start Year</th>
					</tr>
				</thead> 
				<tbody> 
					<?php foreach ($campaigns as $project) { 
						$campaign_id = $project['CampaignID']; 

						// call to files for campaign files
						$files_url = $this->container->getParameter('apiUrl')."campaigns/".$campaign_id."/files";

						$ch = curl_init();

						curl_setopt($ch, CURLOPT_URL,$files_url);
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
					?>


						<?php
						$tmpFilename = urldecode($file['FileName']);
						$tmpFilename = explode("\\", $tmpFilename);
						$tempFilenamePieces = count($tmpFilename);

						//$fileExt = explode(".", $tmpFilename[$tempFilenamePieces-1]);
						$fileExt = explode(".", $tmpFilename[$tempFilenamePieces-1]);

						if(isset($fileExt[1])) {
							$fileExt = $fileExt[1];
						} else {
							$fileExt = "not_set";
						}
						?>
						<?php
						if($fileExt != "json" && $fileExt != "tmp" && $fileExt != "lock" && $fileExt != "ico" && $fileExt != "json" && $fileExt != "uld") { ?>

								<tr class="hover_row" data-fileId="<?php echo $file['FileId']; ?>">
									<td><?php echo $campaign_id; ?></td>
									<td><?php echo $project['CampaignName']; ?></td>
									<td><?php echo $project['Country']; ?></td>
									<td><?php echo $project['ClientName']; ?></td>
									<td><?php echo $project['Brand']; ?></td>
									<td><?php echo $file['TaskName']; ?></td>
									<td><?php echo $file['FileType']; ?></td>
									<td>
										<a href="<?php echo $this->container->getParameter('fileUrl').$file['FilePath'].'" download'; ?>">
											<?php echo $tmpFilename[$tempFilenamePieces-1]; ?>
										</a>
									</td>
									<td><?php echo clean_date($file['FileModifiedDate']); ?></td>
									<td><?php echo $file['FileModifiedBy']; ?></td>
									<td>
										<div style="clear: both;">
											<?php 
												echo "<div style='float: left;'>".substr($project['Campaign_Start_Date'], 0, 4)."</div>";
												echo "<div class=\"delete_file\" data-fileId=\"".$file['FileId']."\"><a href=\"#\"><i class=\"fa fa-trash-o\"></i></a></div>";
											?>
										</div>
									</td>
								</tr>
					<?php
							}
							}
						}
					}?>
				</tbody> 
			</table>
			<div class="evo-space"></div>
		</div>
	</div>
</div>
