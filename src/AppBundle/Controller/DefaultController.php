<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('BlogPublicationsBundle:Publication');

        return $this->render('AppBundle:default:index.html.twig', array(
            'news'      => $repository->findOneByShowInHome(1),
            'news_list'      => $repository->findByShowInHome(1),
            'home_page' => true
        ));
    }

    public function careerAction()
    {
        return $this->render('AppBundle:default:career.html.twig');
    }
}
