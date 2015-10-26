<?php $view->extend('::base.html.php') ?>
<link rel="stylesheet/less" type="text/css" href="<?php echo $view['assets']->getUrl('css/jquery.dataTables.bootstrap.css') ?>">
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

  
    $tasks = $obj['tasks_data'];
    $i = 0;
} else {
  header('Location: /login');
  die;
}

?>

<div class="container">
  <div class="row">
    <div class="offset-wrapper">

		<!-- <div class="col-xs-12 evo-white"> -->
<!-- 			<div class="row project_data_sidebar" style="padding-bottom: 20px;">
				<div class="col-xs-10 col-xs-offset-2"> -->

          <!-- HEADER -->
          <div class="row">
            <div class="col-xs-11">
              <div class="evo-space"></div>
                <p class="evo-text-smaller-upper">Unilever Dash</p>
                <h1 class="evo-header-bigger margin-top-0 text-swap font_stack_4">My Assignments</h1>
              </div>
            </div>
      
            <div class="row">
              <div class="col-xs-12">
                <div class="tab_bar">
                  <div class="tab"><p class="evo-text-small evo-blue" style="text-transform: uppercase;"><?php echo $tasks_count; ?> tasks</p></div>
                </div>
              
              </div>
            </div>
      
      
      
                <table id="tasks-table"> 
                <thead> 
                <tr> 
                    <th data-sort="int">Presentation<br />Date</th> 
                    <th data-sort="string">Status</th> 
                    <th data-sort="string">Task</th> 
                    <th data-sort="string">Campaign</th> 
                    <th data-sort="string">Client</th> 
                    <th data-sort="string">Brand</th>
                    <th data-sort="string">Market</th>
                    <th data-sort="int">Year</th>
                </tr> 
                </thead> 
                <tbody> 
                  <?php foreach ($tasks as $task) { 
                    // convert the status date
                    $status_date = $task['last_task_status_date'];
                    $campaign_id = $task['campaign_id'];
                    $date = date_create($status_date);
                    $status_date_display = date_format($date, 'm/d/y');
                    $message = $task['last_task_message']; 
                    $messageDate = $task['last_task_status_date'];
                    $messageFirstName = $task['status_changer_first_name'];
                    $messageLasttName = $task['status_changer_last_name'];
                    $messagePicture = $task['status_changer_profile_picture'];
      
                    $taskName = $task['task_name'];
                    if($taskName == "JTBD") {
                      $taskId = "100";
                    }
                    if($taskName == "Comm Tasks") {
                      $taskId = "200";
                    }
                    if($taskName == "Real Lives") {
                      $taskId = "300";
                    }
                    if($taskName == "Media Idea") {
                      $taskId = "400";
                    }
                    if($taskName == "Fundamental Channels") {
                      $taskId = "500";
                    }
                    if($taskName == "Budget Allocation & Mapping") {
                      $taskId = "600";
                    }
                    if($taskName == "Phasing") {
                      $taskId = "700";
                    }
                    if($taskName == "Final Plan") {
                      $taskId = "800";
                    }
                    if($taskName == "Outcome") {
                      $taskId = "900";
                    }
      
      
      
                  ?>
                  <?php if($task['last_task_status'] != "Completed") { ?>
                  <tr class="hover_row <?php if($task['last_task_message']) { echo "message_below"; }?>">
                    <td><p class="evo-text-smaller"><?php echo $status_date_display;  ?></p></td>
                    <td><p class="evo-text-smaller"><?php echo $task['last_task_status']; ?></p></td>
                    <td><p class="evo-text-smaller"><a href="campaign/<?php echo $campaign_id."/".$taskId; ?>"><?php echo $task['task_name']; ?></a></p></td>
                    <td><p class="evo-text-smaller"><a href="campaign/<?php echo $campaign_id; ?>/0"><?php echo $task['campaign_name']; ?></a></p></td>
                    <!-- second call for campaign data -->
                      <?php
                      // set the campign id
                        $campaign_id = $task['campaign_id'];
                        $url2 = $this->container->getParameter('apiUrl')."campaigns/".$campaign_id.".json";
      
      
                        $accesstoken = $_COOKIE['api'];
      
                        $headr2 = array();
                        $headr2[] = 'Content-length: 0';
                        $headr2[] = 'Content-type: application/json';
                        $headr2[] = 'x-wsse: ApiKey="'.$accesstoken.'"';
      
                        $ch2 = curl_init();
      
                        curl_setopt($ch2, CURLOPT_URL,$url2);
                        curl_setopt($ch2, CURLOPT_HTTPHEADER,$headr2);
                        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, TRUE);
      
                        $result2=curl_exec($ch2);
                        curl_close($ch2);
      
                        $obj2 = json_decode($result2, true);
      
                        if(isset($obj2['Campaign'])) {
                          $cinfo_count = count($obj2['Campaign']);
                        } else {
                          $cinfo_count = 0;
                        }
                        if(isset($obj2['Campaign'])) {
                          $cinfo = $obj2['Campaign'];
                        }
                        $i = 0;
                      ?>          
      
                    <td><p class="evo-text-smaller"><?php echo $cinfo['ClientName']; ?></p></td>
                    <td><p class="evo-text-smaller"><?php echo $cinfo['Brand']; ?></p></td>
                    <td><p class="evo-text-smaller"><?php echo $cinfo['Country']; ?></p></td>
                      <?php
                      // convert competion date to year
                      $completion_date = $cinfo['CompletionDate'];
                      $date = date_create($completion_date);
                      $completion_year = date_format($date, 'Y');
                      ?>
                    
                    <td><p class="evo-text-smaller"><?php echo $completion_year; ?></a></td>
                    <td>
                      <?php if($task['last_task_message']) { ?>
                      <div class="message_left">
                        <div class="member_photo">
                          <div class="photo" style="background-image: url('<?php if($messagePicture != null) {echo $messagePicture;}else { echo $view['assets']->getUrl('img/no-face.png');}?>');"></div>
                        </div>
                      </div>
                      <?php } ?>
                      <?php if($task['last_task_message']) { ?>
                      <div class="message_right">
                      <?php } ?>
                        <?php echo $task['last_task_message']; ?>
                        <?php if($task['last_task_message']) { ?><p class="evo-gray" style="padding-top: 10px; padding-bottom: 5px;"><?php if(isset($messageFirstName)) { ?>by <?php echo $messageFirstName." ".$messageFirstName; ?> on<?php } ?> <?php echo $messageDate; ?></p><?php } ?>
                      <?php if($task['last_task_message']) { ?>
                      </div>
                      <?php } ?>
                    </td>
      
                  </tr>
                  <?php $i++; ?>
                  <?php } ?>
                <?php } ?>
              </tbody> 
              </table> 
      
      
          </div><!-- /col-xs-10 col-xs-offset-2 --> 
        </div><!-- row project_data_sidebar -->
      </div><!-- col-xs-8 evo-white --></div>
  </div>
</div>
