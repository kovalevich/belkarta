<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('AppBundle:default:index.html.twig', array(
            'home_page' => true
        ));
    }

    public function careerAction()
    {
        return $this->render('AppBundle:default:career.html.twig');
    }
}
