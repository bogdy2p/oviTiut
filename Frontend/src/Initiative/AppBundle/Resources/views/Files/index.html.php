<?php

if(isset($real_TaskID)) {
	$onTask = true;
} else {
	$onTask = false;
}
if(!isset($real_TaskID)) {
	$real_TaskID = 0;
}


$accesstoken = $_COOKIE['api'];

$headr = array();
$headr[] = 'Content-length: 0';
$headr[] = 'Content-type: application/json';
$headr[] = 'x-wsse: ApiKey="'.$accesstoken.'"';

if(!$onTask) {
	$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/files";

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	$files_ch=curl_exec($ch);
	curl_close($ch);

	$files = json_decode($files_ch, true);

	$totalFiles = count($files['files']);
} else {
	$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/tasks/".$real_TaskID."/files";

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	$files_ch=curl_exec($ch);
	curl_close($ch);

	$files = json_decode($files_ch, true);

	$totalFiles = count($files['files']);
}







$url = $this->container->getParameter('apiUrl')."options";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$options_ch=curl_exec($ch);
curl_close($ch);

$options = json_decode($options_ch, true);

$filetypes = $options['filetypes'];


if(isset($task_id)) {
	$stepId = $task_id[0];
	
	$url = $this->container->getParameter('apiUrl')."tasks/".$stepId."/filetypes";

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	$options_ch=curl_exec($ch);
	curl_close($ch);

	$options = json_decode($options_ch, true);

	$totalFileTypes = count($options['FileTypes']);
} else {
	$url = $this->container->getParameter('apiUrl')."options";

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	$options_ch=curl_exec($ch);
	curl_close($ch);

	$options = json_decode($options_ch, true);

	$filetypes = $options['filetypes'];

}







$url = $this->container->getParameter('apiUrl')."campaigns/".$project_id."/tasks";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$options_ch=curl_exec($ch);
curl_close($ch);

$tasks = json_decode($options_ch, true);

$totalTasks = count($tasks['Tasks']);


$i = 0;
while($i <= $totalTasks-1) {
	if($tasks['Tasks'][$i]['TaskID'] == $real_TaskID) {
		$taskName = $tasks['Tasks'][$i]['TaskName'];
	}
	$i++;
}






?>
<div class="project_id" data-project-id="<?php echo $project_id; ?>">
	<div class="row">
		<div class="col-xs-10">
			<div class="evo-space"></div>
			<h1 class="evo-header-small margin-top-0 evo-ff4"><?php echo $totalFiles; ?> <?php if(isset($taskName)) { echo $taskName; } else { echo "Campaign"; } ?> Files</h1>
			<div class="evo-space"></div>
		</div>
		<?php if(!$onTask) { ?>
		<div class="col-xs-2">
			<i class="fa fa-times big-x close_pop"></i>
		</div>
		<?php } ?>
		<div class="col-xs-12" style="style: relative;">
			<?php if($userCanEdit) { ?>
				<div id="files-tout"<?php if(!$onTask) { echo " class=\"on_task_tout\"";}?>></div>
			<?php } ?>
			<table id="files_table" class="table evo-text-smaller">
				<thead>
					<tr>
						<th>File Name</th>
						<th>Task Name</th>
						<th>File Type</th>
						<th>File <br>Version</th>
						<th>Last <br>Modified</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<?php if($userCanEdit) { ?>
					<tr id="my-dropzone">
						<td>
							<span class="preview_filename">file name</span>
						</td>
						<td>
							<?php if($onTask) { ?>
							<select id="taskName" class="select_drop">
								<?php 
									echo "<option value=\"".$real_TaskID."\">".$taskName."</option>";
								?>
							</select>
							<?php } else { ?>
							<select id="taskName" class="select_drop">
								<option>Select Task</option>
								<?php
									$i = 0;
									while($i <= $totalTasks-1) {
										$taskNameId = $i+1;
										echo "<option value=\"".$tasks['Tasks'][$i]['TaskID']."\" data-taskNameId=\"".$taskNameId."\">".$tasks['Tasks'][$i]['TaskName']."</option>";
										$i++;
									}
								?>
							</select>
							<?php } ?>
						</td>
						<td>
							<select<?php if(!$onTask) { echo " disabled"; }?> id="fileType" class="select_drop">
								<?php


									if(isset($task_id)) {
										$i=0;
										while($i <= $totalFileTypes-1) {
											echo '<option value="'.$options['FileTypes'][$i]['FileTypeId'].'">'.$options['FileTypes'][$i]['FileTypeName'].'</option>';
											$i++;
										}
									} else {
										foreach($filetypes as $key => $value) {
											echo '<option value="'.$key.'">'.$value.'</option>';
										}
									}
								?>
							</select>
						</td>
						<td></td>
						<td></td>
						<td></td>
						<td>
							<button id="process_files" class="btn evo-btn-2">upload file</button>
						</td>
					</tr>
				<?php } ?>
				<?php
				$i = 0;
				$filesRemoved = 0;
				while($i <= $totalFiles-1) {

					$tmpFilename = urldecode($files['files'][$i]['FileName']);
					$tmpFilename = explode("\\", $tmpFilename);
					$tempFilenamePieces = count($tmpFilename);

					$fileExt = explode(".", $tmpFilename[$tempFilenamePieces-1]);

					if(isset($fileExt[1])) {
						$fileExt = $fileExt[1];
					} else {
						$fileExt = "not_set";
					}

					$our_date = str_replace('EST', ' ',$files['files'][$i]['FileModifiedDate']);
					
					$good_date1 = date('n/j/y',strtotime($our_date));
					$good_date2 = date('g:ia',strtotime($our_date));

					if($fileExt != "json" && $fileExt != "tmp" && $fileExt != "lock" && $fileExt != "ico" && $fileExt != "json" && $fileExt != "uld") { ?>
					<?php

					echo "<tr class='hover_row' data-fileId='".$files['files'][$i]['FileId']."''>";?>
						<td><a href="<?php echo $this->container->getParameter('fileUrl').$files['files'][$i]['FilePath']; ?>" download>
						<?php
						echo substr(urldecode($tmpFilename[$tempFilenamePieces-1]), 0, 24);
						?>
						</a></td>
					<?php	
						echo "<td>".$files['files'][$i]['TaskName']."</td>";
						echo "<td>".$files['files'][$i]['FileType']."</td>";
						echo "<td>".$files['files'][$i]['FileVersion']."</td>";
						echo "<td><span>".$good_date1."</span> at <span>".$good_date2."</span></td>";
						echo "<td>";
						echo		"<a href=\"".$this->container->getParameter('fileUrl').$files['files'][$i]['FilePath']."\" download><i class='fa fa-cloud-download'></i></a>";
						echo "</td>";
						echo "<td>";
						if($userCanEdit) {
							echo "<div class=\"delete_file\" data-fileId=\"".$files['files'][$i]['FileId']."\"><a href=\"#\"><i class=\"fa fa-trash-o\"></i></a></div>";
						}
						echo "</td>";
					echo "</tr>";
					} else {
						$filesRemoved++;
					}
					$i++;
				}
				$totalShowing = $totalFiles-$filesRemoved;
				?>
			</table>
		</div>
	</div>
	<div class="evo-space-biggest"></div>
</div>