<?php

namespace JJ\WeddingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrantType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName')
            ->add('firstName')
            ->add('middleName')
            ->add('prefix', new PrefixType(), array(
                'required'    => false,
                'empty_value' => 'Prefix',
                'empty_data'  => null
            ))
            ->add('suffix', new SuffixType(), array(
                'required'    => false,
                'empty_value' => 'Suffix',
                'empty_data'  => null
            ))
            ->add('street1')
            ->add('street2')
            ->add('city')
            ->add('state')
            ->add('zip')
            ->add('gender', new GenderType(), array(
                'required'    => false,
                'empty_value' => 'Gender',
                'empty_data'  => null
            ))
            ->add('headOfParty')
            ->add('orderInParty')
            ->add('adultOrChild', new AdultChildType(), array(
                'required'    => false,
                'empty_value' => 'Adult/Child',
                'empty_data'  => null
            ))
            ->add('phone')
            ->add('email')
            ->add('party')
            ->add('rsvpType', new RsvpTypeType(), array(
                'required'    => false,
                'empty_value' => 'RSVP Type',
                'empty_data'  => null
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
            'data_class' => 'JJ\WeddingBundle\Entity\Registrant'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jj_weddingbundle_registrant';
    }
}
