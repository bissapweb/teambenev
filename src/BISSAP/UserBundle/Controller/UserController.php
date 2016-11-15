<?php

namespace BISSAP\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

use BISSAP\UserBundle\Entity\User;
use BISSAP\CoreBundle\Entity\Mobility;
use BISSAP\UserBundle\Form\UserType;

/**
 * User controller.
 *
 */
class UserController extends Controller
{

    public function ajaxUserAction(Request $request) {
        if (! $request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        // Get the province ID
        $id = $request->query->get('regions_id');
        //$id = '12';
        // echo('test');
        // die();
        //return "test";
        $result = array();
        // Return a list of cities, based on the selected province
        $repo = $this->getDoctrine()->getManager()->getRepository('BISSAPCoreBundle:Departements');
        $deps = $repo->findByRegions($id, array('name' => 'asc'));
        foreach ($deps as $dep) {
            $result[$dep->getName()] = $dep->getId();
        }
        return new JsonResponse($result);
    }

    public function ajaxLoadAction(Request $request) {
        if (! $request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

      
        $result = array();
        // Return a list of cities, from Mobility
        $repo = $this->getDoctrine()->getManager()->getRepository('BISSAPCoreBundle:Mobility');
        $repo2 = $this->getDoctrine()->getManager()->getRepository('BISSAPCoreBundle:Departements');
        $mobilities = $repo->findBy( array('user' => $this->getUser()) );
        // $deps = $repo->findBy( array('user' => $this->getUser()) );
        foreach ($mobilities as $mobility) {

            $dep = $repo2->findOneBy( array('id' => $mobility->getId()));
            $result[$mobility->getDepartement()->getName()] = $mobility->getDepartement()->getId();
        }
        // dump($result);
        // die;
        return new JsonResponse($result);
    }

    //Enregitrment en db des departements selectionnés dans le profil
    public function ajaxSubmitAction(Request $request) {
        if (! $request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }
        $em = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent(), true);

        $repo1 = $this->getDoctrine()->getManager()->getRepository('BISSAPCoreBundle:Mobility');
        $mobilities = $repo1->findBy( array('user' => $this->getUser()) );
        
        foreach ($mobilities as $mobility) {
            $em->remove($mobility);
        }

        foreach ($data['items'] as $v) {

        $val = $v['id'];
        $entity = new Mobility();

        $repo2 = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('BISSAPCoreBundle:Departements');

        $dep = $repo2->findOneBy(array('id' => $v['id']));

        $entity->setDepartement($dep);
        $entity->setUser($user = $this->getUser());
        $em->persist($entity);
    }
        $em->flush();

        return new Response();

    }



    /**
     * Lists all User entities.
     *
     */
    public function indexAction(Request $request, $type="Tous", $genre="Tous", $dep="Tous")
    {
        $em = $this->getDoctrine()->getManager();

        //$entities = $em->getRepository('BISSAPUserBundle:User')->findAll();
        $entities = $em->getRepository('BISSAPUserBundle:User')->findUserEventOrgaQuery($type, $genre, $dep);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
        $entities, /* query NOT result */
        $request->query->getInt('page', 1)/*page number*/,
        10/*limit per page*/
    );

        return $this->render('BISSAPUserBundle:User:index.html.twig', array('pagination' => $pagination));
    }
    /**
     * Creates a new User entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new User();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('user_show', array('id' => $entity->getId())));
        }

        return $this->render('BISSAPUserBundle:User:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('user_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     *
     */
    public function newAction()
    {
        $entity = new User();
        $form   = $this->createCreateForm($entity);

        return $this->render('BISSAPUserBundle:User:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BISSAPUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BISSAPUserBundle:User:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BISSAPUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BISSAPUserBundle:User:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(User $entity)
    {
        $form = $this->createForm(new UserType($this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('user_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BISSAPUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            // return $this->redirect($this->generateUrl('user_edit', array('id' => $id)));
            return $this->redirect($this->generateUrl('bissap_coreBundle_index'));
        }

        return $this->render('BISSAPUserBundle:User:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
      
        $em = $this->getDoctrine()->getManager();
             $entity = $em->getRepository('BISSAPUserBundle:User')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
            //  $token = new AnonymousToken($providerKey, 'anon.');
             $this->get('security.context')->setToken(null);
             $this->get('request')->getSession()->invalidate();
            //return $this->render('BISSAPCoreBundle:Default:index.html.twig');
            return $this->redirect( $this->generateUrl( 'fos_user_security_logout' ) );

    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
