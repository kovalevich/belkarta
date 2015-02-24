<?php

namespace Admin\PanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CardsController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdminPanelBundle:Cards:index.html.twig');
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('BelkartaCardBundle:Card')->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No company found for id '.$id
            );
        }

        return $this->render('AdminPanelBundle:Users:edit.html.twig', array(
            'user'   => $user
        ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('BelkartaCardBundle:Card')->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No card found for id '.$id
            );
        }

        $em->remove($user);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_cards_index'));
    }
}
