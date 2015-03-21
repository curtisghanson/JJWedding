<?php
namespace JJ\WeddingBundle\Controller;

use JJ\WeddingBundle\Entity\Document;
use JJ\WeddingBundle\Form\DocumentType;
use JJ\WeddingBundle\Form\DocumentMetaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Tools\Pagination\Paginator;

class DocumentController extends Controller
{

    /**
     * Lists all Document entities.
     *
     */
    public function indexAction($page = 1)
    {
        $limit  = 10;
        $offset = ($page - 1) * $limit;

        $em = $this->getDoctrine()->getManager();

        $qb = $em->createQueryBuilder();

        $qb->select('d')
           ->from('JJWeddingBundle:Document', 'd')
           ->orderBy('d.id', 'ASC')
           ->setFirstResult($offset)
           ->setMaxResults($limit);

        $entities = new Paginator($qb);

        $c = count($entities);

        $total = $c/$limit + (0 == $c%$limit ? 0 : 1);
        //$entities = $em->getRepository('JJWeddingBundle:Document')->findAll();

        return $this->render('JJWeddingBundle:Document:index.html.twig', array(
            'entities' => $entities,
            'page'     => $page,
            'total'    => $total,
        ));
    }

    public function newAction()
    {
        $entity = new Document();

        $form = $this->createUploadForm($entity);

        $form->add('submit', 'submit', array('label' => 'Upload'));

        return $this->render( 'JJWeddingBundle:Document:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView()
        ));
    }

    /**
    * Creates a form to create a Document entity.
    *
    * @param Document $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createUploadForm(Document $entity)
    {
        $form = $this->createForm(new DocumentType(), $entity, array(
            'action' => $this->generateUrl('document_upload'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Upload'));

        return $form;
    }

    public function uploadAction(Request $request)
    {
        $entity = new Document();

        $form = $this->createUploadForm($entity);

        $form->handleRequest($request);

        if ( $form->isValid() ) {
            if ( $entity->getFilename() === null ) {
                $entity->setFilename( $entity->getFile()->getClientOriginalName() );
            }

            $em = $this->getDoctrine()->getManager();

            $em->persist($entity);
            $em->flush();

            return $this->redirect( $this->generateUrl( 'document' ) );
        }

        return $this->render( 'JJWeddingBundle:Document:upload.html.twig', array(
            'document' => $document,
            'form' => $form->createView()
        ));
    }

    public function downloadAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository( 'JJWeddingBundle:Document' )->find( $id );

        if ( !$entity ) {
            throw $this->createNotFoundException( 'Unable to find the document' );
        }

        $headers = array(
            'Content-Type' => $entity->getMimeType() ? '' : 'file',
            'Content-Disposition' => 'attachment; filename="' . $entity->getFilename() . '"'
        );

        $filename = $entity->getAbsolutePath();

        return new Response(file_get_contents($filename), 200, $headers);
    }

    /**
     * Finds and displays a Document entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JJWeddingBundle:Document')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JJWeddingBundle:Document:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Document entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JJWeddingBundle:Document')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JJWeddingBundle:Document:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Document entity.
    *
    * @param Document $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Document $entity)
    {
        $form = $this->createForm(new DocumentMetaType(), $entity, array(
            'action' => $this->generateUrl('document_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Document entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JJWeddingBundle:Document')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('document_show', array('id' => $id)));
        }

        return $this->render('JJWeddingBundle:Document:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Document entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JJWeddingBundle:Document')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Document entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('document'));
    }

    /**
     * Creates a form to delete a Document entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('document_delete', array('id' => $id)))
            ->setMethod('POST')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}