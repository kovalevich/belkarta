<?php

namespace Admin\PanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CompanyController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdminPanelBundle:Company:index.html.twig');
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('BelkartaCompanyBundle:Company')->find($id);

        if (!$company) {
            throw $this->createNotFoundException(
                'No company found for id '.$id
            );
        }

        $form = $this->createFormBuilder($company)
            ->add('name', 'text', array(
                'label' => 'Название компании',
            ))
            ->add('contactUser', 'text', array(
                'label' => 'Имя представителя',
            ))
            ->add('phone', 'text', array(
                'label' => 'Телефон для связи',
            ))
            ->add('email', 'email', array(
                'label' => 'E-MAIL',
            ))
            ->add('save', 'submit', array('label' => 'Сохранить компанию'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $company = $form->getData();
            $em->persist($company);
            $em->flush();

            return $this->redirect($this->generateUrl('belkarta_company_created'));
        }

        return $this->render('AdminPanelBundle:Company:edit.html.twig', array(
            'company'   => $company,
            'form'      => $form->createView()
        ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('BelkartaCompanyBundle:Company')->find($id);

        if (!$company) {
            throw $this->createNotFoundException(
                'No publication found for id '.$id
            );
        }

        $em->remove($company);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_panel_belkarta_companies'));
    }
}
