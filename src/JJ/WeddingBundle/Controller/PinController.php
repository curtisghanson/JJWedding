<?php

namespace JJ\WeddingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use JJ\WeddingBundle\Entity\Pin;
use JJ\WeddingBundle\Form\PinType;

/**
 * Pin controller.
 *
 */
class PinController extends Controller
{

    /**
     * Lists all Pin entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JJWeddingBundle:Pin')->findAll();

        return $this->render('JJWeddingBundle:Pin:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Pin entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Pin();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pin_show', array('id' => $entity->getId())));
        }

        return $this->render('JJWeddingBundle:Pin:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Pin entity.
    *
    * @param Pin $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Pin $entity)
    {
        $form = $this->createForm(new PinType(), $entity, array(
            'action' => $this->generateUrl('pin_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => '<span class="fa fa-search"></span> Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Pin entity.
     *
     */
    public function newAction()
    {
        $entity = new Pin();
        $form   = $this->createCreateForm($entity);

        return $this->render('JJWeddingBundle:Pin:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pin entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JJWeddingBundle:Pin')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pin entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JJWeddingBundle:Pin:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Pin entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JJWeddingBundle:Pin')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pin entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JJWeddingBundle:Pin:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Pin entity.
    *
    * @param Pin $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Pin $entity)
    {
        $form = $this->createForm(new PinType(), $entity, array(
            'action' => $this->generateUrl('pin_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Pin entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JJWeddingBundle:Pin')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pin entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('pin_show', array('id' => $id)));
        }

        return $this->render('JJWeddingBundle:Pin:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Pin entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JJWeddingBundle:Pin')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pin entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('pin'));
    }

    /**
     * Creates a form to delete a Pin entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pin_delete', array('id' => $id)))
            ->setMethod('POST')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
