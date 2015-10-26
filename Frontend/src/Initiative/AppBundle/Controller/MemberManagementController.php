<?php

namespace Initiative\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MemberManagementController extends Controller
{
    public function indexAction($project_id)
    {
    
        //render a PHP template instead
        return $this->render(
            'InitiativeAppBundle:MemberManagement:index.html.php', 
            array('project_id' => $project_id)
        );

    }
}