<?php

namespace AWBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AWBundle:Default:index.html.twig', array('name' => $name));
    }

    public function displayAction()
    {
        return $this->render('AWBundle:Default:new.html.twig', array('name' => 'daniel'));
    }
}
