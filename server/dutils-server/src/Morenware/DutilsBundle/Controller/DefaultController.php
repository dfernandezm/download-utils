<?php

namespace Morenware\DutilsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MorenwareDutilsBundle:Default:index.html.twig', array('name' => $name));
    }
}
