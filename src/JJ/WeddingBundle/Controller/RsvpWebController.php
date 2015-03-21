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
 * RsvpWeb controller.
 *
 */
class RsvpWebController extends Controller
{

    /**
     * Checks rsvp to determine if party has already rsvp'd
     *
     */
    public function checkAction($partyId)
    {
        $em = $this->getDoctrine()->getManager();

        // check to see if the party is already registered
        $rsvp = $em->getRepository('JJWeddingBundle:Rsvp')->findOneBy(
            array('party' => $partyId)
        );

        // if not, make a new form
        if (!$rsvp) {
            $response = $this->forward('JJWeddingBundle:RsvpWeb:new', array(
                'partyId'  => $partyId,
            ));
        }
        // if so, make an edit form
        else {
            $response = $this->forward('JJWeddingBundle:RsvpWeb:edit', array(
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

            return $this->render('JJWeddingBundle:RsvpWeb:created.html.twig', array(
                'entity' => $entity,
            ));
        }

        return $this->render('JJWeddingBundle:RsvpWeb:new.html.twig', array(
            'entity'      => $entity,
            'form'        => $form->createView(),
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
            'action' => $this->generateUrl('rsvp_web_create'),
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
        //$referer   = $this->getRequest()->server->get('HTTP_REFERER');
        //$ip        = $this->getRequest()->server->get('HTTP_CLIENT_IP');
        //$userAgent = $this->getRequest()->server->get('HTTP_USER_AGENT');
        //$port      = $this->getRequest()->server->get('REMOTE_PORT');

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

        return $this->render('JJWeddingBundle:RsvpWeb:new.html.twig', array(
            'entity'    => $entity,
            'form'      => $form->createView(),
        ));
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

        return $this->render('JJWeddingBundle:RsvpWeb:edit.html.twig', array(
            'entity' => $entity,
            'form'   => $editForm->createView(),
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
            'action' => $this->generateUrl('rsvp_web_update', array('id' => $entity->getId())),
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

        $em = $this->getDoctrine()->getManager();
        
        $formObject = $request->request->get('jj_weddingbundle_rsvp');

        $partyId = $formObject['party'];
        
        $entity = new Rsvp();
        $entity = $em->getRepository('JJWeddingBundle:Rsvp')->find($id);
        $party = $em->getRepository('JJWeddingBundle:Party')->find($partyId);

        // get registrants object
        $registrants = $em->getRepository('JJWeddingBundle:Registrant')->findBy(
            array('party' => $partyId),
            array('orderInParty' => 'ASC', 'adultOrChild' => 'ASC')
        );


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rsvp entity.');
        }

        $editForm = $this->createEditForm($party, $entity);
        //return $this->render('JJWeddingBundle:RsvpWeb:updated.html.twig', array('form' => $formObject));
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

            return $this->render('JJWeddingBundle:RsvpWeb:updated.html.twig', array(
                'entity' => $entity,
            ));
        }

        return $this->render('JJWeddingBundle:RsvpWeb:edit.html.twig', array(
            'entity'      => $entity,
            'form'        => $editForm->createView(),
            'form_errors' => $formErrors,
        ));
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
