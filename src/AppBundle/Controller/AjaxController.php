<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class AjaxController extends Controller
{
    protected $serializer;
    public function __construct(){
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);
    }
    public function CategoriesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('BlogPublicationsBundle:Category');

        $arr = [array(
            'value' => '',
            'text'  => 'Нет категории'
        )];
        foreach($categories->findAll() as $cat)
        {
            $arr[] = array(
                'value'    => $cat->getId(),
                'text'  => $cat->getTitle()
            );
        }
        return new JsonResponse($arr);
    }

    public function TypesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('BelkartaCompanyBundle:Type');

        $arr = [array(
            'value' => '',
            'text'  => 'Нет категории'
        )];
        foreach($categories->findAll() as $cat)
        {
            $arr[] = array(
                'value'    => $cat->getId(),
                'text'  => $cat->getTitle()
            );
        }
        return new JsonResponse($arr);
    }

    public function PublicationsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('BlogPublicationsBundle:Publication');

        $arr = array();
        $params = array();
        $order = null;

        $search = $request->get('search');
        $search = !empty($search['value']) ? $search['value'] : null;

        $sort = $request->get('order');

        if(!empty($sort[0]))
            $order = array($request->get('columns')[$sort[0]['column']]['data'], $sort[0]['dir']);

        $publications = $repository->getPublicationsWithParams($search, $request->get('length'), $request->get('start'), $order);

        foreach($publications as $publication){
            $arr[] = array(
                'id'    => $publication->getId(),
                'title' => '<a href="' . $this->generateUrl('admin_publication_edit_exist_publication', array(
                        'id' => $publication->getId()
                    )) . '">' . $publication->getTitle() . '</a>',
                'user'  => $publication->getUser()->getUserName(),
                'category'  => $publication->getCategory() ? $publication->getCategory()->getTitle() : '-',
                'created'   => $publication->getCreated()->format('d.m.Y'),
                'delete'    => '<a href="' . $this->generateUrl('admin_article_delete', array(
                        'id' => $publication->getId()
                    )) . '" class="mod-delete"><i class="fa fa-trash-o"></i></a>'
            );
        }

        $total = $repository->getCount();

        return new JsonResponse(array(
            'recordsTotal' => count($arr),
            'recordsFiltered' => $total["1"],
            'data' => $arr
        ));
    }

    public function CompaniesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('BelkartaCompanyBundle:Company');

        $arr = array();
        $params = array();
        $order = null;

        $search = $request->get('search');
        $search = !empty($search['value']) ? $search['value'] : null;

        $sort = $request->get('order');

        if(!empty($sort[0]))
            $order = array($request->get('columns')[$sort[0]['column']]['data'], $sort[0]['dir']);

        $publications = $repository->getCompaniesWithParams($search, $request->get('length'), $request->get('start'), $order);

        foreach($publications as $publication){
            $arr[] = array(
                'id'    => $publication->getId(),
                'name' => '<a href="' . $this->generateUrl('admin_panel_company_edit', array(
                        'id' => $publication->getId()
                    )) . '">' . $publication->getName() . '</a>',
                'created'   => $publication->getCreated()->format('d.m.Y'),
                'delete'    => '<a href="' . $this->generateUrl('admin_panel_belkarta_company_delete', array(
                        'id' => $publication->getId()
                    )) . '" class="mod-delete"><i class="fa fa-trash-o"></i></a>'
            );
        }

        $total = $repository->getCount();

        return new JsonResponse(array(
            'recordsTotal' => count($arr),
            'recordsFiltered' => $total["1"],
            'data' => $arr
        ));
    }

    public function UsersAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ProfileUserBundle:User');

        $arr = array();
        $params = array();
        $order = null;

        $search = $request->get('search');
        $search = !empty($search['value']) ? $search['value'] : null;

        $sort = $request->get('order');

        if(!empty($sort[0]))
            $order = array($request->get('columns')[$sort[0]['column']]['data'], $sort[0]['dir']);

        $users = $repository->getUsersWithParams($search, $request->get('length'), $request->get('start'), $order);

        foreach($users as $user){
            $arr[] = array(
                'id'    => $user->getId(),
                'name' => '<a href="' . $this->generateUrl('admin_users_edit', array(
                        'id' => $user->getId()
                    )) . '">' . $user->getUserName() . '</a>',
                'created'   => $user->getCreated()->format('d.m.Y'),
                'delete'    => '<a href="' . $this->generateUrl('admin_users_delete', array(
                        'id' => $user->getId()
                    )) . '" class="mod-delete"><i class="fa fa-trash-o"></i></a>'
            );
        }

        $total = $repository->getCount();

        return new JsonResponse(array(
            'recordsTotal' => count($arr),
            'recordsFiltered' => $total["1"],
            'data' => $arr
        ));
    }

    public function CardsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('BelkartaCardBundle:Card');

        $arr = array();
        $params = array();
        $order = null;

        $search = $request->get('search');
        $search = !empty($search['value']) ? $search['value'] : null;

        $sort = $request->get('order');

        if(!empty($sort[0]))
            $order = array($request->get('columns')[$sort[0]['column']]['data'], $sort[0]['dir']);

        $cards = $repository->getCardsWithParams($search, $request->get('length'), $request->get('start'), $order);

        foreach($cards as $card){
            if($card->getType() == 'card-2' || $card->getType() == 'card-1') continue;
            $status = '-';
            switch($card->getStatus()){
                case '0':
                    $status = 'ожидает';
                    break;
                case '1':
                    $status = 'оплачена';
                    break;
                case '2':
                    $status = 'отправлена';
                    break;
                case '3':
                    $status = 'получена';
                    break;
                default: $status = 'неизвестно';
            }
            $type = '';
            switch($card->getType()){
                case 'card-2':
                    continue;
                    $type = '<span style="color: red">*classic</span>';
                    break;
                case 'card-1':
                    continue;
                    $type = '<span style="color: red">*platinum</span>';
                    break;
                case '1':
                    $type = 'classic';
                    break;
                default:
                    $type = 'platinum';
                    break;
            }
            $arr[] = array(
                'id'        => $card->getId(),
                'user'      => $card->getUser() ? '<a href="' . $this->generateUrl('admin_users_edit', array(
                        'id' => $card->getUser()->getId()
                    )) . '">' . $card->getUser()->getUserName() . '</a>' : '-',
                'refer' => $card->getUser()->getRefer() ? '<a href="' . $this->generateUrl('admin_users_edit', array(
                        'id' => $card->getUser()->getRefer()->getId()
                    )) . '">' . $card->getUser()->getRefer()->getUserName() . '</a>' : '-',
                'type'      => $type,
                'phone'     => $card->getPhone(),
                'address'   => $card->getAddress(),
                'updated'      => $card->getUpdated()->format('d.m.Y'),
                'status'   =>  $status,
                'delete'    => '<a href="' . $this->generateUrl('admin_cards_delete', array(
                        'id' => $card->getId()
                    )) . '" class="mod-delete"><i class="fa fa-trash-o"></i></a>'
            );
        }

        $total = $repository->getCount();

        return new JsonResponse(array(
            'recordsTotal' => count($arr),
            'recordsFiltered' => $total["1"],
            'data' => $arr
        ));
    }

    public function ThemesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('BlogPublicationsBundle:Theme');

        $arr = array();
        $order = null;

        $search = $request->get('search');
        $search = !empty($search['value']) ? $search['value'] : null;

        $sort = $request->get('order');

        if(!empty($sort[0]))
            $order = array($request->get('columns')[$sort[0]['column']]['data'], $sort[0]['dir']);

        $themes = $repository->getThemesWithParams($search, $request->get('length'), $request->get('start'), $order);

        foreach($themes as $theme){
            $arr[] = array(
                'id'    => $theme->getId(),
                'title' => $theme->getTitle(),
                'delete'    => '<a href="' . $this->generateUrl('admin_theme_delete', array(
                        'id' => $theme->getId()
                    )) . '" class="mod-delete"><i class="fa fa-trash-o"></i></a>'
            );
        }

        $total = $repository->getCount();

        return new JsonResponse(array(
            'recordsTotal' => count($arr),
            'recordsFiltered' => $total["1"],
            'data' => $arr
        ));
    }

    public function TagsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('BlogPublicationsBundle:Theme');

        $arr = array();
        if($request->get('mode') == 'init') {
            $words = explode(',', urldecode($request->get('word')));
            foreach ($words as $word) {
                $tags = $repository->getAllByTitle($word);

                foreach ($tags as $tag)
                {
                    $arr[] = array(
                        'tagName' => $tag->getTitle(),
                        'tagId'     => $tag->getId()
                    );
                }
            }
        }
        else {
            $tags = $repository->getThemesWithParams(urldecode($request->get('word')));
            foreach ($tags as $tag)
            {
                $arr[] = array(
                    'tagName' => $tag->getTitle(),
                    'tagId'     => $tag->getId()
                );
            }
        }

        return new JsonResponse($arr);
    }
}
