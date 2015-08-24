<?php

namespace AWBundle\Resources\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CreateAwForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder->add('awName', 'text', array('label' => 'Name'));
       $builder->add('awPlace', 'text', array('label' => 'Place'));
       $builder->add('awDate', 'date', array('label' => 'Date'));
       $builder->add('awSave', 'submit', array('label' => 'Create'));
       //$builder->add('aw');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AWBundle\Entity\aw',
        ));
    }

    public function getName()
    {
        return 'awCreate';
    }
}
