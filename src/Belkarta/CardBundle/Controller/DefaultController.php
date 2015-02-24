<?php

namespace Belkarta\CardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Belkarta\CardBundle\Entity\Card;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction($type)
    {
        $type = $type == 'classic' ? $type : 'platinum';

        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository('BlogPublicationsBundle:Publication')->findOneBySlug('belkarta-' . $type);

        $type = $type == 'classic' ? 1 : 2;
        $em = $this->getDoctrine()->getManager();
        $card = $em->getRepository('BelkartaCardBundle:Card')->findOneByType('card-' . $type);

        return $this->render('BelkartaCardBundle:Default:index.html.twig', array(
            'type'          => $type,
            'publication'   => $publication,
            'card'          => $card
        ));
    }

    public function buyAction(Request $request, $type)
    {
        $type = $type == 1 ? 1 : 2;

        $em = $this->getDoctrine()->getManager();
        $card = $em->getRepository('BelkartaCardBundle:Card')->findOneByType('card-' . $type);

        $new_card = new Card();
        $form = $this->createFormBuilder($new_card)
            ->add('address', 'textarea', array(
                'label' => 'Адрес для отправки',
            ))
            ->add('phone', 'text', array(
                'label' => 'Телефон для связи',
            ))
            ->add('save', 'submit', array('label' => 'Перейти к оплате', ))
            ->add('savelater', 'submit', array('label' => 'Оплатить позже', ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $new_card = $form->getData();
            $new_card->setUser($this->getUser());
            $new_card->setType($type);
            $new_card->setStatus(0);
            $new_card->setPrice($card->getPrice());
            $em->persist($new_card);
            $em->flush();

            $nextAction = $form->get('save')->isClicked()
                ? 'belkarta_payment_start'
                : 'home';

            return $nextAction == 'belkarta_payment_start' ? $this->redirect($this->generateUrl('belkarta_payment_start', array(
                'id'    => $new_card->getId()
            ))) : $this->redirect($this->generateUrl('fos_user_profile_show'));
        }

        return $this->render('BelkartaCardBundle:Default:buy.html.twig', array(
            'type'          => $type,
            'card'          => $card,
            'form'          => $form->createView()
        ));
    }

    public function paymentAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $card = $em->getRepository('BelkartaCardBundle:Card')->find($id);

        return $this->render('BelkartaCardBundle:Default:payment.html.twig', array(
            'card'          => $card
        ));
    }
}
