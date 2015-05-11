<?php

namespace Belkarta\CompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Belkarta\CompanyBundle\Entity\Company;

class DefaultController extends Controller
{
    public function indexAction(Request $request, $page, $type, $city){
        $em = $this->getDoctrine()->getManager();
        $types = $em->getRepository('BelkartaCompanyBundle:Type')->findAll();
        $companies = $em->getRepository('BelkartaCompanyBundle:Company')->findAllByParams($type, $city);

        $limit = 2;
        $page = $request->get('page');

        if(!is_numeric($page) || $page < 1) $page = 1;

        $query = $em->getRepository('BelkartaCompanyBundle:Company')->getPage($type, $city);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('BelkartaCompanyBundle:Default:index.html.twig', array(
            'type'      => $type == 'all' ? $type : $em->getRepository('BelkartaCompanyBundle:Type')->find($type),
            'city'      => $city,
            'types'     => $types,
            'pagination'    => $pagination
        ));
    }

    public function companyAction($id){
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('BelkartaCompanyBundle:Company')->find($id);

        //foreach($company->getCities())

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
