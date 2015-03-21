<?php

namespace JJ\WeddingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentMetaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('filename', null, array('required' => false))
            ->add('title')
            ->add('description')
            ->add('galleryName')
            ->add('orderInGallery')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults( array(
            ));
    }

    public function getName()
    {
        return 'jj_weddingbundle_documentmeta';
    }
}