<?php

namespace Initiative\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
    
        //render a PHP template instead
        return $this->render(
            'InitiativeAppBundle:Default:index.html.php',
            array('name' => $name)
        );

    }
}
