<?php

namespace BISSAP\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BISSAPUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
