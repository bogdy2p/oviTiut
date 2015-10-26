<?php

namespace Initiative\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DownloadPPTController extends Controller
{
    public function indexAction()
    {
        //render a PHP template instead
        return $this->render('InitiativeAppBundle:DownloadPPT:index.html.php');

    }
}