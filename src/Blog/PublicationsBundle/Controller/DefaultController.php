<?php

namespace Blog\PublicationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository('BlogPublicationsBundle:Publication')->findOneBySlug($slug);

        return $this->render('BlogPublicationsBundle:Default:index.html.twig', array('publication' => $publication));
    }
}
