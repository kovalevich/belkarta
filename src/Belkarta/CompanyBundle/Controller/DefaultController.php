<?php

namespace Belkarta\CompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Belkarta\CompanyBundle\Entity\Company;

class DefaultController extends Controller
{
    public function indexAction(Request $request, $type, $city){
        $em = $this->getDoctrine()->getManager();
        $types = $em->getRepository('BelkartaCompanyBundle:Type')->findAll();
        $companies = $em->getRepository('BelkartaCompanyBundle:Company')->findAllByParams($type, $city);

        return $this->render('BelkartaCompanyBundle:Default:index.html.twig', array(
            'type'      => $type == 'all' ? $type : $em->getRepository('BelkartaCompanyBundle:Type')->find($type),
            'city'      => $city,
            'types'     => $types,
            'companies' => $companies
        ));
    }

    public function companyAction($id){
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('BelkartaCompanyBundle:Company')->find($id);

        return $this->render('BelkartaCompanyBundle:Default:company.html.twig', array(
            'company'   => $company
        ));
    }

    public function createAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $dogovor = $em->getRepository('BlogPublicationsBundle:Publication')->findOneBySlug('dogovor-1');
        $company = new Company();

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
            ->add('save', 'submit', array(
                'label' => 'Добавить компанию',
                'attr' => array('class'=>'btn-success')
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $company = $form->getData();
            $em->persist($company);
            $em->flush();

            return $this->redirect($this->generateUrl('belkarta_company_created'));
        }

        return $this->render('BelkartaCompanyBundle:Default:create.html.twig', array(
            'form'  => $form->createView(),
            'dogovor'   => $dogovor
        ));
    }

    public function createdAction()
    {
        return $this->render('BelkartaCompanyBundle:Default:created.html.twig');
    }
}
