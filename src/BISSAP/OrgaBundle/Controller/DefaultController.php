<?php

namespace BISSAP\OrgaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BISSAPOrgaBundle:Default:index.html.twig');
    }
}
