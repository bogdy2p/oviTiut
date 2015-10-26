<?php

namespace Initiative\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
    
        //render a PHP template instead
        return $this->render(
            'InitiativeAppBundle:Home:index.html.php'
        );

    }
}