<?php

namespace Admin\PanelBundle\Controller;

use Belkarta\CompanyBundle\Entity\Type;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TypesController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $type = new Type();

        $form = $this->createFormBuilder($type)
            ->add('title', 'text', array(
                'label' => 'Название типа',
            ))
            ->add('save', 'submit', array('label' => 'Добавить тип'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $type = $form->getData();
            $em->persist($type);
            $em->flush();
        }

        $types = $em->getRepository('BelkartaCompanyBundle:Type')->findAll();

        return $this->render('AdminPanelBundle:Type:index.html.twig', array(
            'form'  => $form->createView(),
            'types' => $types
        ));
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $type = $em->getRepository('BelkartaCompanyBundle:Type')->find($id);

        if (!$type) {
            $type = new Type();
        }

        $form = $this->createFormBuilder($type)
            ->add('title', 'text', array(
                'label' => 'Тип',
            ))
            ->add('save', 'submit', array('label' => 'Сохранить'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $type = $form->getData();
            $em->persist($type);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_panel_belkarta_types'));
        }

        return $this->render('AdminPanelBundle:Type:edit.html.twig', array(
            'type'   => $type,
            'form'      => $form->createView()
        ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $type = $em->getRepository('BelkartaCompanyBundle:Type')->find($id);

        if (!$type) {
            throw $this->createNotFoundException(
                'No publication found for id '.$id
            );
        }

        $em->remove($type);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_panel_belkarta_types'));
    }
}
