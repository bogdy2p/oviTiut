<?php

namespace Initiative\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AllFilesController extends Controller
{
    public function indexAction()
    {
    
        //render a PHP template instead
        return $this->render(
            'InitiativeAppBundle:AllFiles:index.html.php'
        );

    }
}