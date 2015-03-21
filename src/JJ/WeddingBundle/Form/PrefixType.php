<?php

namespace JJ\WeddingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PrefixType extends AbstractType
{
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices'  => array(
                'Mr'   => 'Mr',
                'Mrs'  => 'Mrs',
                'Ms'   => 'Ms',
                'Miss' => 'Miss',
                'Dr'   => 'Dr',
                'Prof' => 'Prof',
                'Rev'  => 'Rev',
                'Hon'  => 'Hon',
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
        return 'prefix';
    }
}
