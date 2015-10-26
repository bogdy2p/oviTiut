<?php

namespace Initiative\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DownloadFileController extends Controller
{
    public function indexAction()
    {
        //render a PHP template instead
        return $this->render('InitiativeAppBundle:DownloadFile:index.html.php');

    }
}