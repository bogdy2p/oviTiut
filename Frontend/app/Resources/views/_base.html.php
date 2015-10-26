<?php
$request = $this->container->get('request');
$routeName = $request->get('_route');
session_start();

// not logged in
if(!isset($_COOKIE['username'])) {
    if($routeName != "initiative_app_login") {
        header('Location: login') ;
        die();
    }
}
if(isset($_COOKIE['username'])) {
    if($routeName == "initiative_app_login") {
        header('Location: dash') ;
        die();
    }
} ?>
    <?php echo $view->render('InitiativeAppBundle:Inc:header.html.php'); ?>
        <nav class="st-menu st-effect-1" id="menu-12">
        <div class="widen main-nav-container">
        <div class="evo-space-bigger"></div>
        <div class="evo_action_ico loader">
            <a href="<?php echo $view['router']->generate('initiative_app_homepage') ?>" class="btn_action">
                <div class="evo-ico evo-ico-active">
                    <?php include('img/svg/3.php'); ?>
                </div>
                <span><div class="arrow-left_tool"></div>Dashboard</span>
            </a>
            <!-- <div class="arrow-left"></div> -->
        </div>
        <div class="evo-space-bigger evo-space-collapse"></div>
        <div class="evo_action_ico loader">
            <a href="<?php echo $view['router']->generate('initiative_app_allProjects') ?>" class="btn_action">
                <div class="evo-ico evo-ico-flip-y">
                    <?php include('img/svg/1.php'); ?>
                </div>
                <span><div class="arrow-left_tool"></div>All Projects</span>
            </a>
        </div>
        <div class="evo-space-bigger evo-space-collapse"></div>
        <div class="evo_action_ico loader">
            <a href="<?php echo $view['router']->generate('initiative_app_projectRollup') ?>" class="btn_action">
                <div class="evo-ico">
                    <?php include('img/svg/2.php'); ?>
                </div>
                <span><div class="arrow-left_tool"></div>Project Rollup</span>
            </a>
        </div>
        <div class="evo-space-bigger evo-space-collapse"></div>
        <div class="evo_action_ico loader">
            <a href="<?php echo $view['router']->generate('initiative_app_allFiles') ?>" class="btn_action">
                <div class="evo-ico">
                    <?php include('img/svg/6.php'); ?>
                </div>
                <span><div class="arrow-left_tool"></div>All Files</span>
            </a>
        </div>
        <div class="evo-space-bigger evo-space-collapse"></div>
        <div class="evo_action_ico loader">
            <a href="<?php echo $view['router']->generate('initiative_app_goldenRules') ?>" class="btn_action">
                <div class="evo-ico">
                    <?php include('img/svg/5.php'); ?>
                </div>
                <span><div class="arrow-left_tool"></div>Golden Rules</span>
            </a>
        </div>
        <div class="evo-space-bigger evo-space-collapse"></div>
        <div class="evo_action_ico loader">
            <a href="<?php echo $view['router']->generate('initiative_app_admin') ?>" class="btn_action">
                <div class="evo-ico">
                    <?php include('img/svg/7.php'); ?>
                </div>
                <span><div class="arrow-left_tool"></div>Admin</span>
            </a>
        </div>
        </div>
            <div class="sub_links">
                <ul class="menu no-bullets">
                    <li class="sub-menu">
                        <ul class="no-bullets">
                            <h4 class="evo-header evo-white evo-ff3 margin-top-0 margin-bottom-0">tools</h4>
                            <a href="#"><li>Allocate</li></a>
                            <a href="#"><li>Matrix</li></a>
                            <a href="#"><li>Real Lives</li></a>
                            <a href="#"><li>Touch Point Map</li></a>
                            <a href="#"><li>MegaStar</li></a>
                            <div class="evo-space evo-space-collapse"></div>
                            <h4 class="evo-header evo-white evo-ff3 margin-top-0 margin-bottom-0">resources</h4>
                            <a href="http://honey.is" target="_blank"><li>Honey</li></a>
                            <a href="https://knowledge.initiative.com" target="_blank"><li>Knowledge Center</li></a>
                            <a href="http://fbds.initiative.com/" target="_blank"><li>Branding Page</li></a>
                            <a href="#"><li>The Trove</li></a>
                            <a href="https://www.mbww.com/flite/" target="_blank"><li>FLITE</li></a>
                            <div class="evo-space evo-space-collapse"></div>
                            <h4 class="evo-header evo-white evo-ff3 margin-top-0 margin-bottom-0">client links</h4>
                            <a href="https://knowledge.initiative.com/display/UN/" target="_blank"><li>Unilever Wiki Space</li></a>
                            <a href="#"><li>Unilever Client Extranet</li></a>
                            <a href="#"><li>Unilever Digital Reporting</li></a>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- content push wrapper -->
        <div class="st-pusher">
        <div class="st-content"><!-- this is the wrapper for the content -->
            <div class="st-content-inner"><!-- extra div for emulating position:fixed of the menu -->
                                    
                <?php if(isset($_GET['type'])) {
                    $test = $_GET['type'];
                    if($test!='ajax'){
                        
                        //if($routeName != "initiative_app_login") {
                            echo $view->render('InitiativeAppBundle:Inc:navigation.html.php');
                        //}
                    }
                } else {
                    //if($routeName != "initiative_app_login") {
                        echo $view->render('InitiativeAppBundle:Inc:navigation.html.php');
                    //}
                }
                ?>
                
                <div id="main-content">
                <?php $view['slots']->output('_content') ?>
                </div>
            </div><!-- /st-content-inner -->
        </div><!-- /st-content -->

    </div><!-- /st-pusher -->
<?php
if(isset($_GET['type'])) {
    $test = $_GET['type'];
    if($test!='ajax'){
        echo $view->render('InitiativeAppBundle:Inc:footer.html.php');
    }
} else {
    echo $view->render('InitiativeAppBundle:Inc:footer.html.php');
}
?>