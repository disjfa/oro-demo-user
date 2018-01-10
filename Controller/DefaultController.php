<?php

namespace Disjfa\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DisjfaDemoBundle:Default:index.html.twig');
    }
}
