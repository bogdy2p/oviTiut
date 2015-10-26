<?php
$request = $this->container->get('request');
$routeName = $request->get('_route');
session_start();

// not logged in
if(!isset($_COOKIE['api'])) {
    if($routeName != "initiative_app_login") {
        header('Location: login') ;
        die();
    }
}
if(isset($_COOKIE['api'])) {
    if($routeName == "initiative_app_login") {
        header('Location: dash') ;
        die();
    }
}

if(isset($_GET['type'])) {
    $test = $_GET['type'];
    if($test!='ajax'){
        echo $view->render('InitiativeAppBundle:Inc:header.html.php');
        //if($routeName != "initiative_app_login") {
            echo $view->render('InitiativeAppBundle:Inc:navigation.html.php');
        //}
        echo "<div id=\"main-content\">";
    }
} else {
    echo $view->render('InitiativeAppBundle:Inc:header.html.php');
    //if($routeName != "initiative_app_login") {
        echo $view->render('InitiativeAppBundle:Inc:navigation.html.php');
    //}
    echo "<div id=\"main-content\" class=\"min-height\">";
}
?>


<?php $view['slots']->output('_content') ?>



<?php
if(isset($_GET['type'])) {
    $test = $_GET['type'];
    if($test!='ajax'){
        echo "</div>";
        echo $view->render('InitiativeAppBundle:Inc:footer.html.php');
    }
} else {
    echo "</div>";
    echo $view->render('InitiativeAppBundle:Inc:footer.html.php');
}
?>