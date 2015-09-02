<?php

namespace AWBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class awType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('aw_visibility')
            ->add('aw_status')
            ->add('aw_date')
            ->add('aw_title')
            ->add('aw_ad')
            ->add('awSave', 'submit')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AWBundle\Entity\aw'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'awbundle_aw';
    }
}
