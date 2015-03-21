<?php

namespace JJ\WeddingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use JJ\WeddingBundle\Entity\Party;

class RsvpType extends AbstractType
{

    protected $party;

    public function __construct (Party $party)
    {
        $this->party = $party;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment')
            ->add('referer', 'hidden')
            ->add('userAgent', 'hidden')
            ->add('ip', 'hidden')
            ->add('port', 'hidden')
            ->add('party', 'entity', array(
                    'class' => 'JJ\WeddingBundle\Entity\Party',
                    'data' => $this->party,
                    'attr' => array('style' => 'display:none;')
            ))
            ->add('registrants', 'collection', array('type' => new RegistrantRsvpType()))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'JJ\WeddingBundle\Entity\Rsvp',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jj_weddingbundle_rsvp';
    }
}
