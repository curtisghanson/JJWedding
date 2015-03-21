<?php

namespace JJ\WeddingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BrideGroomType extends AbstractType
{
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array(
                'Bride' => 'Bride',
                'Groom' => 'Groom',
                'Both'  => 'Both'
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
        return 'bride_groom';
    }
}
