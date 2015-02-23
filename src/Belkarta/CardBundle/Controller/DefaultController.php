<?php

namespace Belkarta\CardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($type)
    {
        $type = $type == 'classic' ? $type : 'platinum';

        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository('BlogPublicationsBundle:Publication')->findOneBySlug('belkarta-' . $type);

        return $this->render('BelkartaCardBundle:Default:index.html.twig', array(
            'type'          => $type,
            'publication'   => $publication
        ));
    }
}
