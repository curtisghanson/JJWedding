<?php

namespace JJ\WeddingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SuffixType extends AbstractType
{
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array(
                'Jr'  => 'Jr',
                'Sr'  => 'Sr',
                'II'  => 'II',
                'III' => 'III',
                'IV'  => 'IV',
                'V'   => 'V',
                'VI'  => 'VI',
                'Ret' => 'Ret',
                'Esq' => 'Esq',
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
        return 'suffix';
    }
}
