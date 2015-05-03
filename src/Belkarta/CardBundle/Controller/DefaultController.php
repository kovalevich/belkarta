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
        $dogovor = $em->getRepository('BlogPublicationsBundle:Publication')->findOneBySlug('dogovor-1');
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
            'form'          => $form->createView(),
            'dogovor'       => $dogovor
        ));
    }

    public function paymentAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $card = $em->getRepository('BelkartaCardBundle:Card')->find($id);

        $seed = time();
        $signature = sha1(
            $seed .
            $this->container->getParameter('webpay.wsb_storeid') .
            $card->getId() .
            $this->container->getParameter('webpay.test') .
            'BYR'.
            $card->getPrice() * $this->container->getParameter('cource').
            $this->container->getParameter('webpay.secretkey')
        );

        return $this->render('BelkartaCardBundle:Default:payment.html.twig', array(
            'card'          => $card,
            'seed'          => $seed,
            'signature'     => $signature
        ));
    }

    public function paymentsuccessAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $card = $em->getRepository('BelkartaCardBundle:Card')->find($id);

        if($card) {
            $card->setStatus(1);

            if($card->getType() == 2) {
                $user = $em->getRepository('ProfileUserBundle:User')->find($card->getUser()->getId());
                $user->setType(2);
                $em->persist($user);
            }

            $em->persist($card);
            $em->flush();
        }

        return $this->render('BelkartaCardBundle:Default:paymentsuccess.html.twig');
    }
}
