<?php

namespace BookReview\BookBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReviewType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('review')
            ->add('rating', 'choice', array(
                'choices' => array(1 => 'Very Poor', 2  => 'Poor', 3 => 'OK', 4=> 'Great', 5 => 'Excellent'),
                'expanded' => true,  // radio or checkbox...
                'multiple' => false  // ...but not checkbox
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BookReview\BookBundle\Entity\Review'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bookreview_bookbundle_review';
    }
}
