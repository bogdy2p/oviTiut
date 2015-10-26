<?php

namespace Initiative\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FilesController extends Controller
{
    public function indexAction()
    {
    
        //render a PHP template instead
        return $this->render(
            'InitiativeAppBundle:Files:index.html.php'
        );

    }
}