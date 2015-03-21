<?php

namespace JJ\WeddingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrantRsvpType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('rsvpType', new RsvpTypeType(), array(
                'required' => true,
                'expanded' => true,
                'multiple' => false
            ))
            ->add('recieveUpdates')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'JJ\WeddingBundle\Entity\Registrant',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jj_weddingbundle_registrant_rsvp';
    }
}
