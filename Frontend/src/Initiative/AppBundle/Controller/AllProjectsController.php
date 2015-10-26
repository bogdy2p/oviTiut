<?php

namespace Initiative\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AllProjectsController extends Controller
{
    public function indexAction()
    {
    
        //render a PHP template instead
        return $this->render(
            'InitiativeAppBundle:AllProjects:index.html.php'
        );

    }
}