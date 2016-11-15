<?php

namespace BISSAP\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BISSAPCoreBundle:Default:index.html.twig');
    }
}
