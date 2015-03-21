<?php

namespace JJ\WeddingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use JJ\WeddingBundle\Entity\Block;
use JJ\WeddingBundle\Form\SearchType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JJWeddingBundle:Block')->findAll();
        $pins     = $em->getRepository('JJWeddingBundle:Pin')->findAll();
        $photos   = $em->getRepository('JJWeddingBundle:Document')->findAll();

        foreach ($photos as $k => $v) {
            $images[$v->getFilename()] = $v->getWebPath();
        }

        foreach ($pins as $k => $v) {
            $placeholders[$v->getName()] = $v->getDescription();
        }

        // PHOTOS!!!
        $foos = array();
        $bars = array();
        foreach ($images as $k => $v) {

            array_push($foos, '/\[(photo:' . $k . ')\]/');

            // string to put directly in the "src" of the tag <img>
            $cacheManager = $this->container->get('liip_imagine.cache.manager');
            $srcPath = $cacheManager->getBrowserPath($v, 'medium');

            array_push($bars, '<img src="' . $srcPath . '" alt="image" class="img-responsive" />');
        }

        // loop through entities
        // find all the photo placeholders and put the photos in them
        foreach ($entities as $k => $v) {
            $v->setbody(preg_replace($foos, $bars, $v->getBody()));
        }

        // PINS!!!
        // set patterns
        $patterns = array();

        // set replacements
        $replacements = array();

        // loop through the pins as name => description
        foreach ($placeholders as $k => $v) {
            // put the name as the pattern
            array_push($patterns, '/\[(' . $k . ')\]/');
            // put the description as the replacement
            array_push($replacements, $v);
        }

        // loop through the entities
        foreach ($entities as $k => $v) {
            // replace every instance of pattern with replacement
            $v->setbody(preg_replace($patterns, $replacements, $v->getBody()));
        }

        // ICONS!!!
        // loop through the entities
        foreach ($entities as $k => $v) {
            // replace every instance of pattern with replacement
            $v->setbody(preg_replace('/\[icon:(.*)\]/', "<span class=\"fa fa-fw fa-$1\"></span>", $v->getBody()));
        }
        
        return $this->render('JJWeddingBundle::index.html.twig', array(
            'entities'     => $entities,
            'weddingstart' => '2014-09-20 14:00:00',
            'weddingstop'  => '2014-09-20 22:00:00',
            'referer'      => $referer,
        ));
    }

    public function manageAction(Request $request)
    {
        $searchForm = $this->createSearchForm();
        $searchForm->handleRequest($request);

        if ($searchForm->isValid()) {
            $content = $this->searchAction($request)->getContent();

            $serializer = $this->container->get('jms_serializer');
            $results = $serializer->deserialize($content, 'ArrayCollection<JJ\WeddingBundle\Entity\Registrant>', 'json');

            //echo '<pre>';var_dump($data);die;
        
            return $this->render('JJWeddingBundle::manage.html.twig', array(
                'search_form' => $searchForm->createView(),
                'results'     => $results,
                'last_search' => '',
            ));
        }

        return $this->render('JJWeddingBundle::manage.html.twig', array(
            'search_form' => $searchForm->createView(),
        ));
    }

    public function createSearchForm()
    {
        $form = $this->createFormBuilder()
            ->add('search', 'search')
            ->add('submit', 'submit', array(
                'label' => false,
            ))
            ->getForm();

        return $form;
    }

    public function searchAction(Request $request)
    {
        // first and foremost, if the form has been submitted
        if($request->getMethod() == 'GET'){
            // GET search string from url and decode it (ie %20)
            $query = $this->getRequest()->get(rawurldecode('query'));
        }
        else {
            $form = $this->getRequest()->get('form');
            $query = $form['search'];
        }

        // split the search terms by spaces,
        // making each token an individual search
        $queries = explode(' ', strtolower($query));

        // get entity manager
        $em = $this->getDoctrine()->getManager();
        
        // get query builder
        //$qb = $em->createQueryBuilder();

        // build query, below is essentially:
            // SELECT r.*, p.*
            //   FROM registrant r
            //   JOIN party p
            //     ON r.party_id = p.id
            //  WHERE (
            //             p.name        LIKE '%?%'
            //          OR r.first_name  LIKE '%?%'
            //          OR r.middle_name LIKE '%?%'
            //          OR r.last_name   LIKE '%?%'
            //        ) # this party is recursive,
            //          # for each search term
        /*
        $qb->select(array('r', 'p'));
        $qb->from('JJWeddingBundle:Registrant', 'r');
        $qb->innerJoin('r.party', 'p');
        
        $i = 0;
        foreach ($queries as $v) {
            $qb->orWhere('lower(p.name) LIKE ?' . $i)
               ->orWhere('lower(r.firstName) LIKE ?' . $i)
               ->orWhere('lower(r.middleName) LIKE ?' . $i)
               ->orWhere('lower(r.lastName) LIKE ?' . $i)
               ->orderBy('r.orderInParty', 'ASC')
               ->orderBy('r.gender', 'DESC')
               ->orderBy('r.adultOrChild', 'ASC')
               ->orderBy('r.headOfParty', 'ASC')
               ->orderBy('r.party', 'ASC')
               ->setParameter($i, '%' . $v . '%');
            $i++;
        } // end IF GET
        */
        $qb = $em->createQueryBuilder();
        $qb->select('p');
        $qb->from('JJWeddingBundle:Party', 'p');
        $qb->innerJoin('JJWeddingBundle:Registrant', 'r', 'WITH', 'r.party = p.id');
        
        $i = 0;
        foreach ($queries as $q) {
            $qb->orWhere('lower(p.name) LIKE ?' . $i)
               ->orWhere('lower(r.firstName) LIKE ?' . $i)
               ->orWhere('lower(r.middleName) LIKE ?' . $i)
               ->orWhere('lower(r.lastName) LIKE ?' . $i)
               ->orderBy('r.orderInParty', 'ASC')
               ->orderBy('r.gender', 'DESC')
               ->orderBy('r.adultOrChild', 'ASC')
               ->orderBy('r.headOfParty', 'ASC')
               ->orderBy('r.party', 'ASC')
               ->setParameter($i, '%' . $q . '%');
            $i++;
        } // end IF GET

        $entities = $qb->getQuery()->getResult();

        //echo '<pre>';
        //var_dump($entities);
        //exit;

        return $this->render('JJWeddingBundle::rsvpSearchResults.html.twig', array(
            'entities' => $entities,
        ));
    }
/*
    public function rsvpFormAction(Request $request)
    {
        // get the id from the request
        if($request->getMethod() == 'GET'){
            // GET partyId
            $partyId = $this->getRequest()->get(rawurldecode('query'));
        }

        // get entity manager
        $em = $this->getDoctrine()->getManager();
        
        $qb = $em->createQueryBuilder();
        $qb->select('p')
           ->from('JJWeddingBundle:Party', 'p')
           ->innerJoin('JJWeddingBundle:Registant', 'r', 'WITH', 'r.party = p.id')
           ->where('p.id = ?' . $i)
           ->orderBy('r.orderInParty', 'ASC')
           ->orderBy('r.gender', 'DESC')
           ->orderBy('r.adultOrChild', 'ASC')
           ->orderBy('r.headOfParty', 'ASC')
           ->orderBy('r.party', 'ASC')
           ->setParameter($i, $partyId);

        $entities = $qb->getQuery()->getResult();

        return $this->render('JJWeddingBundle::rsvpForm.html.twig', array(
            'entities' => $entities,
        ));
    }
*/
    public function searchFormAction()
    {
        // reloads search form
        return $this->render('JJWeddingBundle::rsvpSearchForm.html.twig', array());
    }

    public function galleryAction(Request $request, $galleryName)
    {
        // get entity manager
        $em = $this->getDoctrine()->getManager();
        
        // get query builder
        $qb = $em->createQueryBuilder();

        // build query, below is essentially:
            //    SELECT p.*
            //      FROM document p
            //     WHERE p.gallery_name = ?
            //  ORDER BY p.order_in_gallery
        $qb
            ->select(array('p'))
            ->from('JJWeddingBundle:Document', 'p')
            ->where('p.galleryName = ?1')
            ->orderBy('p.orderInGallery', 'ASC')
            ->setParameter(1, $galleryName);
        ;

        // get results
        $entities = $qb->getQuery()->getResult();

        return $this->render('JJWeddingBundle::gallery.html.twig', array(
            'entities' => $entities,
        ));
    }

    public function recacheAction()
    {
        // get all images and motherfucking cache them
        $em = $this->getDoctrine()->getManager();

        $photos   = $em->getRepository('JJWeddingBundle:Document')->findAll();

        //foreach ($photos as $k => $v) {
        //    $images[$v->getFilename()] = $v->getWebPath();
        //}

        return $this->render('JJWeddingBundle:Document:all.html.twig', array(
            'photos' => $photos,
        ));
    }
}
