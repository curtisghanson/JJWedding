<?php

namespace JJ\WeddingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('file', 'file')
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
        return 'jj_weddingbundle_document';
    }
}