<?php

namespace Initiative\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MyTasksController extends Controller
{
    public function indexAction()
    {
    
        //render a PHP template instead
        return $this->render(
            'InitiativeAppBundle:MyTasks:index.html.php'
        );

    }
}