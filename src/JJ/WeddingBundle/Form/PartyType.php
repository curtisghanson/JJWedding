<?php

namespace JJ\WeddingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PartyType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('brideOrGroom', new BrideGroomType(), array(
                'empty_value' => 'Bride/Groom'
            ))
            //->add('rsvp')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JJ\WeddingBundle\Entity\Party'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jj_weddingbundle_party';
    }
}
