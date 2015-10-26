<?php

namespace Initiative\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EditCampaignController extends Controller
{
    public function indexAction($project_id)
    {
    
        //render a PHP template instead
        return $this->render(
            'InitiativeAppBundle:EditCampaign:index.html.php', 
            array('project_id' => $project_id)
        );

    }
}