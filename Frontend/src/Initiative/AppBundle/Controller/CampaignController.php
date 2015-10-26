<?php

namespace Initiative\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CampaignController extends Controller
{
    public function indexAction($project_id, $step_id)
    {
        //render a PHP template instead
        return $this->render(
            'InitiativeAppBundle:Campaign:index.html.php',
            array('project_id' => $project_id, 'step_id' => $step_id)
        );

    }
}