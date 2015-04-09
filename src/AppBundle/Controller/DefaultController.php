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
        $news = $repository->findBy(
            array('showInHome' => true),
            array('created' => 'DESC'),
            5,
            null
        );

        return $this->render('AppBundle:default:index.html.twig', array(
            'news'      => $news,
            'home_page' => true
        ));
    }

    public function careerAction()
    {
        return $this->render('AppBundle:default:career.html.twig');
    }
}
