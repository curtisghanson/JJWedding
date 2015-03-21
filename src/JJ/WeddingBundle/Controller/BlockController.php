<?php

namespace JJ\WeddingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use JJ\WeddingBundle\Entity\Block;
use JJ\WeddingBundle\Form\BlockType;

/**
 * Block controller.
 *
 */
class BlockController extends Controller
{

    /**
     * Lists all Block entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JJWeddingBundle:Block')->findAll();

        return $this->render('JJWeddingBundle:Block:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Block entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Block();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('block_show', array('id' => $entity->getId())));
        }

        return $this->render('JJWeddingBundle:Block:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Block entity.
    *
    * @param Block $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Block $entity)
    {
        $form = $this->createForm(new BlockType(), $entity, array(
            'action' => $this->generateUrl('block_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Block entity.
     *
     */
    public function newAction()
    {
        $entity = new Block();
        $form   = $this->createCreateForm($entity);

        return $this->render('JJWeddingBundle:Block:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Block entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JJWeddingBundle:Block')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Block entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JJWeddingBundle:Block:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Block entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JJWeddingBundle:Block')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Block entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JJWeddingBundle:Block:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Block entity.
    *
    * @param Block $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Block $entity)
    {
        $form = $this->createForm(new BlockType(), $entity, array(
            'action' => $this->generateUrl('block_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Block entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JJWeddingBundle:Block')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Block entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if($editForm->isValid()){
            $em->flush();
            return $this->redirect($this->generateUrl('block_show', array('id' => $id)));
        }

        return $this->render('JJWeddingBundle:Block:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Block entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JJWeddingBundle:Block')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Block entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('block'));
    }

    /**
     * Creates a form to delete a Block entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('block_delete', array('id' => $id)))
            ->setMethod('POST')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
