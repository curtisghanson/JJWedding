<?php

namespace JJ\WeddingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use JJ\WeddingBundle\Entity\Registrant;
use JJ\WeddingBundle\Form\RegistrantType;
use JJ\WeddingBundle\Form\RegistrantRsvpType;

/**
 * Registrant controller.
 *
 */
class RegistrantController extends Controller
{

    /**
     * Lists all Registrant entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JJWeddingBundle:Registrant')->findAll();

        return $this->render('JJWeddingBundle:Registrant:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Registrant entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Registrant();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('registrant_show', array('id' => $entity->getId())));
        }

        return $this->render('JJWeddingBundle:Registrant:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Registrant entity.
    *
    * @param Registrant $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Registrant $entity)
    {
        $form = $this->createForm(new RegistrantType(), $entity, array(
            'action' => $this->generateUrl('registrant_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Registrant entity.
     *
     */
    public function newAction()
    {
        $entity = new Registrant();
        $form   = $this->createCreateForm($entity);

        return $this->render('JJWeddingBundle:Registrant:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Registrant entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JJWeddingBundle:Registrant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Registrant entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JJWeddingBundle:Registrant:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Registrant entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JJWeddingBundle:Registrant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Registrant entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JJWeddingBundle:Registrant:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Registrant entity.
    *
    * @param Registrant $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Registrant $entity)
    {
        $form = $this->createForm(new RegistrantType(), $entity, array(
            'action' => $this->generateUrl('registrant_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Registrant entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JJWeddingBundle:Registrant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Registrant entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('registrant_show', array('id' => $id)));
        }

        return $this->render('JJWeddingBundle:Registrant:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Registrant entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JJWeddingBundle:Registrant')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Registrant entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('registrant'));
    }

    /**
     * Creates a form to delete a Registrant entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('registrant_delete', array('id' => $id)))
            ->setMethod('POST')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

}
