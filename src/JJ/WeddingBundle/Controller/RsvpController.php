<?php

namespace JJ\WeddingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use JJ\WeddingBundle\Entity\Rsvp;
use JJ\WeddingBundle\Form\RsvpType;

use JJ\WeddingBundle\Entity\Party;
use JJ\WeddingBundle\Form\RsvpPartyType;

use JJ\WeddingBundle\Entity\Registrant;

/**
 * Rsvp controller.
 *
 */
class RsvpController extends Controller
{

    /**
     * Lists all Rsvp entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities    = $em->getRepository('JJWeddingBundle:Rsvp')->findAll();
        //$registrants = $em->getRepository('JJWeddingBundle:Registrant')->findAll();

        return $this->render('JJWeddingBundle:Rsvp:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    public function checkAction($partyId)
    {
        $em = $this->getDoctrine()->getManager();

        // check to see if the party is already registered
        $rsvp = $em->getRepository('JJWeddingBundle:Rsvp')->findOneBy(
            array('party' => $partyId)
        );

        // if not, make a new form
        if (!$rsvp) {
            $response = $this->forward('JJWeddingBundle:Rsvp:new', array(
                'partyId'  => $partyId,
            ));
        }
        // if so, make an edit form
        else {
            $response = $this->forward('JJWeddingBundle:Rsvp:edit', array(
                'id'  => $rsvp->getId(),
            ));
        }

        // here is where we'll also web statistics when i get it up and running

        return $response;
    }

    /**
     * Creates a new Rsvp entity.
     *
     */
    public function createAction(Request $request)
    {

        $formObject = $request->request->get('jj_weddingbundle_rsvp');
        $partyId = $formObject['party'];
        
        $entity = new Rsvp();
        $em = $this->getDoctrine()->getManager();
        $party = $em->getRepository('JJWeddingBundle:Party')->find($partyId);

        // get registrants object
        $registrants = $em->getRepository('JJWeddingBundle:Registrant')->findBy(
            array('party' => $partyId),
            array('orderInParty' => 'ASC', 'adultOrChild' => 'ASC')
        );
        
        // add registrants to rsvp object
        foreach ($registrants as $k => $v) {
            $entity->getRegistrants()->add($v);
        }
        
        $form = $this->createCreateForm($party, $entity);
        $form->handleRequest($request);

        $formErrors = $this->validateForm($form);

        if (true === $formErrors['isValid']) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            foreach ($registrants as $k => $v) {
                $v->setRsvp($entity);
                $em->persist($v);
            }

            $em->flush();

            return $this->redirect($this->generateUrl('rsvp_show', array('id' => $entity->getId())));
        }

        return $this->render('JJWeddingBundle:Rsvp:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'form_errors' => $formErrors,
        ));
    }

    /**
    * Creates a form to create a Rsvp entity.
    *
    * @param Rsvp $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Party $party, Rsvp $entity)
    {
        $form = $this->createForm(new RsvpType($party), $entity, array(
            'action' => $this->generateUrl('rsvp_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Rsvp entity.
     *
     */
    public function newAction($partyId)
    {

        $entity = new Rsvp();
        $em = $this->getDoctrine()->getManager();
        $party = $em->getRepository('JJWeddingBundle:Party')->find($partyId);

        // get registrants object
        $registrants = $em->getRepository('JJWeddingBundle:Registrant')->findBy(
            array('party' => $partyId),
            array('orderInParty' => 'ASC', 'adultOrChild' => 'ASC')
        );
        
        // add registrants to rsvp object
        foreach ($registrants as $k => $v) {
            $entity->getRegistrants()->add($v);
        }

        $form   = $this->createCreateForm($party, $entity);

        return $this->render('JJWeddingBundle:Rsvp:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Rsvp entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JJWeddingBundle:Rsvp')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rsvp entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JJWeddingBundle:Rsvp:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Rsvp entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JJWeddingBundle:Rsvp')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rsvp entity.');
        }

        $party = $em->getRepository('JJWeddingBundle:Party')->find($entity->getParty());

        $editForm = $this->createEditForm($party, $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JJWeddingBundle:Rsvp:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));

    }

    /**
    * Creates a form to edit a Rsvp entity.
    *
    * @param Rsvp $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Party $party, Rsvp $entity)
    {
        $form = $this->createForm(new RsvpType($party), $entity, array(
            'action' => $this->generateUrl('rsvp_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Rsvp entity.
     *
     */
    public function updateAction(Request $request, $id)
    {

        $formObject = $request->request->get('jj_weddingbundle_rsvp');
        $partyId = $formObject['party'];

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JJWeddingBundle:Rsvp')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rsvp entity.');
        }

        $party = $em->getRepository('JJWeddingBundle:Party')->find($partyId);

        // get registrants object
        $registrants = $em->getRepository('JJWeddingBundle:Registrant')->findBy(
            array('party' => $partyId),
            array('orderInParty' => 'ASC', 'adultOrChild' => 'ASC')
        );

        // add registrants to rsvp object
        foreach ($registrants as $k => $v) {
            $entity->getRegistrants()->add($v);
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($party, $entity);
        $editForm->handleRequest($request);

        $formErrors = $this->validateForm($editForm);

        if (true === $formErrors['isValid']) {
            $entity->setReferer($formObject['referer']);
            $entity->setUserAgent($formObject['userAgent']);
            $entity->setIp($formObject['ip']);
            $entity->setPort($formObject['port']);
            $entity->setComment($formObject['comment']);
            $em->persist($entity);

            $i = 0;
            foreach ($registrants as $k => $v) {

                $v->setRsvp($entity);
                $v->setRsvpType($formObject['registrants'][$i]['rsvpType']);
                $v->setEmail($formObject['registrants'][$i]['email']);
                $v->setRecieveUpdates($formObject['registrants'][$i]['recieveUpdates']);
                $em->persist($v);
                $i++;
            }
            $em->flush();

            return $this->redirect($this->generateUrl('rsvp_show', array('id' => $id)));
        }

        return $this->render('JJWeddingBundle:Rsvp:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'form_errors' => $formErrors,
        ));
    }
        
    /**
     * Deletes a Rsvp entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JJWeddingBundle:Rsvp')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Rsvp entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('rsvp'));
    }

    /**
     * Creates a form to delete a Rsvp entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rsvp_delete', array('id' => $id)))
            ->setMethod('POST')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    private function validateForm($form)
    {
        
        $formErrors = array('isValid' => true);
        $fieldErrors = array();

        $data = $form->getData();
        $regs = $data->getRegistrants();

        foreach ($regs as $k => $v) {
            $v->setEmail(strtolower($v->getEmail()));
            
            $receiveUpdates = $v->getRecieveUpdates();
            $email          = $v->getEmail();
            $rsvpType       = $v->getRsvpType();
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)) {
                $formErrors['isValid'] = false;
                array_push($fieldErrors, array(
                    'name' => 'email',
                    'message' => 'Email must be a valid address.',
                ));
            }

            if(true === $receiveUpdates && empty($email)){
                $formErrors['isValid'] = false;
                array_push($fieldErrors, array(
                    'name' => 'updates',
                    'message' => 'Email cannot be blank while Updates is checked.',
                ));
            }

            if(empty($rsvpType)){
                $formErrors['isValid'] = false;
                array_push($fieldErrors, array(
                    'name' => 'rsvp',
                    'message' => 'RSVP must be checked.',
                ));
            }

        }

        $formErrors['fields'] = $fieldErrors;

        //ar_dump($formErrors);exit;

        return $formErrors;

    }
}
