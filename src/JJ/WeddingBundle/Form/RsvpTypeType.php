<?php

namespace JJ\WeddingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RsvpTypeType extends AbstractType
{
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array(
                'Yes' => 'Attending',
                'No'  => 'Not Attending',
            )
        ));
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rsvp';
    }
}
